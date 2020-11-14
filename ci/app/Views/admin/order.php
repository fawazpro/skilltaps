<?php
function price(int $pri)
{
    $len =  mb_strlen($pri);
    if ($len == 4) {
        $end = substr($pri, -3);
        $first = substr($pri, 0, 1);
        return $first . ',' . $end;
    } elseif ($len == 3) {
        return $pri;
    } elseif ($len == 2) {
        return $pri;
    } elseif ($len == 1) {
        return $pri;
    } elseif ($len == 5) {
        $end = substr($pri, -3);
        $first = substr($pri, 0, 2);
        return $first . ',' . $end;
    } elseif ($len == 6) {
        $end = substr($pri, -3);
        $first = substr($pri, 0, 3);
        return $first . ',' . $end;
    } elseif ($len == 7) {
        $end = substr($pri, -3);
        $mid = substr($pri, -6, 3);
        $first = substr($pri, 0, 1);
        return $first . ',' . $mid . ',' . $end;
    } elseif ($len == 8) {
        $end = substr($pri, -3);
        $mid = substr($pri, -6, 3);
        $first = substr($pri, 0, 2);
        return $first . ',' . $mid . ',' . $end;
    }
}

function type($t)
{
    if ($t == 'p') {
        return 'Order';
    } else if ($t == 'c') {
        return 'Withdrawal';
    }
}

?>
<!-- Begin page content -->
<main class="flex-shrink-0 main-container pb-0">
    <!-- page content goes here -->
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="container mt-4">
                <div class="card border-0 shadow bg-default text-white">
                    <div class="card-body">
                        <p class="mb-2">New Orders & Withdrawals: <small class="text-light h5"><?= $count ?></small></p>

                        <?php foreach ($orders  as $key => $order) : ?>
                            <div class="row mb-2">
                                <?php if ($order['type'] == 'p') : ?>
                                    <a class="col btn btn-outline-light-primary" data-toggle="modal" data-target="#fulfilment<?= $order['order_id'] ?>">
                                        <p class="float-left"><?= $key + 1 ?>)</p>
                                        <p class="h4"><span><?= type($order['type']) ?> <?= $order['order_id'] ?> by </span> <?= $order['user_id'] ?> <span class="float-right"> <i class="material-icons">send</i></span></p>
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade mt-5 text-dark" id="fulfilment<?= $order['order_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="withdrawal" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Order Fulfillment</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="container">
                                                            <h5>Ordered Products</h5>
                                                            <ul class="list-group">
                                                                <?php foreach (json_decode($order['orders']) as $key => $ord) : ?>
                                                                    <li class="list-group-item "><?= $ord->name ?><span class="text-danger">x<?= $ord->count ?></span> <span class="float-right">&#x20a6;<?= price($ord->price) ?></span></li>
                                                            </ul>
                                                        <?php endforeach; ?>
                                                        <form method="post" action="fulfillorder">
                                                            <div class="col text-center">
                                                                <label for="inputName" class="col-sm-1-12 col-form-label">Status: </label>
                                                            </div>
                                                            <div class="form-group col">
                                                                <div class="col-sm-1-12">
                                                                    <select name="status" class="form-control" id="">
                                                                        <option value="">Choose a Status</option>
                                                                        <option value="Pending">Pending</option>
                                                                        <option value="Cancelled">Cancelled</option>
                                                                        <option value="Completed">Completed</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="id" value="<?= $order['order_id'] ?>">

                                                        </div>
                                                        <p class="text-center text-dark-50 h6">Present Status: <?= $order['status'] ?></p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button></form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                <?php elseif ($order['type'] == 'c') : ?>
                                    <a class="col btn btn-outline-light-primary" data-toggle="modal" data-target="#withdraw<?= $order['order_id'] ?>">
                                        <p class="float-left"><?= $key + 1 ?>)</p>
                                        <p class="h5"><span><?= type($order['type']) ?> of </span> &#x20a6;<?= price($order['orders']) ?> by <?= $order['user_id'] ?> <span class="float-right"> <i class="material-icons">send</i></span></p>
                                    </a>
                                    <!-- Modal -->
                                    <div class="modal fade mt-5 text-dark" id="withdraw<?= $order['order_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="withdrawal" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Withdrawal Fulfillment</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="container">
                                                            <form method="post" action="fulfillwithdraw">

                                                                <input type="hidden" name="id" value="<?= $order['order_id'] ?>">
                                                        </div>
                                                        <p class="text-center text-dark-50 h6"><?= $order['user_id'] ?> Bank: <?= $order['bank'] ?></p>
                                                        <p class="text-center text-dark-50 h6"><?= $order['user_id'] ?> Acc Name: <?= $order['acc_name'] ?></p>
                                                        <p class="text-center text-dark-50 h6"><?= $order['user_id'] ?>Acc Number: <?= $order['acc_num'] ?></p>
                                                        <p class="text-center text-dark-50 h6"><?= $order['user_id'] ?>Phone Number: <?= $order['phone'] ?></p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Transferred</button></form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Modal -->
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>

                        <!-- <p>ID: <span class="text-mute"> </span> <span class="float-right">Product Wallet:</span></p> -->
                    </div>
                </div>
            </div>


            <div class="container">
                <h6 class="page-subtitle">Orders</h6>
                <div class="card shadow-sm border-0 mb-4" id="orders">
                    <?php foreach ($pagination->getItems()  as $key => $order) : ?>
                        <?php if ($order['type'] == 'p') : ?>
                            <a style="cursor: pointer;" data-toggle="modal" data-target="#fulfilment<?= $order['order_id'] ?>">
                                <div class="card-body border-top order">
                                    <div class="media mt-2">
                                        <figure class="icons icon-40 mr-2 bg-light-danger">
                                            <i class="material-icons">send</i>
                                        </figure>
                                        <div class="media-body">
                                            <h6 class="mb-1"><?= type($order['type']) ?> <?= $order['order_id'] ?> by </span> <?= $order['user_id'] ?> </h6>
                                            <p class="mb-0 text-mute small"><?= $order['status'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- Modal -->
                            <div class="modal fade mt-5 text-dark" id="fulfilment<?= $order['order_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="withdrawal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Order Fulfillment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="container">
                                                    <h5>Ordered Products</h5>
                                                    <ul class="list-group">
                                                        <?php foreach (json_decode($order['orders']) as $key => $ord) : ?>
                                                            <li class="list-group-item "><?= $ord->name ?><span class="text-danger">x<?= $ord->count ?></span> <span class="float-right">&#x20a6;<?= price($ord->price) ?></span></li>
                                                    </ul>
                                                <?php endforeach; ?>
                                                <form method="post" action="fulfillorder">
                                                    <div class="col text-center">
                                                        <label for="inputName" class="col-sm-1-12 col-form-label">Status: </label>
                                                    </div>
                                                    <div class="form-group col">
                                                        <div class="col-sm-1-12">
                                                            <select name="status" class="form-control" id="">
                                                                <option value="">Choose a Status</option>
                                                                <option value="Pending">Pending</option>
                                                                <option value="Cancelled">Cancelled</option>
                                                                <option value="Completed">Completed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="id" value="<?= $order['order_id'] ?>">

                                                </div>
                                                <p class="text-center text-dark-50 h6">Present Status: <?= $order['status'] ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button></form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                        <?php elseif ($order['type'] == 'c') : ?>
                            <a style="cursor: pointer;" data-toggle="modal" data-target="#withdraw<?= $order['order_id'] ?>">
                                <div class="card-body border-top order">
                                    <div class="media mt-2">
                                        <figure class="icons icon-40 mr-2 bg-light-danger">
                                            <i class="material-icons">send</i>
                                        </figure>
                                        <div class="media-body">
                                            <h6 class="mb-1"><?= type($order['type']) ?> of </span> &#x20a6;<?= price($order['orders']) ?> by <?= $order['user_id'] ?> </h6>
                                            <p class="mb-0 text-mute small"><?= $order['status'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <!-- Modal -->
                            <div class="modal fade mt-5 text-dark" id="withdraw<?= $order['order_id'] ?>" tabindex="-1" role="dialog" aria-labelledby="withdrawal" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Withdrawal Fulfillment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="container">
                                                    <form method="post" action="fulfillwithdraw">

                                                        <input type="hidden" name="id" value="<?= $order['order_id'] ?>">
                                                </div>
                                                <p class="text-center text-dark-50 h6"><?= $order['user_id'] ?> Bank: <?= $order['bank'] ?></p>
                                                <p class="text-center text-dark-50 h6"><?= $order['user_id'] ?> Acc Name: <?= $order['acc_name'] ?></p>
                                                <p class="text-center text-dark-50 h6"><?= $order['user_id'] ?>Acc Number: <?= $order['acc_num'] ?></p>
                                                <p class="text-center text-dark-50 h6"><?= $order['user_id'] ?>Phone Number: <?= $order['phone'] ?></p>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Transferred</button></form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal -->
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $pagination->getFirstPageNumber() ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <?php foreach ($pagination->getPages() as $page) : ?>
                                <?php if ($page == $current) : ?>
                                    <li class="page-item active"><a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a></li>
                                <?php else : ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?= $page ?>"><?= $page ?></a></li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <li class="page-item">
                                <a class="page-link" href="?page=<?= $pagination->getLastPageNumber() ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- End of page content -->