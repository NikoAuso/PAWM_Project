<!-- Footer -->
<footer class="bg-dark text-center text-white ">
    <!-- Grid container -->
    <div class="container p-4 pb-0">
        <!-- Section: Social media -->
        <section class="mb-4">
            <!-- Facebook -->
            <a class="btn btn-outline-light btn-floating m-1"
               href="https://www.facebook.com/MamaTeamCeleste"
               role="button"
               data-mdb-ripple-color="white"
               style="vertical-align: middle;"
            ><i class="fab fa-facebook-f"></i></a>

            <!-- Instagram -->
            <a class="btn btn-outline-light btn-floating m-1"
               href="https://www.instagram.com/mamateamceleste/"
               role="button"
               data-mdb-ripple-color="white"
            ><i class="fab fa-instagram"></i></a>

            <!-- Email -->
            <a class="btn btn-outline-light btn-floating m-1"
               href="javascript:window.open('mailto:info@mamateamceleste.it', 'mail');event.preventDefault()"
               role="button"
               data-mdb-ripple-color="white"
            ><i class="fas fa-envelope"></i></a>

            <!-- Phone -->
            <a class="btn btn-outline-light btn-floating m-1"
               href="tel:+39 333 628 6402"
               role="button"
               data-mdb-ripple-color="white"
            ><i class="fas fa-phone"></i></a>
        </section>
        <!-- Section: Social media -->

        {{--<!-- Section: Form -->
    <section class="">
        <form action="">
            <!--Grid row-->
            <div class="row d-flex justify-content-center">
                <!--Grid column-->
                <div class="col-auto">
                    <p class="pt-2">
                        <strong>Sign up for our newsletter</strong>
                    </p>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-md-5 col-12">
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                        <input type="email" id="form5Example2" class="form-control"/>
                        <label class="form-label" for="form5Example2">Email address</label>
                    </div>
                </div>
                <!--Grid column-->

                <!--Grid column-->
                <div class="col-auto">

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-primary mb-4">
                        Subscribe
                    </button>
                </div>
                <!--Grid column-->
            </div>
            <!--Grid row-->
        </form>
    </section>
    <!-- Section: Form -->--}}

        <!-- Section: footer image -->
        <section class="mb-4">
            <div class="text-center footer-img">
                <img class="img-fluid" src="{{asset('assets/img/logo.png')}}" style="height: 100px;"
                     alt="logo completo" loading="lazy"/>
            </div>
        </section>

        <!-- Section: Text -->
        <section class="mb-4">
            <p>
                <a href="https://www.iubenda.com/privacy-policy/50606660"
                   class="iubenda-black iubenda-noiframe iubenda-embed iubenda-noiframe "
                   title="Privacy Policy ">Privacy
                    Policy</a>
                <script type="text/javascript">
                    (function (w, d) {
                        let loader = function () {
                            let s = d.createElement("script"),
                                tag = d.getElementsByTagName("script")[0];
                            s.src = "https://cdn.iubenda.com/iubenda.js";
                            tag.parentNode.insertBefore(s, tag);
                        };
                        if (w.addEventListener) {
                            w.addEventListener("load", loader, false);
                        } else if (w.attachEvent) {
                            w.attachEvent("onload", loader);
                        } else {
                            w.onload = loader;
                        }
                    })(window, document);
                </script>
                - Designed by <a class="designed" href="https://www.instagram.com/niko_auso" target="_blank"
                                 rel="noreferrer">R.M.
                    Mamateam</a>
            </p>
        </section>

    </div>
    <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
        Copyright © {{date("Y")}} - All right reserved
    </div>
    <!-- Copyright -->

</footer>
<!-- Footer -->
