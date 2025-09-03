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
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="viewApplication(<?php echo $application['id']; ?>)">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </button>
                                            <button class="btn btn-sm btn-outline-info" 
                                                    onclick="viewApplicationNewWindow(<?php echo $application['id']; ?>)"
                                                    title="Open in new window">
                                                <i class="fas fa-external-link-alt"></i>
                                            </button>
                                        </div>
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
// Check if Bootstrap is loaded
if (typeof bootstrap === 'undefined') {
    console.error('Bootstrap is not loaded');
}

function viewApplication(applicationId) {
    console.log('Viewing application ID:', applicationId);
    
    const modalElement = document.getElementById('applicationModal');
    const modalBody = document.getElementById('applicationDetails');
    
    if (!modalElement || !modalBody) {
        console.error('Modal elements not found');
        alert('Modal elements not found. Please refresh the page and try again.');
        return;
    }

    const modal = new bootstrap.Modal(modalElement);
    modalBody.innerHTML = `
        <div class="text-center py-4">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2">Loading application details...</p>
        </div>
    `;
    modal.show();

    // Use XMLHttpRequest as fallback
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'get-application-details.php?id=' + applicationId, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    if (data.status === 'success') {
                        modalBody.innerHTML = data.html;
                        
                        // Form submission is already handled by onsubmit attribute
                    } else {
                        modalBody.innerHTML = `
                            <div class="alert alert-danger">
                                <strong>Error:</strong> ${data.message || 'Unknown error occurred'}
                            </div>
                        `;
                    }
                } catch (e) {
                    console.error('JSON Parse Error:', e);
                    modalBody.innerHTML = `
                        <div class="alert alert-danger">
                            <strong>Error:</strong> Invalid response from server. Response: ${xhr.responseText.substring(0, 200)}...
                        </div>
                    `;
                }
            } else {
                console.error('HTTP Error:', xhr.status, xhr.statusText);
                modalBody.innerHTML = `
                    <div class="alert alert-danger">
                        <strong>HTTP Error ${xhr.status}:</strong> ${xhr.statusText}
                        <br><small>Please check if the file exists and try again.</small>
                    </div>
                `;
            }
        }
    };
    xhr.onerror = function() {
        console.error('Network Error');
        modalBody.innerHTML = `
            <div class="alert alert-danger">
                <strong>Network Error:</strong> Could not connect to server.
                <br><small>Please check your internet connection and try again.</small>
            </div>
        `;
    };
    xhr.send();
}

function updateApplicationStatus(form) {
    const formData = new FormData(form);
    
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status"></span> Updating...';
    submitBtn.disabled = true;
    
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update-application-status.php', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            if (xhr.status === 200) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    if (data.success) {
                        alert('Application status updated successfully!');
                        location.reload();
                    } else {
                        alert('Error updating status: ' + (data.message || 'Unknown error'));
                    }
                } catch (e) {
                    console.error('Parse error:', e);
                    alert('Error parsing response from server.');
                }
            } else {
                alert('HTTP Error: ' + xhr.status + ' - ' + xhr.statusText);
            }
        }
    };
    xhr.onerror = function() {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
        alert('Network error occurred while updating status.');
    };
    xhr.send(formData);
}

// Alternative method - open in new window
function viewApplicationNewWindow(applicationId) {
    const url = 'get-application-details.php?id=' + applicationId + '&popup=1';
    window.open(url, 'ApplicationDetails', 'width=800,height=600,scrollbars=yes,resizable=yes');
}
</script>

<?php include '../includes/footer.php'; ?>