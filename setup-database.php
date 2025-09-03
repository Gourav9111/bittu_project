
<?php
// Database setup for local development
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Create database if not exists
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS jsmf_finance");
    $pdo->exec("USE jsmf_finance");
    
    // Read and execute SQL file
    $sql = file_get_contents('database.sql');
    $statements = explode(';', $sql);
    
    foreach ($statements as $statement) {
        $statement = trim($statement);
        if (!empty($statement)) {
            $pdo->exec($statement);
        }
    }
    
    // Create admin user
    $adminPassword = password_hash('Harsh@9131', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO admin_users (username, password, email, role, status) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE password = VALUES(password)");
    $stmt->execute(['admin', $adminPassword, 'admin@jsmf.in', 'admin', 'Active']);
    
    echo "Database setup completed successfully!\n";
    echo "Admin Login:\n";
    echo "Username: admin\n";
    echo "Password: Harsh@9131\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
