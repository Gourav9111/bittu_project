<?php
session_start();
require_once '../config.php';

// Enable error reporting (disable on production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Check admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$page_title = "Manage Loan Types";

// Fetch all loan types
try {
    $stmt = $pdo->query("SELECT * FROM loan_types ORDER BY name");
    $loan_types = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $loan_types = [];
    $error = "Database error: " . htmlspecialchars($e->getMessage());
}

include '../includes/header.php';
?>

<div class="container-fluid py-4">
    <h2 class="text-danger mb-4">Manage Loan Types</h2>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <button class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#loanModal">Add Loan Type</button>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead class="table-danger">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Amount Range</th>
                    <th>Interest Rate</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($loan_types)): ?>
                    <tr><td colspan="7" class="text-center">No loan types found.</td></tr>
                <?php else: ?>
                    <?php foreach ($loan_types as $loan): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($loan['id']); ?></td>
                            <td><?php echo htmlspecialchars($loan['name']); ?></td>
                            <td><?php echo htmlspecialchars($loan['description'] ?? ''); ?></td>
                            <td>₹<?php echo number_format($loan['min_amount'], 2); ?> - ₹<?php echo number_format($loan['max_amount'], 2); ?></td>
                            <td><?php echo htmlspecialchars($loan['min_interest_rate']); ?>% - <?php echo htmlspecialchars($loan['max_interest_rate']); ?>%</td>
                            <td>
                                <?php echo $loan['is_active'] ? "<span class='badge bg-success'>Active</span>" : "<span class='badge bg-danger'>Inactive</span>"; ?>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" onclick="editLoan(<?php echo $loan['id']; ?>)">Edit</button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteLoan(<?php echo $loan['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="loanModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="loanForm">
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="modalTitle">Add Loan Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <input type="hidden" name="id" id="loanId">

                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" name="name" id="loanName" required maxlength="100">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="loanDescription"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Min Amount *</label>
                            <input type="number" class="form-control" name="min_amount" id="minAmount" min="0" step="0.01" value="10000.00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Amount *</label>
                            <input type="number" class="form-control" name="max_amount" id="maxAmount" min="0" step="0.01" value="1000000.00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Min Interest Rate (%) *</label>
                            <input type="number" step="0.01" class="form-control" name="min_interest_rate" id="minInterest" min="0" value="7.00" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Max Interest Rate (%) *</label>
                            <input type="number" step="0.01" class="form-control" name="max_interest_rate" id="maxInterest" min="0" value="24.00" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActive" checked>
                            <label class="form-check-label" for="isActive">Active</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Edit loan
function editLoan(id) {
    fetch("loan_types.php?action=get&id=" + id)
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert("Failed to load loan data");
                return;
            }
            const loan = data.loan;
            document.getElementById("formAction").value = "update";
            document.getElementById("loanId").value = loan.id;
            document.getElementById("loanName").value = loan.name;
            document.getElementById("loanDescription").value = loan.description || "";
            document.getElementById("minAmount").value = loan.min_amount;
            document.getElementById("maxAmount").value = loan.max_amount;
            document.getElementById("minInterest").value = loan.min_interest_rate;
            document.getElementById("maxInterest").value = loan.max_interest_rate;
            document.getElementById("isActive").checked = loan.is_active == 1;

            document.getElementById("modalTitle").textContent = "Edit Loan Type";
            new bootstrap.Modal(document.getElementById("loanModal")).show();
        })
        .catch(err => {
            console.error(err);
            alert("Error loading loan data.");
        });
}

// Delete loan
function deleteLoan(id) {
    if (!confirm("Are you sure you want to delete this loan type?")) return;
    fetch("loan_types.php", {
        method: "POST",
        headers: {"Content-Type": "application/x-www-form-urlencoded"},
        body: "action=delete&id=" + id
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert("Delete failed: " + data.message);
        }
    });
}

// Submit form
document.getElementById("loanForm").addEventListener("submit", function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("loan_types.php", {
        method: "POST",
        body: new URLSearchParams(formData)
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert("Failed: " + data.message);
        }
    });
});
</script>

<?php include '../includes/footer.php'; ?>
