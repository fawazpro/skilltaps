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
        <nav aria-label="Page breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page"><a href="market"> <h6 class="">Market </h6></a></li>
                <li class="breadcrumb-item">Product Page </li>
            </ol>
        </nav>
       
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row">
                    
                   <div class="col text-left"><h4 class="text-center display-4 mb-3"><?= $product['name'] ?></h4>
                <img class="img-fluid p-4" src="<?=$dir_img?><?= $product['image'] ?>" alt="">
                <?=$product['details'] ?></div>
                <div class="col-12 text-center my-3">
                    <a href="#" title="Add to Cart" data-name="<?= $product['name'] ?>" data-img=<?= $product['image'] ?> data-price="<?= $product['price'] ?>" style="font-size: smaller;" class="col-12 btn btn-outline-danger add-to-cart">Add to Cart</a>

                </div>
                
                </div>
        </div>
    </div>
</main>
<!-- End of page content -->