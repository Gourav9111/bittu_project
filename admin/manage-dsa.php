<?php
session_start();
require_once("../config.php"); // include your DB connection

// ✅ Handle Approve / Reject KYC
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] == 'approve') {
        $stmt = $pdo->prepare("UPDATE dsa_users SET kyc_status='approved' WHERE id=?");
        $stmt->execute([$id]);
    } elseif ($_GET['action'] == 'reject') {
        $stmt = $pdo->prepare("UPDATE dsa_users SET kyc_status='rejected' WHERE id=?");
        $stmt->execute([$id]);
    }
    header("Location: manage-dsa.php");
    exit;
}

// ✅ Handle Password Reset
if (isset($_POST['reset_password'])) {
    $id = intval($_POST['user_id']);
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE dsa_users SET password=? WHERE id=?");
    $stmt->execute([$new_password, $id]);
    header("Location: manage-dsa.php");
    exit;
}

// ✅ Handle Lead Assignment
if (isset($_POST['assign_lead'])) {
    $id = intval($_POST['user_id']);
    $lead_details = $_POST['lead_details'];
    $stmt = $pdo->prepare("INSERT INTO lead_assignments (dsa_id, lead_details, assigned_at) VALUES (?, ?, NOW())");
    $stmt->execute([$id, $lead_details]);
    header("Location: manage-dsa.php");
    exit;
}

// ✅ Fetch All DSAs
$stmt = $pdo->query("SELECT * FROM dsa_users ORDER BY id DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage DSA</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
        th { background: #333; color: white; }
        .btn { padding: 6px 12px; margin: 2px; text-decoration: none; border-radius: 5px; }
        .approve { background: green; color: white; }
        .reject { background: red; color: white; }
        .reset { background: orange; color: white; }
        .assign { background: blue; color: white; }
    </style>
</head>
<body>
    <h2>Manage DSA Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>KYC Status</th>
            <th>Change Password</th>
            <th>Assign Lead</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['id']) ?></td>
            <td><?= htmlspecialchars($user['name']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['kyc_status']) ?></td>
            <td>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <input type="password" name="new_password" placeholder="New Password" required>
                    <button type="submit" name="reset_password" class="btn reset">Reset</button>
                </form>
            </td>
            <td>
                <form method="post" style="display:inline-block;">
                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                    <input type="text" name="lead_details" placeholder="Lead Details" required>
                    <button type="submit" name="assign_lead" class="btn assign">Assign</button>
                </form>
            </td>
            <td>
                <a href="manage-dsa.php?action=approve&id=<?= $user['id'] ?>" class="btn approve">Approve</a>
                <a href="manage-dsa.php?action=reject&id=<?= $user['id'] ?>" class="btn reject">Reject</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
