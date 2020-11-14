
    <!-- Footer -->
    <footer class="footer footer-dark mt-auto pt-3">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12 col-md-auto  text-center">
                    <a href="" target="_blank" class="btn btn-link px-2"><span class="social_facebook"></span></a>
                    <a href="" class="btn btn-link px-2" target="_blank"><span class="social_twitter"></span></a>
                    <a href="" class="btn btn-link px-2" target="_blank"><span class="social_linkedin"></span></a>
                    <a href="" class="btn btn-link px-2" target="_blank"><span class="social_instagram"></span></a>
                    <a href="" class="btn btn-link px-2" target="_blank"><span class="social_dribbble"></span></a>
                </div>
            </div>
            <hr>
            <p class="text-center"><span class="text-mute"> App developed by <a href="https://rayyan.com.ng" target="_blank">RayyanTech</a> with </span><span class="text-danger">❤</span></p>
        </div>
    </footer>
    <!-- Footer ends -->

    <!-- scroll to top button -->
    <button type="button" class="btn btn-default default-shadow scrollup bottom-right position-fixed btn-44"><span class="arrow_carrot-up"></span></button>
    <!-- scroll to top button ends-->


    <!-- Required jquery and libraries -->
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/vendor/bootstrap-4.4.1/js/bootstrap.min.js"></script>

    <!-- cookie css -->
    <script src="assets/vendor/cookie/jquery.cookie.js"></script>

    <!-- Swiper slider  -->
    <script src="assets/vendor/swiper/js/swiper.min.js"></script>

    <!-- date range picker -->
    <script src="assets/vendor/daterangepicker-master/moment.min.js"></script>
    <script src="assets/vendor/daterangepicker-master/daterangepicker.js"></script>

    <!-- Swiper slider  -->
    <script src="assets/vendor/sparklines/jquery.sparkline.min.js"></script>

    <!-- Customized jquery file  -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/cart.js"></script>
    <script src="assets/js/color-scheme-demo.js"></script>

    <script>
        "use strict"
        $(document).ready(function() {
            /* Swiper slider */
            var swiper = new Swiper('.swiper-offers', {
                slidesPerView: 'auto',
                spaceBetween: 10,
                pagination: false,
            });

            /* swiper tavs  js */
            $('#recurring-tab[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var swiper = new Swiper('.swiper-container', {
                    effect: 'coverflow',
                    grabCursor: true,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    spaceBetween: 10,
                    coverflowEffect: {
                        rotate: 30,
                        stretch: 0,
                        depth: 80,
                        modifier: 1,
                        slideShadows: true,
                    }

                });

            });

            /* swiper tavs  js */
            $('#addexpense').on('shown.bs.modal', function(e) {
                $('.amount').focusin();

                /* calander picker */
                var start = moment().subtract(29, 'days');
                var end = moment();

                /* calander single  picker ends */
                $('.datepicker').daterangepicker({
                    singleDatePicker: true,
                    showDropdowns: true,
                    drops: 'up',
                    minYear: 1901
                }, function(start, end, label) {});

            });

            /* toast message */
            setTimeout(function() {
                $('.toast').toast('show')
            }, 2000);

            /* sparklines */
            $("#sparklines1").sparkline([5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7, 5, 6, 7, 9, 9, 5, 3, 2, 2, 4, 6, 7], {
                type: 'bar',
                height: '20px',
                barWidth: 2,
                barColor: '#e0eaff'
            });

        });

    </script>
</body>


<!-- Mirrored from maxartkiller.com/website/oneuiux/mobile/finance/index.html by HTTrack Website Copier/3.x [XR&CO'2017], Tue, 08 Sep 2020 19:49:25 GMT -->
</html>