<?php
require_once '../config.php';

// Update application status or assign DSA
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $app_id = intval($_POST['app_id']);
    $status = $_POST['status'] ?? null;
    $assigned_dsa = $_POST['assigned_dsa'] ?? null;

    try {
        $sql = "UPDATE loan_applications 
                SET status = :status, 
                    assigned_dsa = :assigned_dsa, 
                    assigned_dsa_id = :assigned_dsa 
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':status' => $status,
            ':assigned_dsa' => $assigned_dsa ?: null,
            ':id' => $app_id
        ]);
        $message = "✅ Application updated and assigned to DSA successfully!";
    } catch (PDOException $e) {
        $message = "❌ Error updating application: " . $e->getMessage();
    }
}

// Fetch applications
$applications = $pdo->query("SELECT * FROM loan_applications ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);

// Fetch DSA users
$dsas = $pdo->query("SELECT id, name FROM dsa_users")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Loan Applications - Admin</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <style>
    body { background: #fff; color: #222; }
    .table { border-radius: 8px; overflow: hidden; }
    .table thead { background: #dc3545; color: white; }
    .status-pending { color: orange; font-weight: bold; }
    .status-approved { color: green; font-weight: bold; }
    .status-rejected { color: red; font-weight: bold; }
    .status-processing { color: blue; font-weight: bold; }
    .status-review { color: purple; font-weight: bold; }
    .card { animation: fadeIn 0.5s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity:1; transform: translateY(0);} }
  </style>
</head>
<body class="p-4">
<div class="container">
  <h2 class="mb-4 text-danger">📋 Loan Applications</h2>

  <?php if (!empty($message)): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
  <?php endif; ?>

  <table class="table table-striped shadow">
    <thead>
      <tr>
        <th>ID</th>
        <th>Applicant</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Loan Type</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Assigned DSA</th>
        <th>Update</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($applications as $app): ?>
      <tr>
        <td><?= $app['id'] ?></td>
        <td><?= htmlspecialchars($app['applicant_name']) ?></td>
        <td><?= htmlspecialchars($app['email']) ?></td>
        <td><?= htmlspecialchars($app['mobile']) ?></td>
        <td><?= htmlspecialchars($app['loan_type']) ?></td>
        <td>₹<?= number_format($app['loan_amount']) ?></td>
        <td class="status-<?= strtolower($app['status']) ?>"><?= htmlspecialchars($app['status']) ?></td>
        <td>
          <?php
            if ($app['assigned_dsa']) {
                $dsaStmt = $pdo->prepare("SELECT name FROM dsa_users WHERE id = ?");
                $dsaStmt->execute([$app['assigned_dsa']]);
                echo htmlspecialchars($dsaStmt->fetchColumn() ?: "Unknown");
            } else {
                echo "Not Assigned";
            }
          ?>
        </td>
        <td>
          <form method="post" class="d-flex gap-1">
            <input type="hidden" name="app_id" value="<?= $app['id'] ?>">
            <select name="status" class="form-select form-select-sm">
              <option <?= $app['status']=="Pending"?"selected":"" ?>>Pending</option>
              <option <?= $app['status']=="Approved"?"selected":"" ?>>Approved</option>
              <option <?= $app['status']=="Rejected"?"selected":"" ?>>Rejected</option>
              <option <?= $app['status']=="Review"?"selected":"" ?>>Review</option>
              <option <?= $app['status']=="Processing"?"selected":"" ?>>Processing</option>
            </select>
            <select name="assigned_dsa" class="form-select form-select-sm">
              <option value="">Assign DSA</option>
              <?php foreach ($dsas as $dsa): ?>
                <option value="<?= $dsa['id'] ?>" <?= $app['assigned_dsa']==$dsa['id']?"selected":"" ?>>
                  <?= htmlspecialchars($dsa['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <button class="btn btn-danger btn-sm">Update</button>
          </form>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
</body>
</html>
