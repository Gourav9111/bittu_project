<?php
require_once '../config.php';

// Check if user is logged in
if (!isset($_SESSION['dsa_id'])) {
    header("Location: login.php");
    exit;
}

$page_title = "DSA Dashboard";
$page_description = "DSA Dashboard - Manage your leads and track performance";

$dsa_id = $_SESSION['dsa_id'];

// Fetch DSA information
$stmt = $pdo->prepare("SELECT * FROM dsa_users WHERE id = ?");
$stmt->execute([$dsa_id]);
$dsa_info = $stmt->fetch();

// Fetch assigned leads
$stmt = $pdo->prepare("
    SELECT la.*, las.status as assignment_status, las.notes, las.created_at as assigned_date
    FROM loan_applications la 
    JOIN lead_assignments las ON la.id = las.application_id 
    WHERE las.dsa_id = ? 
    ORDER BY las.created_at DESC
");
$stmt->execute([$dsa_id]);
$assigned_leads = $stmt->fetchAll();

// Fetch notifications
$stmt = $pdo->prepare("
    SELECT * FROM notifications 
    WHERE (target = 'dsa' AND target_user_id = ?) OR (target = 'all') 
    ORDER BY created_at DESC 
    LIMIT 5
");
$stmt->execute([$dsa_id]);
$notifications = $stmt->fetchAll();

// Dashboard statistics
$total_leads = count($assigned_leads);
$completed_leads = count(array_filter($assigned_leads, function($lead) {
    return $lead['assignment_status'] == 'Completed';
}));
$pending_leads = count(array_filter($assigned_leads, function($lead) {
    return in_array($lead['assignment_status'], ['Assigned', 'In Progress', 'Follow-Up']);
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
                                    <p class="mb-0">Track your leads and manage your performance from this dashboard.</p>
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

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="dashboard-card">
                        <div class="dashboard-stat">
                            <div class="dashboard-stat-number"><?php echo $total_leads; ?></div>
                            <div class="dashboard-stat-label">Total Leads</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-card">
                        <div class="dashboard-stat">
                            <div class="dashboard-stat-number"><?php echo $pending_leads; ?></div>
                            <div class="dashboard-stat-label">Pending Leads</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="dashboard-card">
                        <div class="dashboard-stat">
                            <div class="dashboard-stat-number"><?php echo $completed_leads; ?></div>
                            <div class="dashboard-stat-label">Completed</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Leads -->
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-users me-2"></i>Assigned Leads</h5>
                </div>
                <div class="card-body p-0">
                    <?php if ($assigned_leads): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Application ID</th>
                                    <th>Customer Name</th>
                                    <th>Loan Type</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Assigned Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assigned_leads as $lead): ?>
                                <tr>
                                    <td>
                                        <strong class="text-danger"><?php echo htmlspecialchars($lead['application_id']); ?></strong>
                                    </td>
                                    <td>
                                        <div>
                                            <div class="fw-bold"><?php echo htmlspecialchars($lead['name']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($lead['mobile']); ?></small>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($lead['loan_type']); ?></td>
                                    <td>₹<?php echo number_format($lead['loan_amount']); ?></td>
                                    <td>
                                        <span class="badge <?php 
                                            switch($lead['assignment_status']) {
                                                case 'Assigned': echo 'bg-primary'; break;
                                                case 'In Progress': echo 'bg-warning text-dark'; break;
                                                case 'Follow-Up': echo 'bg-info'; break;
                                                case 'Submitted': echo 'bg-success'; break;
                                                case 'Completed': echo 'bg-success'; break;
                                                default: echo 'bg-secondary';
                                            }
                                        ?>">
                                            <?php echo htmlspecialchars($lead['assignment_status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($lead['assigned_date'])); ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="updateLeadStatus(<?php echo $lead['application_id']; ?>, '<?php echo $lead['assignment_status']; ?>')">
                                            <i class="fas fa-edit"></i> Update
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No leads assigned yet</h6>
                        <p class="text-muted">Check back later for new lead assignments.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Update Lead Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm">
                <div class="modal-body">
                    <input type="hidden" id="updateApplicationId" name="application_id">
                    
                    <div class="form-group">
                        <label for="newStatus" class="form-label">Status</label>
                        <select class="form-control" id="newStatus" name="status" required>
                            <option value="Assigned">Assigned</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Follow-Up">Follow-Up</option>
                            <option value="Submitted">Submitted</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="statusNotes" class="form-label">Notes</label>
                        <textarea class="form-control" id="statusNotes" name="notes" rows="3" 
                                  placeholder="Add any notes or comments about this lead"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function updateLeadStatus(applicationId, currentStatus) {
    document.getElementById('updateApplicationId').value = applicationId;
    document.getElementById('newStatus').value = currentStatus;
    
    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    modal.show();
}

document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('update-lead-status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error updating status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});
</script>

<?php include '../includes/footer.php'; ?>
