<!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="JSMF Logo" height="40" class="me-3">
                        <h5 class="text-danger mb-0">Jay Shree Mahakal Finance</h5>
                    </div>
                    <p class="text-muted">Your trusted finance partner for all loan needs. We provide quick and hassle-free loan solutions with competitive rates and minimal documentation.</p>
                </div>
                <div class="col-md-4">
                    <h6>Quick Links</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo SITE_URL; ?>/apply-loan.php" class="text-muted">Apply for Loan</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/emi/calculator.php" class="text-muted">EMI Calculator</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/check-status.php" class="text-muted">Check Status</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact-us.php" class="text-muted">Contact Us</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/terms-and-conditions.php" class="text-muted">Terms & Conditions</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/privacy-policy.php" class="text-muted">Privacy Policy</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6>Office Hours</h6>
                    <p class="text-muted mb-2">Monday - Friday: 9:00 AM - 6:00 PM</p>
                    <p class="text-muted mb-2">Saturday: 9:00 AM - 4:00 PM</p>
                    <p class="text-muted mb-2">Sunday: Closed</p>
                    <h6 class="mt-3">Follow Us</h6>
                    <div class="social-links">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">

            <!-- Contact Information Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="bg-dark-subtle p-4 rounded contact-item hover-lift">
                        <h5 class="text-danger mb-3 text-center">Contact Information</h5>
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="d-flex flex-column align-items-center contact-item">
                                    <i class="fas fa-map-marker-alt text-danger fa-2x mb-2 float"></i>
                                    <h6 class="text-white">Address</h6>
                                    <p class="text-white mb-0"><?php echo COMPANY_ADDRESS; ?></p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex flex-column align-items-center contact-item">
                                    <i class="fas fa-phone text-danger fa-2x mb-2 float"></i>
                                    <h6 class="text-white">Phone</h6>
                                    <p class="text-white mb-0"><?php echo CONTACT_PHONE; ?></p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="d-flex flex-column align-items-center contact-item">
                                    <i class="fas fa-envelope text-danger fa-2x mb-2 float"></i>
                                    <h6 class="text-white">Email</h6>
                                    <p class="text-white mb-0"><?php echo CONTACT_EMAIL; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p class="text-muted mb-0">&copy; <?php echo date('Y'); ?> Jay Shree Mahakal Finance Services. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-end">
                    <p class="text-muted mb-0">Designed with <i class="fas fa-heart text-danger"></i> for your financial needs</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="<?php echo SITE_URL; ?>/assets/js/main.js"></script>
    <script>
        // Initialize AOS animations
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });
    </script>
</body>
</html>