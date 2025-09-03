<?php
require_once 'config.php';

$page_title = "Contact Us";
$page_description = "Contact Jay Shree Mahakal Finance Services for all your loan needs. Call us, email us or visit our office in Bhopal, Madhya Pradesh";

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $message = sanitizeInput($_POST['message']);
        
        // Validate required fields
        if (empty($name) || empty($email) || empty($phone) || empty($message)) {
            throw new Exception('All fields are required.');
        }
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address.');
        }
        
        // Validate phone
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            throw new Exception('Please enter a valid 10-digit phone number.');
        }
        
        // Insert contact message
        $stmt = $pdo->prepare("
            INSERT INTO contact_messages (name, email, phone, message, status) 
            VALUES (?, ?, ?, ?, 'New')
        ");
        
        $stmt->execute([$name, $email, $phone, $message]);
        
        $success_message = 'Thank you for contacting us! We will get back to you within 24 hours.';
        
        // Clear form data
        $_POST = [];
        
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="form-container">
                <div class="text-center mb-4">
                    <h2 class="text-danger fw-bold">Contact Us</h2>
                    <p class="text-muted">Get in touch with our expert team for any loan-related queries</p>
                </div>

                <?php if ($success_message): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo htmlspecialchars($success_message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo htmlspecialchars($error_message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" required>
                                <div class="invalid-feedback">Please enter your full name.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{10}"
                               value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" required>
                        <div class="invalid-feedback">Please enter a valid 10-digit phone number.</div>
                    </div>

                    <div class="form-group">
                        <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="message" name="message" rows="5" 
                                  placeholder="Please describe your query or requirement" required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                        <div class="invalid-feedback">Please enter your message.</div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-danger btn-lg px-5">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Contact Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-danger"><i class="fas fa-map-marker-alt me-2"></i>Office Address</h6>
                        <p class="text-muted small"><?php echo COMPANY_ADDRESS; ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-danger"><i class="fas fa-phone me-2"></i>Phone Number</h6>
                        <p class="mb-0">
                            <a href="tel:<?php echo CONTACT_PHONE; ?>" class="text-decoration-none">
                                <?php echo CONTACT_PHONE; ?>
                            </a>
                        </p>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-danger"><i class="fas fa-envelope me-2"></i>Email Address</h6>
                        <p class="mb-0">
                            <a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="text-decoration-none">
                                <?php echo CONTACT_EMAIL; ?>
                            </a>
                        </p>
                    </div>

                    <div>
                        <h6 class="text-danger"><i class="fas fa-clock me-2"></i>Working Hours</h6>
                        <p class="text-muted small mb-0">
                            Monday - Saturday: 9:00 AM - 6:00 PM<br>
                            Sunday: Closed
                        </p>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="fas fa-headset me-2"></i>Quick Support</h6>
                </div>
                <div class="card-body text-center">
                    <p class="mb-3">Need immediate assistance? Call us now!</p>
                    <a href="tel:<?php echo CONTACT_PHONE; ?>" class="btn btn-danger btn-lg w-100 mb-2">
                        <i class="fas fa-phone me-2"></i>Call Now
                    </a>
                    <a href="https://wa.me/<?php echo str_replace(['+', '-', ' '], '', CONTACT_PHONE); ?>" 
                       target="_blank" class="btn btn-success btn-lg w-100">
                        <i class="fab fa-whatsapp me-2"></i>WhatsApp
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="fas fa-map me-2"></i>Find Us</h6>
                </div>
                <div class="card-body p-0">
                    <!-- Google Maps Embed -->
                    <div style="width: 100%; height: 250px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 0 0 0.375rem 0.375rem;">
                        <div class="text-center text-muted">
                            <i class="fas fa-map-marked-alt fa-3x mb-2"></i>
                            <p class="mb-0">Interactive Map</p>
                            <small>Karond, Bhopal, MP</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="text-danger fw-bold">Frequently Asked Questions</h2>
            <p class="text-muted">Quick answers to common questions</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-danger">What documents are required for loan application?</h6>
                        <p class="text-muted small mb-0">Basic documents include PAN card, Aadhaar card, salary slips, bank statements, and address proof.</p>
                    </div>
                </div>
                
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-danger">How long does loan approval take?</h6>
                        <p class="text-muted small mb-0">We provide quick approval within 24-48 hours for eligible applicants with complete documentation.</p>
                    </div>
                </div>
                
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-danger">What is the minimum credit score required?</h6>
                        <p class="text-muted small mb-0">While we prefer a credit score of 650+, we also consider applications with lower scores on a case-by-case basis.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-danger">Are there any hidden charges?</h6>
                        <p class="text-muted small mb-0">No, we believe in complete transparency. All charges are clearly mentioned in the loan agreement.</p>
                    </div>
                </div>
                
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-danger">Can I prepay my loan?</h6>
                        <p class="text-muted small mb-0">Yes, you can prepay your loan anytime without any prepayment charges after 6 months.</p>
                    </div>
                </div>
                
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="text-danger">How can I track my application status?</h6>
                        <p class="text-muted small mb-0">You can track your application status online using your Application ID or mobile number on our website.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
