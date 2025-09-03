<?php
// --------------------------
// Config for Jay Shree Mahakal Finance Services
// --------------------------

// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'u900473099_gourav');
define('DB_USER', 'u900473099_gourav');
define('DB_PASS', 'Gourav@9111968788');

// Site constants
define('SITE_URL', 'https://jsmf.in');
define('SITE_NAME', 'Jay Shree Mahakal Finance Services');
define('CONTACT_EMAIL', 'costumercare@jsmf.in');

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// PDO connection
try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4",
        DB_USER,
        DB_PASS
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}

// Helper function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
