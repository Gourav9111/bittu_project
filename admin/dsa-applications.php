<?php
require_once '../config.php';

// For development - bypass login check
$_SESSION['admin_id'] = 1;

// Get DSA ID from URL
$dsa_id = isset($_GET['dsa_id']) ? intval($_GET['dsa_id']) : 0;

if (!$dsa_id) {
    header("Location: dsaleads.php");
    exit;
}

$page_title = "DSA Applications";

// Fetch DSA user information
try {
    $stmt = $pdo->prepare("SELECT * FROM dsa_users WHERE id = ?");
    $stmt->execute([$dsa_id]);
    $dsa_info = $stmt->fetch();
    
    if (!$dsa_info) {
        header("Location: dsaleads.php");
        exit;
    }
} catch (Exception $e) {
    header("Location: dsaleads.php");
    exit;
}

// Fetch all applications by this DSA user
try {
    $stmt = $pdo->prepare("
        SELECT * FROM dsa_applications 
        WHERE dsa_user_id = ? 
        ORDER BY created_at DESC
    ");
    $stmt->execute([$dsa_id]);
    $applications = $stmt->fetchAll();
} catch (Exception $e) {
    $applications = [];
    $error_message = "Error fetching applications: " . $e->getMessage();
}

include '../includes/header.php';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="text-danger fw-bold">DSA Applications</h2>
                    <p class="text-muted mb-0">Applications submitted by <?php echo htmlspecialchars($dsa_info['name']); ?></p>
                </div>
                <a href="dsaleads.php" class="btn btn-outline-danger">
                    <i class="fas fa-arrow-left me-2"></i>Back to DSA Leads
                </a>
            </div>

            <!-- DSA Info Card -->
            <div class="row mb-4">
                <div class="col-lg-4">
                    <div class="card border-danger">
                        <div class="card-header bg-danger text-white">
                            <h6 class="mb-0"><i class="fas fa-user me-2"></i>DSA Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <strong>DSA ID:</strong>
                                </div>
                                <div class="col-6">
                                    DSA<?php echo str_pad($dsa_info['id'], 4, '0', STR_PAD_LEFT); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Name:</strong>
                                </div>
                                <div class="col-6">
                                    <?php echo htmlspecialchars($dsa_info['name']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Mobile:</strong>
                                </div>
                                <div class="col-6">
                                    <?php echo htmlspecialchars($dsa_info['mobile']); ?>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <strong>Email:</strong>
                                </div>
                                <div class="col-6">
                                    <?php echo htmlspecialchars($dsa_info['email']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body text-center">
                                    <h3><?php echo count($applications); ?></h3>
                                    <p class="mb-0">Total Applications</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white h-100">
                                <div class="card-body text-center">
                                    <h3><?php echo count(array_filter($applications, function($app) { return $app['status'] == 'Pending'; })); ?></h3>
                                    <p class="mb-0">Pending</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body text-center">
                                    <h3><?php echo count(array_filter($applications, function($app) { return $app['status'] == 'Approved'; })); ?></h3>
                                    <p class="mb-0">Approved</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white h-100">
                                <div class="card-body text-center">
                                    <h3><?php echo count(array_filter($applications, function($app) { return $app['status'] == 'Rejected'; })); ?></h3>
                                    <p class="mb-0">Rejected</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (isset($error_message)): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i><?php echo $error_message; ?>
            </div>
            <?php endif; ?>

            <!-- Applications Table -->
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>Loan Applications</h5>
                </div>
                <div class="card-body p-0">
                    <?php if ($applications): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Application ID</th>
                                    <th>Loan Type</th>
                                    <th>Customer Name</th>
                                    <th>Mobile</th>
                                    <th>Status</th>
                                    <th>Submitted Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($applications as $application): ?>
                                <tr>
                                    <td>
                                        <strong class="text-danger"><?php echo htmlspecialchars($application['application_id']); ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?php echo htmlspecialchars($application['loan_type']); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($application['customer_name']); ?></td>
                                    <td><?php echo htmlspecialchars($application['customer_mobile']); ?></td>
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
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger" 
                                                onclick="viewApplication(<?php echo $application['id']; ?>)">
                                            <i class="fas fa-eye me-1"></i>View Details
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
                        <h6 class="text-muted">No Applications Found</h6>
                        <p class="text-muted">This DSA user hasn't submitted any loan applications yet.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Application Details Modal -->
<div class="modal fade" id="applicationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Application Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="applicationDetails">
                <!-- Application details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
function viewApplication(applicationId) {
    const modal = new bootstrap.Modal(document.getElementById('applicationModal'));
    const modalBody = document.getElementById('applicationDetails');
    modalBody.innerHTML = `<div class="text-center"><div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div></div>`;
    modal.show();

    fetch('get-application-details.php?id=' + applicationId)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                modalBody.innerHTML = data.html;
                
                const statusForm = document.getElementById('updateApplicationStatus');
                if (statusForm) {
                    statusForm.addEventListener('submit', function(e) {
                        e.preventDefault();
                        updateApplicationStatus(this);
                    });
                }
            } else {
                modalBody.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            modalBody.innerHTML = `<div class="alert alert-danger">An error occurred while loading application details.</div>`;
        });
}

function updateApplicationStatus(form) {
    const formData = new FormData(form);
    formData.append('application_id', form.dataset.appId);
    
    fetch('update-application-status.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Application status updated successfully!');
            location.reload(); // Refresh the page to show updated status
        } else {
            alert('Error updating status: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while updating status.');
    });
}
</script>

<?php include '../includes/footer.php'; ?>