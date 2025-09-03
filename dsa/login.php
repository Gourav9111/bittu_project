<?php
require_once '../config.php';

$page_title = "DSA Login";
$page_description = "DSA Portal Login - Access your Direct Selling Agent dashboard";

// Check if user is already logged in
if (isset($_SESSION['dsa_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];
        
        if (empty($username) || empty($password)) {
            throw new Exception('Please enter both username and password.');
        }
        
        // Check user credentials
        $stmt = $pdo->prepare("SELECT * FROM dsa_users WHERE username = ? AND status = 'Active'");
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['kyc_status'] == 'Approved') {
                // Set session variables
                $_SESSION['dsa_id'] = $user['id'];
                $_SESSION['dsa_name'] = $user['name'];
                $_SESSION['dsa_username'] = $user['username'];
                
                header("Location: dashboard.php");
                exit;
            } else {
                $error_message = 'Your account is pending approval. Please wait for admin verification.';
            }
        } else {
            $error_message = 'Invalid username or password.';
        }
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

include '../includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="form-container">
                <div class="text-center mb-4">
                    <h2 class="text-danger fw-bold">DSA Login</h2>
                    <p class="text-muted">Access your Direct Selling Agent dashboard</p>
                </div>

                <?php if ($error_message): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form method="POST" class="needs-validation" novalidate>
                    <div class="form-group">
                        <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-danger btn-lg w-100">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </button>
                    </div>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted">Don't have an account? <a href="register.php" class="text-danger">Register as DSA</a></p>
                    <p class="text-muted"><a href="#" class="text-danger" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal">Forgot Password?</a></p>
                </div>

                <!-- Information Box -->
                <div class="mt-4 p-3 bg-light rounded">
                    <h6 class="text-danger">DSA Portal Access</h6>
                    <ul class="list-unstyled small text-muted mb-0">
                        <li><i class="fas fa-check text-success me-2"></i>View assigned leads</li>
                        <li><i class="fas fa-check text-success me-2"></i>Update lead status</li>
                        <li><i class="fas fa-check text-success me-2"></i>Track commissions</li>
                        <li><i class="fas fa-check text-success me-2"></i>Receive notifications</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Forgot Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted">To reset your password, please contact our admin team:</p>
                <div class="bg-light p-3 rounded">
                    <p class="mb-2"><i class="fas fa-phone text-danger me-2"></i><?php echo CONTACT_PHONE; ?></p>
                    <p class="mb-0"><i class="fas fa-envelope text-danger me-2"></i><?php echo CONTACT_EMAIL; ?></p>
                </div>
                <p class="text-muted mt-3 small">Provide your username and registered mobile number for verification.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="../contact-us.php" class="btn btn-danger">Contact Admin</a>
            </div>
        </div>
    </div>
</div>

<script>
// Toggle password visibility
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script>

<?php include '../includes/footer.php'; ?>
