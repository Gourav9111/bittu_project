
<?php
require_once '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$page_title = "Admin Dashboard";

// Fetch statistics
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total_applications FROM loan_applications");
    $total_applications = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SELECT COUNT(*) as pending_applications FROM loan_applications WHERE status = 'Pending'");
    $pending_applications = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SELECT COUNT(*) as total_dsa FROM dsa_users WHERE status = 'Active'");
    $total_dsa = $stmt->fetchColumn();
    
    $stmt = $pdo->query("SELECT COUNT(*) as total_categories FROM loan_categories WHERE is_active = 1");
    $total_categories = $stmt->fetchColumn();
    
} catch (Exception $e) {
    $total_applications = 0;
    $pending_applications = 0;
    $total_dsa = 0;
    $total_categories = 0;
}

include '../includes/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="text-danger fw-bold">Admin Dashboard</h2>
                <div>
                    <span class="text-muted">Welcome, <?php echo $_SESSION['admin_username']; ?></span>
                    <a href="../logout.php" class="btn btn-outline-danger ms-3">
                        <i class="fas fa-sign-out-alt me-1"></i>Logout
                    </a>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-4 mb-5">
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Total Applications</h6>
                                    <h3 class="mb-0"><?php echo $total_applications; ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-file-alt fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-warning text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Pending Applications</h6>
                                    <h3 class="mb-0"><?php echo $pending_applications; ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-success text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Active DSAs</h6>
                                    <h3 class="mb-0"><?php echo $total_dsa; ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-users fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card bg-danger text-white h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h6 class="card-title">Loan Categories</h6>
                                    <h3 class="mb-0"><?php echo $total_categories; ?></h3>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-list fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0"><i class="fas fa-cogs me-2"></i>Loan Management</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage loan categories, interest rates, and product features that appear on the website.</p>
                            <a href="manage-loans.php" class="btn btn-danger w-100">
                                <i class="fas fa-edit me-2"></i>Manage Loans
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0"><i class="fas fa-file-alt me-2"></i>Applications</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">View and manage all loan applications submitted by customers.</p>
                            <a href="applications.php" class="btn btn-primary w-100">
                                <i class="fas fa-list me-2"></i>View Applications
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card h-100">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0"><i class="fas fa-users me-2"></i>DSA Management</h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text">Manage Direct Selling Agents, approvals, and lead assignments.</p>
                            <a href="manage-dsa.php" class="btn btn-success w-100">
                                <i class="fas fa-user-cog me-2"></i>Manage DSAs
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
