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
<main class="flex-shrink-0 main-container">
        <!-- page content goes here -->
        <div class="container my-4">
            <!-- <div class="form-group">
                <input type="text" class="form-control datepicker" placeholder="Select Date">
            </div> -->
        </div>
        <div class="container">
            <h6 class="page-subtitle">Orders</h6>
            <div class="card shadow-sm border-0 mb-4" id="orders">
                
            <?php foreach ($orders  as $key => $order) : ?>
                        <div class="row mb-2">
                            <?php if ($order['type'] == 'p') : ?>
                                <?php if ($order['status'] == 'Pending') :  ?>
                                    <div class="card-body border-top order">
                                        <?php foreach (json_decode($order['orders']) as $key => $ord) : ?>
                                            <div class="media mt-2">
                                                <figure class="icons icon-40 mr-2 bg-light-warning">
                                                    <i class="material-icons">query_builder</i>
                                                </figure>
                                                <div class="media-body">
                                                    <h6 class="mb-1"><?= $ord->name ?> <span class="text-danger">x<?= $ord->count ?></span> </h6>
                                                    <p class="mb-0 text-mute small">&#x20a6;<?= price($ord->total) ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php elseif ($order['status'] == 'Cancelled') : ?>
                                    <div class="card-body border-top order">
                                        <?php foreach (json_decode($order['orders']) as $key => $ord) : ?>
                                            <div class="media mt-2">
                                                <figure class="icons icon-40 mr-2 bg-light-danger">
                                                    <i class="material-icons">cancel</i>
                                                </figure>
                                                <div class="media-body">
                                                    <h6 class="mb-1"><?= $ord->name ?> <span class="text-danger">x<?= $ord->count ?></span> </h6>
                                                    <p class="mb-0 text-mute small">&#x20a6;<?= price($ord->total) ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php elseif ($order['status'] == 'Completed') : ?>
                                    <div class="card-body border-top order">
                                        <?php foreach (json_decode($order['orders']) as $key => $ord) : ?>
                                            <div class="media mt-2">
                                                <figure class="icons icon-40 mr-2 bg-light-success">
                                                    <i class="material-icons">check</i>
                                                </figure>
                                                <div class="media-body">
                                                    <h6 class="mb-1"><?= $ord->name ?> <span class="text-danger">x<?= $ord->count ?></span> </h6>
                                                    <p class="mb-0 text-mute small">&#x20a6;<?= price($ord->total) ?></p>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <!-- <p class="float-left"><?= $key + 1 ?>)</p>
                                        <p class="h4"><span><?= type($order['type']) ?> <?= $order['order_id'] ?> <span class="float-right"> <i class="material-icons">send</i></span></p> -->
                            <?php elseif ($order['type'] == 'c') : ?>
                                <?php if ($order['status'] == 'Pending') :  ?>
                                    <div class="card-body border-top order">
                                        <div class="media mt-2">
                                            <figure class="icons icon-40 mr-2 bg-light-warning">
                                                <i class="material-icons">query_builder</i>
                                            </figure>
                                            <div class="media-body">
                                                <h6 class="mb-1"><?= type($order['type']) ?></h6>
                                                <p class="mb-0 text-mute small">&#x20a6;<?= price($order['orders']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif ($order['status'] == 'Cancelled') : ?>
                                    <div class="card-body border-top order">
                                        <div class="media mt-2">
                                            <figure class="icons icon-40 mr-2 bg-light-danger">
                                                <i class="material-icons">cancel</i>
                                            </figure>
                                            <div class="media-body">
                                                <h6 class="mb-1"><?= type($order['type']) ?></h6>
                                                <p class="mb-0 text-mute small">&#x20a6;<?= price($order['orders']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php elseif ($order['status'] == 'Completed') : ?>
                                    <div class="card-body border-top order">
                                        <div class="media mt-2">
                                            <figure class="icons icon-40 mr-2 bg-light-success">
                                                <i class="material-icons">check</i>
                                            </figure>
                                            <div class="media-body">
                                                <h6 class="mb-1"><?= type($order['type']) ?></h6>
                                                <p class="mb-0 text-mute small">&#x20a6;<?= price($order['orders']) ?></p>
                                            </div>
                                        </div>
                                    </div>
                            <?php endif;
                            endif; ?>
                        </div>
                    <?php endforeach; ?>
            </div>
        </div>
    </main>
    <!-- End of page content -->
