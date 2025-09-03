<?php
require_once '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$page_title = "DSA Leads";

// Fetch all DSA users with their application counts
try {
    $stmt = $pdo->query("
        SELECT 
            du.id,
            du.name,
            du.mobile,
            du.email,
            du.dsa_id,
            du.status,
            du.created_at,
            COUNT(dsa_applications.id) as total_applications
        FROM dsa_users du
        LEFT JOIN dsa_applications ON du.id = dsa_applications.dsa_user_id
        GROUP BY du.id
        ORDER BY du.created_at DESC
    ");
    $dsa_users = $stmt->fetchAll();
} catch (Exception $e) {
    $dsa_users = [];
    $error_message = "Error fetching DSA users: " . $e->getMessage();
}

include '../includes/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-danger fw-bold">DSA Leads</h2>
                    <p class="text-muted mb-0">View all DSA users and their submitted loan applications</p>
                </div>
                <a href="dashboard.php" class="btn btn-outline-danger">
                    <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                </a>
            </div>

            <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error_message; ?>
            </div>
            <?php endif; ?>

            <!-- DSA Users Table -->
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>All DSA Users</h5>
                </div>
                <div class="card-body p-0">
                    <?php if ($dsa_users): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>DSA ID</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Total Applications</th>
                                    <th>Status</th>
                                    <th>Registered Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dsa_users as $dsa): ?>
                                <tr>
                                    <td>
                                        <strong class="text-danger">DSA<?php echo str_pad($dsa['id'], 4, '0', STR_PAD_LEFT); ?></strong>
                                    </td>
                                    <td>
                                        <div class="fw-bold"><?php echo htmlspecialchars($dsa['name']); ?></div>
                                    </td>
                                    <td><?php echo htmlspecialchars($dsa['mobile']); ?></td>
                                    <td><?php echo htmlspecialchars($dsa['email']); ?></td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo $dsa['total_applications']; ?> Applications</span>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo $dsa['status'] == 'Active' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                            <?php echo htmlspecialchars($dsa['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($dsa['created_at'])); ?></td>
                                    <td>
                                        <a href="dsa-applications.php?dsa_id=<?php echo $dsa['id']; ?>" 
                                           class="btn btn-sm btn-danger">
                                            <i class="fas fa-eye me-1"></i>View Applications
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No DSA Users Found</h6>
                        <p class="text-muted">No DSA users are registered yet.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>