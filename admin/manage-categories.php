<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}

$page_title = "Manage Loan Categories";

// Handle Add / Update / Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    try {
        switch ($_POST['action']) {
            case 'add':
                $stmt = $pdo->prepare("INSERT INTO loan_categories (name, icon, description, key_point_1, key_point_2, key_point_3, image_url, min_amount, max_amount, interest_rate, is_featured, sort_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $_POST['name'], $_POST['icon'], $_POST['description'],
                    $_POST['key_point_1'], $_POST['key_point_2'], $_POST['key_point_3'],
                    $_POST['image_url'], $_POST['min_amount'], $_POST['max_amount'],
                    $_POST['interest_rate'], isset($_POST['is_featured']) ? 1 : 0,
                    $_POST['sort_order'], isset($_POST['is_active']) ? 1 : 0
                ]);
                $success = "Category added successfully!";
                break;

            case 'update':
                $stmt = $pdo->prepare("UPDATE loan_categories SET name=?, icon=?, description=?, key_point_1=?, key_point_2=?, key_point_3=?, image_url=?, min_amount=?, max_amount=?, interest_rate=?, is_featured=?, sort_order=?, is_active=? WHERE id=?");
                $stmt->execute([
                    $_POST['name'], $_POST['icon'], $_POST['description'],
                    $_POST['key_point_1'], $_POST['key_point_2'], $_POST['key_point_3'],
                    $_POST['image_url'], $_POST['min_amount'], $_POST['max_amount'],
                    $_POST['interest_rate'], isset($_POST['is_featured']) ? 1 : 0,
                    $_POST['sort_order'], isset($_POST['is_active']) ? 1 : 0,
                    $_POST['id']
                ]);
                $success = "Category updated successfully!";
                break;

            case 'delete':
                $stmt = $pdo->prepare("DELETE FROM loan_categories WHERE id=?");
                $stmt->execute([$_POST['id']]);
                $success = "Category deleted successfully!";
                break;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Fetch all categories
$categories = $pdo->query("SELECT * FROM loan_categories ORDER BY sort_order ASC")->fetchAll();

include '../includes/header.php';
?>

<div class="container py-4">
    <h2 class="text-danger mb-4">Manage Loan Categories</h2>

    <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

    <button class="btn btn-danger mb-3" data-bs-toggle="modal" data-bs-target="#categoryModal">Add Category</button>

    <table class="table table-bordered table-striped">
        <thead class="table-danger">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Icon</th>
                <th>Key Points</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td><?= htmlspecialchars($cat['name']) ?></td>
                <td><?= htmlspecialchars($cat['icon']) ?></td>
                <td>
                    1. <?= htmlspecialchars($cat['key_point_1']) ?><br>
                    2. <?= htmlspecialchars($cat['key_point_2']) ?><br>
                    3. <?= htmlspecialchars($cat['key_point_3']) ?>
                </td>
                <td>
                    <?php if($cat['image_url']): ?>
                        <img src="<?= htmlspecialchars($cat['image_url']) ?>" width="80">
                    <?php endif; ?>
                </td>
                <td><?= $cat['is_active'] ? "<span class='badge bg-success'>Active</span>" : "<span class='badge bg-danger'>Inactive</span>" ?></td>
                <td>
                    <button class="btn btn-sm btn-outline-primary" onclick='editCategory(<?= json_encode($cat) ?>)'>Edit</button>
                    <form method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="categoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="categoryForm">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">Add/Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <input type="hidden" name="id" id="catId">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" id="catName" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Icon</label>
                            <input type="text" class="form-control" name="icon" id="catIcon">
                        </div>
                        <div class="col-12 mb-3">
                            <label>Description</label>
                            <textarea class="form-control" name="description" id="catDescription"></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Key Point 1</label>
                            <input type="text" class="form-control" name="key_point_1" id="kp1">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Key Point 2</label>
                            <input type="text" class="form-control" name="key_point_2" id="kp2">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Key Point 3</label>
                            <input type="text" class="form-control" name="key_point_3" id="kp3">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Image URL</label>
                            <input type="text" class="form-control" name="image_url" id="imgUrl">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Min Amount</label>
                            <input type="number" class="form-control" name="min_amount" id="minAmount" value="10000">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Max Amount</label>
                            <input type="number" class="form-control" name="max_amount" id="maxAmount" value="5000000">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Interest Rate</label>
                            <input type="text" class="form-control" name="interest_rate" id="interestRate" value="7% onwards">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label>Sort Order</label>
                            <input type="number" class="form-control" name="sort_order" id="sortOrder" value="0">
                        </div>
                        <div class="col-md-3 mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="is_active" id="isActive" checked>
                            <label class="form-check-label">Active</label>
                        </div>
                        <div class="col-md-3 mb-3 form-check">
                            <input type="checkbox" class="form-check-input" name="is_featured" id="isFeatured">
                            <label class="form-check-label">Featured</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editCategory(cat) {
    document.getElementById('formAction').value = 'update';
    document.getElementById('catId').value = cat.id;
    document.getElementById('catName').value = cat.name;
    document.getElementById('catIcon').value = cat.icon;
    document.getElementById('catDescription').value = cat.description || '';
    document.getElementById('kp1').value = cat.key_point_1 || '';
    document.getElementById('kp2').value = cat.key_point_2 || '';
    document.getElementById('kp3').value = cat.key_point_3 || '';
    document.getElementById('imgUrl').value = cat.image_url || '';
    document.getElementById('minAmount').value = cat.min_amount;
    document.getElementById('maxAmount').value = cat.max_amount;
    document.getElementById('interestRate').value = cat.interest_rate;
    document.getElementById('sortOrder').value = cat.sort_order;
    document.getElementById('isActive').checked = cat.is_active == 1;
    document.getElementById('isFeatured').checked = cat.is_featured == 1;

    new bootstrap.Modal(document.getElementById('categoryModal')).show();
}

document.getElementById('categoryModal').addEventListener('hidden.bs.modal', function() {
    document.getElementById('categoryForm').reset();
    document.getElementById('formAction').value = 'add';
    document.getElementById('catId').value = '';
});
</script>

<?php include '../includes/footer.php'; ?>
