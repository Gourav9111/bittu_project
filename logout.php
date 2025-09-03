<?php
session_start();

// Determine redirect URL based on user type
$redirect_url = 'index.php';

if (isset($_SESSION['admin_id'])) {
    $redirect_url = 'admin/login.php';
} elseif (isset($_SESSION['dsa_id'])) {
    $redirect_url = 'dsa/login.php';
}

// Clear all session variables
$_SESSION = array();

// Delete the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to appropriate login page
header("Location: " . $redirect_url . "?message=logged_out");
exit;
?>
