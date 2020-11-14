<div class="bg-white pb-5 mb-3">
    <div class="container-fluid bg-white account">

        <!-- Real arrangement -->
        <div class="row">
            <!-- card1 -->
            <div class="col-12 mb-3 mt-4">
                <div class="p-2 img-fluid ">
                    <div class="card bg-white r mt-5">
                        <div class="card-body pt-0 px-0 pb-2">
                            <h6 class="c-card__title text-uppercase text-white bg-primary text-center py-3 rtl rtr">
                                CheckOut Summary
                            </h6>
                            <div class="showCart"></div>
                            <div class="coupon"></div>
                            <div class="float-right pr-3" >Total price: &#x20a6;<span id="price" class="total-cart"></span></div> <br>
                            <div class="float-right pr-3" >Wallet Balance: &#x20a6;<span id="wallet"><?=$user['p_wallet'] ?></span></div>
                            <div class="clearfix"></div>
                            <form action="pay" method="post">
                                <div class="form-group" id="finalprice" >

                                </div>
                                <div class="form-group" id="finalorder" >

                                </div>
                                <button id="paybtn" type="submit" class="btn btn-danger text-center">Pay &#x20a6;<span class="total-cart"></span> from my wallet</button>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- card1 -->
    </div>
    <!-- Real arrangement -->

</div>
</div>