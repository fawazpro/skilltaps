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
                        <p class="mb-2">Orders & Withdrawals: <small class="text-light h5"><?= $ord_count ?></small></p>
                        <div class="progress bg-light-primary h-5 mb-2">
                            <div class="progress-bar bg-white" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div><div class="progress-bar bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 5%"></div>
                        </div>
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
            <div class="container mb-4 px-2">
                <h6 class="page-subtitle">Statistics</h6>

                <div class="swiper-container swiper-offers">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide w-auto p-2">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body w-250 text-center">
                                            <h6 class="display-3 "><?=$prod_count?></h6>
                                            <p class="text-capitalize">Total number of products & services</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide w-auto p-2">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body w-250 text-center">
                                            <h6 class="display-3 "><?=$cust_count?></h6>
                                            <p class="text-capitalize">Total number of <span class="text-danger">customers</span> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide w-auto p-2">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body w-250 text-center">
                                            <h6 class="display-3 "><?=$admin_count?></h6>
                                            <p class="text-capitalize">Total number of <span class="text-success">admins</span> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide w-auto p-2">
                            <div class="card shadow-sm border-0">
                                <div class="card-body">
                                    <div class="media">
                                        <div class="media-body w-250 text-center">
                                            <h6 class="display-3 "><?=$order_count?></h6>
                                            <p class="text-capitalize">Total number of <span class="text-success">Orders</span> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="container">
                    <h6 class="page-subtitle">Quick Bills</h6>
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="font-weight-normal mb-1">$ 1048.00 </h5>
                                    <p class="text-mute small text-secondary mb-2">20d to pay electricity bill</p>
                                    <div class="progress h-5 bg-light-warning">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width:35%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center">
                                    <button class="btn btn-44 default-shadow border-0 bg-default">
                                        <i class="material-icons">local_atm</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm border-0 mb-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="font-weight-normal mb-1">$ 150.00 </h5>
                                    <p class="text-mute small text-secondary mb-2">5d to pay telephone bill</p>
                                    <div class="progress h-5 bg-light-danger">
                                        <div class="progress-bar bg-danger" role="progressbar" style="width:80%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-auto align-self-center">
                                    <button class="btn btn-44 default-shadow border-0 bg-default">
                                        <i class="material-icons">local_atm</i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
        </div>
    </div>
</main>

<!-- End of page content -->