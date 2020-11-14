<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="RayyanTech">

    <title></title>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="assets/img/favicons/apple-touch-icon.html" sizes="180x180">
    <link rel="icon" href="assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="mask-icon" href="assets/img/favicons/safari-pinned-tab.html" color="#ffffff">
    <link rel="icon" href="assets/img/favicons/favicon.ico">

    <!-- Elegant font icons -->
    <link href="assets/vendor/elegant_font/HTMLCSS/style.css" rel="stylesheet">

    <!-- Elegant font icons -->
    <link href="assets/vendor/materializeicon/material-icons.css" rel="stylesheet">

    <!-- daterange picker -->
    <link href="assets/vendor/daterangepicker-master/daterangepicker.css" rel="stylesheet">

    <!-- Swiper Slider -->
    <link href="assets/vendor/swiper/css/swiper.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/style-blue.css" rel="stylesheet" id="style">
</head>

<body class="ui-rounded">
    <!-- Page laoder -->
    <!-- <div class="container-fluid pageloader">
        <div class="row h-100">
            <div class="col-12 align-self-start text-center">
            </div>
            <div class="col-12 align-self-center text-center">
                <div class="loader-logo">
                    <div class="logo">S
                        <div class="loader-roller">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                    <h4 class="logo-text">SkillHub<span></span><small>.NG</small></h4>
                </div>
            </div>
            <div class="col-12 align-self-end text-center">
                <p class="my-5">Please wait<br><small class="text-mute">A world of financial freedom is loading...</small></p>
            </div>
        </div>
    </div> -->
    <!-- Page laoder ends -->

    <!-- Fixed navbar -->
    <header class="header fixed-top">
        <nav class="navbar">
            <div>
                <button class="menu-btn btn btn-link btn-44">
                    <span class="icon material-icons">menu</span>
                </button>
            </div>
            <div>
                <a class="navbar-brand" href="<?= base_url()?>">
                    <div class="logo">S</div>
                    <h4 class="logo-text"><span>SkillHub</span><small>.NG</small></h4>
                </a>
            </div>
            <div>
                <form class="form-inline search">
                    <input class="form-control w-100" type="text" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-link btn-44" type="submit"><span class="icon_search"></span></button>
                </form>
                <button class="btn btn-link search-btn" type="button"><span class="icon_search"></span></button>
                <button class="btn btn-link" data-toggle="modal" data-target="#cart" type="button"><span class=""><i class="material-icons">shopping_cart</i><span class="total-count badge badge-pill badge-danger"></span></span></button>
                <a href="profile" class="btn btn-link p-2"><span class="avatar avatar-30"><i class="material-icons">account_circle</i></span></a>
            </div>
                <!-- <a href="logout" class="btn btn-link p-2"><span class="avatar avatar-30"><i class="material-icons">power_settings_new</i></span></a> -->
            </div>
        </nav>
    </header>
    <!-- Fixed navbar ends -->

    <!-- sidebar -->
    <div class="sidebar">
        <div class="row no-gutters">
            <div class="col pl-3 align-self-center">
                <a class="navbar-brand" href="index.html">
                    <div class="logo">S</div>
                    <h4 class="logo-text"><span>SkillHub</span><small>.NG</small></h4>
                </a>
            </div>
            <div class="col-auto align-self-center">
                <a href="logout" class="btn btn-link text-white p-2"><i class="material-icons">power_settings_new</i></a>
            </div>
        </div>
        <div class="list-group main-menu my-4">
            <a href="admindashboard" class="list-group-item list-group-item-action"><i class="material-icons">settings</i>Admin</a>
            <a href="profit" class="list-group-item list-group-item-action"><i class="material-icons">trending_up</i>Profit</a>
            <a href="customers" class="list-group-item list-group-item-action"><i class="material-icons">group</i>Customers</a>
            <a href="order" class="list-group-item list-group-item-action"><i class="material-icons">view_day</i>Orders</a>

            <a href="market" class="list-group-item list-group-item-action"><i class="material-icons">insert_emoticon</i>Market</a>
            <!-- <a href="notification.html" class="list-group-item list-group-item-action"><i class="material-icons">notifications</i>Notification <span class="badge badge-dark text-white">2</span></a> -->
            <!-- <a href="setting.html" class="list-group-item list-group-item-action"><i class="material-icons">account_circle</i>Setting</a> -->
            <a href="about" class="list-group-item list-group-item-action"><i class="material-icons">business</i>About</a>
        </div>
    </div>
    <!-- sidebar ends -->
    
    <!--Cart Modal -->
    <div class="mt-5 modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="cartTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content bg-light">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="cartTitle">Cart (<span class="total-count"></span>)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-1 bg-white">
                    <!-- <table class="show-cart table"></table> -->
                    <div class="showCart"></div>
                    <div class="float-right pr-3">Total price: &#x20a6;<span class="total-cart"></span></div>
                </div>
                <div class="modal-footer bg-primary text-white">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        Close
                    </button>
                    <a href="summary" class="btn btn-danger">CheckOut</a>
                </div>
            </div>
        </div>
    </div>
    <!--Cart Modal -->