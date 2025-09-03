<?php
require_once '../config.php';

$page_title = "DSA Registration";
$page_description = "Register as a Direct Selling Agent (DSA) with Jay Shree Mahakal Finance Services";

$success_message = '';
$error_message = '';

// Check if user is already logged in as DSA
if (isset($_SESSION['dsa_id'])) {
    header("Location: dashboard.php");
    exit;
}

include '../includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-container">
                <div class="text-center mb-4">
                    <h2 class="text-danger fw-bold">DSA Registration</h2>
                    <p class="text-muted">Join our Direct Selling Agent network and earn attractive commissions</p>
                </div>

                <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    Registration successful! Your account is under review. You will be notified once approved.
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form action="../process-dsa-register.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                                <div class="invalid-feedback">Please enter your full name.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mobile" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="mobile" name="mobile" pattern="[0-9]{10}" required>
                                <div class="invalid-feedback">Please enter a valid 10-digit mobile number.</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="experience" class="form-label">Work Experience <span class="text-danger">*</span></label>
                                <select class="form-control" id="experience" name="experience" required>
                                    <option value="">Select Experience</option>
                                    <option value="0-1 years">0-1 years</option>
                                    <option value="1-3 years">1-3 years</option>
                                    <option value="3-5 years">3-5 years</option>
                                    <option value="5-10 years">5-10 years</option>
                                    <option value="10+ years">10+ years</option>
                                </select>
                                <div class="invalid-feedback">Please select your work experience.</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="previous_experience" class="form-label">Previous Experience in Finance/Sales</label>
                        <textarea class="form-control" id="previous_experience" name="previous_experience" rows="3" 
                                  placeholder="Describe your previous experience in finance or sales sector"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="username" name="username" pattern="[a-zA-Z0-9_]{4,20}" required>
                                <div class="invalid-feedback">Username must be 4-20 characters (letters, numbers, underscore only).</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password" name="password" minlength="8" required>
                                <div class="invalid-feedback">Password must be at least 8 characters long.</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="invalid-feedback">Passwords do not match.</div>
                    </div>

                    <div class="form-group">
                        <label for="profile_pic" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_pic" name="profile_pic" accept="image/*">
                        <small class="text-muted">Upload a professional photo (optional)</small>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                        <div class="invalid-feedback">Please enter your address.</div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="terms" name="terms" required>
                            <label class="form-check-label" for="terms">
                                I agree to the <a href="../terms-and-conditions.php" target="_blank" class="text-danger">Terms & Conditions</a> 
                                and <a href="../privacy-policy.php" target="_blank" class="text-danger">Privacy Policy</a>
                            </label>
                            <div class="invalid-feedback">Please accept the terms and conditions.</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="data_consent" name="data_consent" required>
                            <label class="form-check-label" for="data_consent">
                                I consent to the collection and processing of my personal data for DSA registration and related activities
                            </label>
                            <div class="invalid-feedback">Please provide consent for data processing.</div>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-danger btn-lg px-5">
                            <i class="fas fa-user-plus me-2"></i>Register as DSA
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">Already have an account? <a href="login.php" class="text-danger">Login here</a></p>
                </div>

                <!-- DSA Benefits -->
                <div class="mt-5 p-4 bg-light rounded">
                    <h5 class="text-danger mb-3">DSA Benefits</h5>
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-money-bill-wave text-danger fa-2x mb-2"></i>
                            <h6>High Commission</h6>
                            <p class="small text-muted">Earn up to 2% commission on every loan</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-chart-line text-danger fa-2x mb-2"></i>
                            <h6>Growth Opportunities</h6>
                            <p class="small text-muted">Build your own network and team</p>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <i class="fas fa-headset text-danger fa-2x mb-2"></i>
                            <h6>Full Support</h6>
                            <p class="small text-muted">Complete training and support provided</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password confirmation validation
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Passwords do not match');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
    
    // Username validation
    const username = document.getElementById('username');
    username.addEventListener('input', function() {
        const value = this.value;
        const pattern = /^[a-zA-Z0-9_]{4,20}$/;
        
        if (value && !pattern.test(value)) {
            this.setCustomValidity('Username must be 4-20 characters (letters, numbers, underscore only)');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>

<?php include '../includes/footer.php'; ?>
