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
            <h6 class="page-subtitle">Customers</h6>
            <div class="card shadow-sm border-0 mb-4" id="orders">
                <?php foreach ($pagination->getItems()  as $key => $customer): ?>
                    <div id="accordianId" role="tablist" class="card-body border-top order">
                        <div class="media mt-2">
                            <figure class="icons icon-40 mr-2 bg-light-primary">
                                <i class="material-icons">account_circle</i>
                            </figure>
                            <div class="media-body">
                                <a data-toggle="collapse" data-parent="#accordianId" href="#downlines<?=$customer['user_id']?>" aria-expanded="true" aria-controls="downlines<?=$customer['user_id']?>"><h6 class="mb-1"><?=$customer['fname'].' '.$customer['lname']?>  </h6>
                                <p class="mb-0 text-mute small">&#x20a6;<?=price($customer['p_wallet']+$customer['c_wallet'])?></p></a>
                            </div>
                                    <div id="downlines<?=$customer['user_id']?>" class="collapse in" role="tabpanel" aria-labelledby="section1HeaderId">
                                        <div class="card-body">
                                            <ul class="list-group">
                                            <?php foreach ($customer['downlines']  as $key => $dlines): ?>
                                                <li class="list-group-item"><?=$dlines['user_id'].':'.$dlines['fname'].' '.$dlines['lname']?></li>
                                            <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <nav aria-label="Page navigation">
                  <ul class="pagination justify-content-center">
                    <li class="page-item">
                      <a class="page-link" href="?page=<?=$pagination->getFirstPageNumber()?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">Previous</span>
                      </a>
                    </li>
                    <?php foreach ($pagination->getPages() as $page):?>
                    <?php if ($page == $current):?>
                    <li class="page-item active"><a class="page-link" href="?page=<?=$page?>"><?=$page?></a></li>
                    <?php else: ?>
                    <li class="page-item"><a class="page-link" href="?page=<?=$page?>"><?=$page?></a></li>
                    <?php endif; ?>
                    <?php endforeach; ?>
                    <li class="page-item">
                      <a class="page-link" href="?page=<?=$pagination->getLastPageNumber()?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Next</span>
                      </a>
                    </li>
                  </ul>
                </nav>
            </div>
        </div>
    </main>
    <!-- End of page content -->
