<?php
require_once 'config.php';

$page_title = "Check Loan Status";
$page_description = "Check your loan application status with Jay Shree Mahakal Finance Services using your Application ID or mobile number";

$application = null;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $identifier = sanitizeInput($_POST['identifier']);
    
    if (!empty($identifier)) {
        try {
            // Check if identifier is Application ID or mobile number
            if (preg_match('/^JSMF\d+$/', $identifier)) {
                // It's an Application ID
                $stmt = $pdo->prepare("SELECT * FROM loan_applications WHERE application_id = ?");
            } else if (preg_match('/^[0-9]{10}$/', $identifier)) {
                // It's a mobile number
                $stmt = $pdo->prepare("SELECT * FROM loan_applications WHERE mobile = ? ORDER BY created_at DESC LIMIT 1");
            } else {
                throw new Exception('Please enter a valid Application ID or 10-digit mobile number.');
            }
            
            $stmt->execute([$identifier]);
            $application = $stmt->fetch();
            
            if (!$application) {
                $error_message = 'No application found with the provided details.';
            }
            
        } catch (Exception $e) {
            $error_message = $e->getMessage();
        }
    } else {
        $error_message = 'Please enter your Application ID or mobile number.';
    }
}

// Handle AJAX request
if (isset($_POST['ajax']) && $_POST['ajax'] == '1') {
    header('Content-Type: application/json');
    
    if ($application) {
        echo json_encode([
            'success' => true,
            'application' => $application
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $error_message ?: 'No application found.'
        ]);
    }
    exit;
}

include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-container">
                <div class="text-center mb-4">
                    <h2 class="text-danger fw-bold">Check Loan Status</h2>
                    <p class="text-muted">Enter your Application ID or mobile number to check status</p>
                </div>

                <?php if ($error_message): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($error_message); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form id="statusCheckForm" method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="identifier" class="form-label">Application ID or Mobile Number</label>
                        <input type="text" class="form-control" id="identifier" name="identifier" 
                               placeholder="Enter Application ID (e.g., JSMF2025001) or Mobile Number"
                               value="<?php echo isset($_POST['identifier']) ? htmlspecialchars($_POST['identifier']) : ''; ?>" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger btn-lg px-5">
                            <i class="fas fa-search me-2"></i>Check Status
                        </button>
                    </div>
                </form>

                <!-- Status Result -->
                <div id="statusResult">
                    <?php if ($application): ?>
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Application Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Application ID:</strong> <?php echo htmlspecialchars($application['application_id']); ?></p>
                                    <p><strong>Name:</strong> <?php echo htmlspecialchars($application['name']); ?></p>
                                    <p><strong>Mobile:</strong> <?php echo htmlspecialchars($application['mobile']); ?></p>
                                    <p><strong>City:</strong> <?php echo htmlspecialchars($application['city']); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Loan Type:</strong> <?php echo htmlspecialchars($application['loan_type']); ?></p>
                                    <p><strong>Amount:</strong> ₹<?php echo number_format($application['loan_amount']); ?></p>
                                    <p><strong>Status:</strong> 
                                        <span class="badge <?php 
                                            switch($application['status']) {
                                                case 'Approved': echo 'bg-success'; break;
                                                case 'Rejected': echo 'bg-danger'; break;
                                                case 'Processing': echo 'bg-info'; break;
                                                default: echo 'bg-warning text-dark';
                                            }
                                        ?>">
                                            <?php echo htmlspecialchars($application['status']); ?>
                                        </span>
                                    </p>
                                    <p><strong>Applied On:</strong> <?php echo date('d M Y', strtotime($application['created_at'])); ?></p>
                                </div>
                            </div>
                            
                            <?php if ($application['status'] == 'Pending'): ?>
                            <div class="alert alert-info mt-3">
                                <i class="fas fa-info-circle me-2"></i>
                                Your application is under review. Our team will contact you within 24 hours.
                            </div>
                            <?php elseif ($application['status'] == 'Processing'): ?>
                            <div class="alert alert-warning mt-3">
                                <i class="fas fa-cog me-2"></i>
                                Your application is being processed. We may contact you for additional documents.
                            </div>
                            <?php elseif ($application['status'] == 'Approved'): ?>
                            <div class="alert alert-success mt-3">
                                <i class="fas fa-check-circle me-2"></i>
                                Congratulations! Your loan has been approved. Our team will contact you for disbursement.
                            </div>
                            <?php elseif ($application['status'] == 'Rejected'): ?>
                            <div class="alert alert-danger mt-3">
                                <i class="fas fa-times-circle me-2"></i>
                                We regret to inform you that your loan application has been rejected. Please contact us for more details.
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Help Section -->
<div class="container mb-5">
    <div class="row">
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-phone text-danger fa-2x mb-3"></i>
                    <h5>Call Us</h5>
                    <p class="text-muted">Speak to our customer care executives</p>
                    <a href="tel:<?php echo CONTACT_PHONE; ?>" class="btn btn-outline-danger">
                        <?php echo CONTACT_PHONE; ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-envelope text-danger fa-2x mb-3"></i>
                    <h5>Email Us</h5>
                    <p class="text-muted">Send us your queries via email</p>
                    <a href="mailto:<?php echo CONTACT_EMAIL; ?>" class="btn btn-outline-danger">
                        <?php echo CONTACT_EMAIL; ?>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <i class="fas fa-comments text-danger fa-2x mb-3"></i>
                    <h5>Live Chat</h5>
                    <p class="text-muted">Chat with our support team</p>
                    <a href="contact-us.php" class="btn btn-outline-danger">
                        Start Chat
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
