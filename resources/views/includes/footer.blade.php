    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">


    <!-- Footer -->
    <footer class="bg-dark text-light py-3 mt-auto">
        <!-- Container for centered layout -->
        <div class="container my-5">

            <footer class="text-white text-center text-lg-start bg-dark">
                <!-- Grid container -->
                <div class="container p-4">
                    <!--Grid row-->
                    <div class="row mt-4">
                        <!-- About Company -->
                        <div class="col-lg-4 col-md-12 mb-4 mb-md-0">
                            <h5 class="text-uppercase mb-4">About Tindahang Pinoy</h5>
                            <p>
                                Tindahang Pinoy is your trusted online marketplace for authentic Filipino products.
                                From locally made goods to essential grocery items, we bring the best of the Philippines to your doorstep.
                            </p>
                            <p>
                                We are committed to supporting Filipino businesses and ensuring our customers receive quality products with excellent service.
                            </p>
                        </div>

                        <!-- Contact Information -->
                        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                            <h5 class="text-uppercase mb-4 pb-1">Contact Information</h5>
                            <ul class="fa-ul" style="margin-left: 1.65em;">
                                <li class="mb-3">
                                    <span class="fa-li"><i class="fas fa-map-marker-alt"></i></span>
                                    <span class="ms-2">123 Mabini St, Manila, Philippines</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fa-li"><i class="fas fa-envelope"></i></span>
                                    <span class="ms-2">support@tindahangpinoy.com</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fa-li"><i class="fas fa-phone"></i></span>
                                    <span class="ms-2">+63 912 345 6789</span>
                                </li>
                                <li class="mb-3">
                                    <span class="fa-li"><i class="fas fa-clock"></i></span>
                                    <span class="ms-2">Mon-Sat: 8:00 AM - 9:00 PM</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Opening Hours -->
                        <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                            <h5 class="text-uppercase mb-4">Store Hours</h5>
                            <table class="table text-center text-white">
                                <tbody class="fw-normal">
                                    <tr>
                                        <td>Monday - Saturday:</td>
                                        <td>8:00 AM - 9:00 PM</td>
                                    </tr>
                                    <tr>
                                        <td>Sunday:</td>
                                        <td>9:00 AM - 8:00 PM</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Grid container -->

                <!-- Back to Top Button (Inside Footer) -->
                <button id="backToTop" class="btn btn-primary rounded-circle p-2 shadow">
                    <i class="fas fa-arrow-up"></i>
                </button>


                <!-- Copyright -->
                <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
                    © {{ date('Y') }} Tindahang Pinoy - All Rights Reserved.
                </div>

            </footer>

        </div>

    </footer>

    <style>
        #backToTop {
            width: 50px;
            height: 50px;
            font-size: 20px;
            position: fixed;
            /* Keeps it fixed on the screen */
            bottom: 20px;
            /* Distance from bottom */
            right: 20px;
            /* Distance from right */
            z-index: 1000;
            /* Ensure it's above other elements */
            display: none;
            /* Hidden by default */
        }

        #backToTop:hover {
            opacity: 0.8;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let backToTop = document.getElementById("backToTop");

            // Show button as soon as the user scrolls
            window.addEventListener("scroll", function() {
                if (window.scrollY > 50) { // Show after 50px of scroll
                    backToTop.style.display = "block";
                } else {
                    backToTop.style.display = "none";
                }
            });

            // Smooth scroll to top when button is clicked
            backToTop.addEventListener("click", function() {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        });
    </script>