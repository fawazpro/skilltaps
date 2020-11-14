    <!-- Begin page content -->
    <main class="flex-shrink-0 main-container">
        <!-- page content goes here -->
        <div class="banner-hero vh-100 scroll-y bg-white">
            <div class="container h-100">
                <div class="row h-100 h-sm-auto">
                    <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-start">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-center">
                        <img src="assets/img/favicons/skilltaps.png" width="100%" alt="">
                        <h3 class="">Welcome back!</h3>
                        <h2 class="font-weight-bold mb-4">Sign In</h2>
                        <form action="login" method="post">
                        <div class="form-group">
                            <label for="inputEmail" class="sr-only">Email address</label>
                            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" name="email" required="" autofocus="">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" class="form-control" name="pass" placeholder="Password" required="">
                        </div>

                        <div class="my-3 row">
                            <div class="col-6 col-md py-1 text-left">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                                    <label class="custom-control-label" for="customCheck1">Remember Me</label>
                                </div>
                            </div>
                            <!-- <div class="col-6 col-md py-1 text-right text-md-right">
                                <a href="forgotpassword.html">Forgot Password?</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="w-100"></div>
                    <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-end">
                        <div class="mb-4">
                            <button type="submit" class=" btn btn-lg btn-default default-shadow btn-block">Sign In <span class="ml-2 icon arrow_right"></span></button>
                        </div>
                        </form>
                        <div class="mb-4">
                            <p>Do not have account yet?<br>Please <a href="register">Sign up</a> here.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <!-- End of page content -->

    <!-- Required jquery and libraries -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>

    <!-- cookie css -->
    <script src="assets/vendor/cookie/jquery.cookie.js"></script>


    <!-- Customized jquery file  -->
    <script src="assets/js/main.js"></script>
</body>
</html>
