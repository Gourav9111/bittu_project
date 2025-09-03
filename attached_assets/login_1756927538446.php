<?php
session_start();

// Include your database config
require_once __DIR__ . '/../config.php';

$error = "";

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    try {
        $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user) {
            // Check password (hashed or plain)
            if (password_verify($password, $user['password']) || $password === $user['password']) {
                // Successful login
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];

                // Update last login
                $update = $pdo->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
                $update->execute([$user['id']]);

                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid username or password!";
            }
        } else {
            $error = "Invalid username or password!";
        }

    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; }
    .login-container { width: 350px; margin: 100px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    input[type="text"], input[type="password"] { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ccc; border-radius: 4px; }
    input[type="submit"] { width: 100%; padding: 10px; background: #007BFF; border: none; color: #fff; border-radius: 4px; cursor: pointer; }
    input[type="submit"]:hover { background: #0056b3; }
    .error { color: red; margin: 10px 0; text-align: center; }
</style>
</head>
<body>

<div class="login-container">
    <h2 style="text-align:center;">Admin Login</h2>
    <?php if ($error) echo "<div class='error'>$error</div>"; ?>
    <form method="post">
        <input type="text" name="username" placeholder="Username" required />
        <input type="password" name="password" placeholder="Password" required />
        <input type="submit" value="Login" />
    </form>
</div>

</body>
</html>
