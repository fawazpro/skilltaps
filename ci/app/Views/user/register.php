    <!-- Begin page content -->
    <main class="flex-shrink-0 main-container">
        <!-- page content goes here -->
        <div class="banner-hero scroll-y bg-white">
            <div class="container h-100">
                <div class="row h-100 h-sm-auto">
                    <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-start">
                    </div>
                    <div class="w-100"></div>
                    <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-center">
                        <img src="assets/img/favicons/skilltaps.png" width="100%" alt="">
                        <h3 class="">Welcome on board </h3>
                        <h2 class="font-weight-bold mb-4">Sign Up</h2>
                        <form action="register" method="post">
                        <div class="row">
                        <div class="col-6 form-group">
                            <label for="inputName" class="sr-only">First Name</label>
                            <input type="text" name="fname" id="inputName" class="form-control" placeholder="First Name" required="" autofocus="">
                        </div>
                        <div class="col-6 form-group">
                            <label for="inputName" class="sr-only">Last Name</label>
                            <input type="text" name="lname" id="inputName" class="form-control" placeholder="Last Name" required >
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-6 form-group">
                            <label for="inputName" class="sr-only">Sex</label>
                            <select class="form-control" name="sex" id="" required>
                                <option value="">Select an option</option>
                                <option value="m">Male</option>
                                <option value="f">Female</option>
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="inputPhone" class="sr-only">Phone</label>
                            <input type="number" name="phone" id="inputPhone" class="form-control" placeholder="Phone" maxlength="13" required="">
                        </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail" class="sr-only">Email address</label>
                            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" name="pass" id="inputPassword" minlength="6" class="form-control" placeholder="Password" required="">
                        </div>   
                        <div class="row">
                        <div class="col-12 form-group">
                            <label for="inputReferrerID" class="sr-only">Referrer ID</label>
                            <input type="text" name="ref" id="inputReferrerID" class="form-control" placeholder="Referrer ID" required="">
                        </div>  
                        </div>
                        <div class="form-group">
                            <label for="inputReferrerID" class="sr-only">Contact Address</label>
                            <textarea class="form-control" name="address" placeholder="Contact Address" id="" rows="3"></textarea>
                        </div>  
                    </div>
                    <div class="w-100"></div>
                    <div class="col-11 col-sm-8 col-md-6 mx-auto align-self-end">
                        <div class="mb-4">
                            <button type="submit" class=" btn btn-lg btn-default default-shadow btn-block">Sign Up <span class="ml-2 icon arrow_right"></span></button>
                        </div>
                        </form>
                        <div class="mb-4">
                            <p>Already have an account?<br> <a href="login">Sign in</a> here.</p>
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
