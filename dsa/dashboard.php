<?php
require_once '../config.php';

// Check if user is logged in
if (!isset($_SESSION['dsa_id'])) {
    header("Location: login.php");
    exit;
}

$page_title = "DSA Dashboard";
$page_description = "DSA Dashboard - Submit loan applications";

$dsa_id = $_SESSION['dsa_id'];

// Fetch DSA information
try {
    $stmt = $pdo->prepare("SELECT * FROM dsa_users WHERE id = ?");
    $stmt->execute([$dsa_id]);
    $dsa_info = $stmt->fetch();
} catch (Exception $e) {
    // Fallback DSA info if database is not available
    $dsa_info = [
        'id' => $dsa_id,
        'name' => $_SESSION['dsa_name'] ?? 'DSA User',
        'mobile' => $_SESSION['dsa_mobile'] ?? 'N/A',
        'email' => $_SESSION['dsa_email'] ?? 'N/A',
        'profile_pic' => null
    ];
}

// Fetch submitted applications
try {
    $stmt = $pdo->prepare("
        SELECT * FROM dsa_applications 
        WHERE dsa_user_id = ? 
        ORDER BY created_at DESC
    ");
    $stmt->execute([$dsa_id]);
    $submitted_applications = $stmt->fetchAll();
} catch (Exception $e) {
    $submitted_applications = [];
}

// Dashboard statistics
$total_applications = count($submitted_applications);
$pending_applications = count(array_filter($submitted_applications, function($app) {
    return $app['status'] == 'Pending';
}));
$approved_applications = count(array_filter($submitted_applications, function($app) {
    return $app['status'] == 'Approved';
}));

include '../includes/header.php';
?>

<div class="container-fluid my-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <?php if ($dsa_info['profile_pic']): ?>
                        <img src="../uploads/profiles/<?php echo htmlspecialchars($dsa_info['profile_pic']); ?>" 
                             class="rounded-circle" width="80" height="80" alt="Profile">
                        <?php else: ?>
                        <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; font-size: 2rem;">
                            <?php echo strtoupper(substr($dsa_info['name'], 0, 1)); ?>
                        </div>
                        <?php endif; ?>
                    </div>
                    <h5 class="text-danger"><?php echo htmlspecialchars($dsa_info['name']); ?></h5>
                    <p class="text-muted mb-2">DSA ID: DSA<?php echo str_pad($dsa_info['id'], 4, '0', STR_PAD_LEFT); ?></p>
                    <span class="badge bg-success">KYC Approved</span>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0"><i class="fas fa-bell me-2"></i>Recent Notifications</h6>
                </div>
                <div class="card-body p-0">
                    <?php if ($notifications): ?>
                    <?php foreach ($notifications as $notification): ?>
                    <div class="p-3 border-bottom">
                        <p class="mb-1 small"><?php echo htmlspecialchars($notification['message']); ?></p>
                        <small class="text-muted"><?php echo date('M d, Y', strtotime($notification['created_at'])); ?></small>
                    </div>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <div class="p-3 text-center text-muted">
                        <i class="fas fa-bell-slash fa-2x mb-2"></i>
                        <p class="mb-0">No notifications</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h4 class="mb-2">Welcome back, <?php echo htmlspecialchars($dsa_info['name']); ?>!</h4>
                                    <p class="mb-0">Submit loan applications and track your performance from this dashboard.</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="../logout.php" class="btn btn-light">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i><?php echo $_SESSION['success_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['success_message']); endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $_SESSION['error_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['error_message']); endif; ?>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h3><?php echo $total_applications; ?></h3>
                            <p class="mb-0">Total Applications</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h3><?php echo $pending_applications; ?></h3>
                            <p class="mb-0">Pending Applications</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h3><?php echo $approved_applications; ?></h3>
                            <p class="mb-0">Approved Applications</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loan Application Forms -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Submit New Loan Application</h5>
                        </div>
                        <div class="card-body">
                            <!-- Loan Type Selection -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-danger mb-3">Select Loan Type:</h6>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <button class="btn btn-outline-danger w-100 loan-type-btn" onclick="showLoanForm('personal')">
                                                <i class="fas fa-user-tie fa-2x mb-2"></i><br>
                                                Personal Loan
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <button class="btn btn-outline-danger w-100 loan-type-btn" onclick="showLoanForm('business')">
                                                <i class="fas fa-briefcase fa-2x mb-2"></i><br>
                                                Business Loan
                                            </button>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <button class="btn btn-outline-danger w-100 loan-type-btn" onclick="showLoanForm('home')">
                                                <i class="fas fa-home fa-2x mb-2"></i><br>
                                                Home Loan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Loan Form -->
                            <div id="personalLoanForm" class="loan-form" style="display: none;">
                                <h6 class="text-danger mb-3">Personal Loan Application</h6>
                                <form method="POST" action="submit-application.php" enctype="multipart/form-data">
                                    <input type="hidden" name="loan_type" value="Personal Loan">
                                    <input type="hidden" name="dsa_user_id" value="<?php echo $dsa_id; ?>">
                                    
                                    <div class="row">
                                        <!-- Basic Information -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mother Name <span class="text-danger">*</span></label>
                                            <input type="text" name="mother_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="customer_mobile" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email ID <span class="text-danger">*</span></label>
                                            <input type="email" name="customer_email" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Office Address <span class="text-danger">*</span></label>
                                            <textarea name="office_address" class="form-control" rows="2" required></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Address Proof</label>
                                            <textarea name="address_proof" class="form-control" rows="2"></textarea>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Salary Amount <span class="text-danger">*</span></label>
                                            <input type="number" name="salary_amount" class="form-control" required>
                                        </div>
                                        
                                        <!-- Document Uploads -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Aadhar Card Number <span class="text-danger">*</span></label>
                                            <input type="text" name="aadhar_card_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Aadhar Card Upload <span class="text-danger">*</span></label>
                                            <input type="file" name="aadhar_card_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PAN Card Number <span class="text-danger">*</span></label>
                                            <input type="text" name="pan_card_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PAN Card Upload <span class="text-danger">*</span></label>
                                            <input type="file" name="pan_card_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">3 Month Salary Slips <span class="text-danger">*</span></label>
                                            <input type="file" name="salary_slip_files[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" multiple required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">1 Year Bank Statement <span class="text-danger">*</span></label>
                                            <input type="file" name="bank_statement_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        
                                        <!-- References -->
                                        <div class="col-12 mb-3">
                                            <h6 class="text-danger">Reference Details</h6>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference 1 Name <span class="text-danger">*</span></label>
                                            <input type="text" name="reference1_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference 1 Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="reference1_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference 2 Name <span class="text-danger">*</span></label>
                                            <input type="text" name="reference2_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference 2 Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="reference2_number" class="form-control" required>
                                        </div>
                                        
                                        <!-- Other Documents -->
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Other Documents Upload</label>
                                            <input type="file" name="other_documents[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" multiple>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary me-2" onclick="hideLoanForm()">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Submit Personal Loan Application</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Business Loan Form -->
                            <div id="businessLoanForm" class="loan-form" style="display: none;">
                                <h6 class="text-danger mb-3">Business Loan Application</h6>
                                <form method="POST" action="submit-application.php" enctype="multipart/form-data">
                                    <input type="hidden" name="loan_type" value="Business Loan">
                                    <input type="hidden" name="dsa_user_id" value="<?php echo $dsa_id; ?>">
                                    
                                    <div class="row">
                                        <!-- Basic Information -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="customer_mobile" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email ID <span class="text-danger">*</span></label>
                                            <input type="email" name="customer_email" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Address Proof</label>
                                            <textarea name="address_proof" class="form-control" rows="2"></textarea>
                                        </div>
                                        
                                        <!-- Document Uploads -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Aadhar Card Number <span class="text-danger">*</span></label>
                                            <input type="text" name="aadhar_card_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Aadhar Card Upload <span class="text-danger">*</span></label>
                                            <input type="file" name="aadhar_card_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PAN Card Number <span class="text-danger">*</span></label>
                                            <input type="text" name="pan_card_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PAN Card Upload <span class="text-danger">*</span></label>
                                            <input type="file" name="pan_card_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">1 Year Bank Statement <span class="text-danger">*</span></label>
                                            <input type="file" name="bank_statement_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Gumasta or Udhyam Aadhar <span class="text-danger">*</span></label>
                                            <input type="file" name="gumasta_udhyam_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">3 Years ITR <span class="text-danger">*</span></label>
                                            <input type="file" name="itr_files[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" multiple required>
                                        </div>
                                        
                                        <!-- References -->
                                        <div class="col-12 mb-3">
                                            <h6 class="text-danger">Reference Details</h6>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference 1 Name <span class="text-danger">*</span></label>
                                            <input type="text" name="reference1_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference 1 Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="reference1_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference 2 Name <span class="text-danger">*</span></label>
                                            <input type="text" name="reference2_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Reference 2 Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="reference2_number" class="form-control" required>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary me-2" onclick="hideLoanForm()">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Submit Business Loan Application</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Home Loan Form -->
                            <div id="homeLoanForm" class="loan-form" style="display: none;">
                                <h6 class="text-danger mb-3">Home Loan Application</h6>
                                <form method="POST" action="submit-application.php" enctype="multipart/form-data">
                                    <input type="hidden" name="loan_type" value="Home Loan">
                                    <input type="hidden" name="dsa_user_id" value="<?php echo $dsa_id; ?>">
                                    
                                    <div class="row">
                                        <!-- Basic Information -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                                            <input type="text" name="customer_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                            <input type="tel" name="customer_mobile" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Email ID <span class="text-danger">*</span></label>
                                            <input type="email" name="customer_email" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Income Type <span class="text-danger">*</span></label>
                                            <select name="income_type" class="form-control" required>
                                                <option value="">Select Income Type</option>
                                                <option value="Self Employed">Self Employed</option>
                                                <option value="Salaried - Cash">Salaried - Cash Salary</option>
                                                <option value="Salaried - Account">Salaried - Account Salary</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Document Uploads -->
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Aadhar Card Number <span class="text-danger">*</span></label>
                                            <input type="text" name="aadhar_card_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Aadhar Card Upload <span class="text-danger">*</span></label>
                                            <input type="file" name="aadhar_card_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PAN Card Number <span class="text-danger">*</span></label>
                                            <input type="text" name="pan_card_number" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">PAN Card Upload <span class="text-danger">*</span></label>
                                            <input type="file" name="pan_card_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Income Documents <span class="text-danger">*</span></label>
                                            <input type="file" name="salary_slip_files[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" multiple required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Electricity Bill or Rent Agreement <span class="text-danger">*</span></label>
                                            <input type="file" name="electricity_bill_file" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Property Papers <span class="text-danger">*</span></label>
                                            <input type="file" name="property_papers[]" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.xlsx" multiple required>
                                        </div>
                                    </div>
                                    
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary me-2" onclick="hideLoanForm()">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Submit Home Loan Application</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submitted Applications -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>My Submitted Applications</h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if ($submitted_applications): ?>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Application ID</th>
                                            <th>Loan Type</th>
                                            <th>Customer Name</th>
                                            <th>Status</th>
                                            <th>Submitted Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($submitted_applications as $application): ?>
                                        <tr>
                                            <td>
                                                <strong class="text-danger"><?php echo htmlspecialchars($application['application_id']); ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo htmlspecialchars($application['loan_type']); ?></span>
                                            </td>
                                            <td><?php echo htmlspecialchars($application['customer_name']); ?></td>
                                            <td>
                                                <span class="badge <?php 
                                                    switch($application['status']) {
                                                        case 'Pending': echo 'bg-warning text-dark'; break;
                                                        case 'Approved': echo 'bg-success'; break;
                                                        case 'Rejected': echo 'bg-danger'; break;
                                                        case 'In Progress': echo 'bg-primary'; break;
                                                        default: echo 'bg-secondary';
                                                    }
                                                ?>">
                                                    <?php echo htmlspecialchars($application['status']); ?>
                                                </span>
                                            </td>
                                            <td><?php echo date('M d, Y H:i', strtotime($application['created_at'])); ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                                <h6 class="text-muted">No Applications Submitted Yet</h6>
                                <p class="text-muted">Submit your first loan application using the forms above.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.loan-type-btn {
    min-height: 120px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

.loan-type-btn:hover {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}

.loan-type-btn.active {
    background-color: #dc3545;
    color: white;
    border-color: #dc3545;
}

.loan-form {
    border: 2px solid #dc3545;
    border-radius: 10px;
    padding: 20px;
    margin-top: 20px;
}
</style>

<script>
function showLoanForm(loanType) {
    // Hide all loan forms
    document.querySelectorAll('.loan-form').forEach(form => {
        form.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.loan-type-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    // Show selected form and activate button
    if (loanType === 'personal') {
        document.getElementById('personalLoanForm').style.display = 'block';
        event.target.classList.add('active');
    } else if (loanType === 'business') {
        document.getElementById('businessLoanForm').style.display = 'block';
        event.target.classList.add('active');
    } else if (loanType === 'home') {
        document.getElementById('homeLoanForm').style.display = 'block';
        event.target.classList.add('active');
    }
}

function hideLoanForm() {
    // Hide all loan forms
    document.querySelectorAll('.loan-form').forEach(form => {
        form.style.display = 'none';
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.loan-type-btn').forEach(btn => {
        btn.classList.remove('active');
    });
}

// Validation functions
function validateForm(form) {
    const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });
    
    return isValid;
}

// File validation
function validateFileSize(fileInput) {
    const maxSize = 5 * 1024 * 1024; // 5MB
    const files = fileInput.files;
    
    for (let i = 0; i < files.length; i++) {
        if (files[i].size > maxSize) {
            alert('File ' + files[i].name + ' is too large. Maximum size is 5MB.');
            fileInput.value = '';
            return false;
        }
    }
    return true;
}

// Add file validation to all file inputs
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            validateFileSize(this);
        });
    });
    
    // Add form validation
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!validateForm(this)) {
                e.preventDefault();
                alert('Please fill in all required fields.');
            }
        });
    });
});
</script>

<?php include '../includes/footer.php'; ?>
