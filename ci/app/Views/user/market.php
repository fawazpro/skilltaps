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
        <h6 class="page-subtitle">Market</h6>
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row">
                    <?php foreach ($pagination->getItems() as $key => $prod) : ?>
                        <div class="col-6 col-md-4 col-lg-3 p-1">
                            <a href="details?sku=<?= $prod['id'] ?>">
                                <div class="shadow card overflow-hidden border-0">
                                    <div class="card-img p-1">
                                        <img class="" src="<?= $dir_img ?><?= $prod['image'] ?>" height="150" alt="">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="font-weight-normal my-0"><a href="#!"><?= $prod['name'] ?></a></h5>
                                        <p><span class="float-right">&#x20a6;<?= price($prod['price']) ?></span></p>
                                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#buy<?= $prod['id'] ?>">
                                            Buy Now
                                        </button>
                                    </div>
                                    <!-- Modal -->
                                    <div class="mt-5 modal fade" id="buy<?= $prod['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Buy <?= $prod['name'] ?>?</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <p class="col-4">Product/Service: &#x20a6;<?= price($prod['price']) ?></p>
                                                            <div class="col-4"></div>
                                                            <p class="col-4">Product Wallet: &#x20a6;<?= price($user['p_wallet']) ?><i></i></p>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col">
                                                                <?= $prod['details'] ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <a href="#" data-dismiss="modal" title="Add to Cart" data-name="<?= $prod['name'] ?>" data-img=<?= $prod['image'] ?> data-price="<?= $prod['price'] ?>" style="font-size: smaller;" class="btn btn-outline-danger add-to-cart">Add to Cart</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
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
</main>
<!-- End of page content -->