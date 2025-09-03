
<?php
require_once 'config.php';

echo "Fixing database structure and admin login...\n";

try {
    // First, check if email column exists in admin_users table
    $stmt = $pdo->query("SHOW COLUMNS FROM admin_users LIKE 'email'");
    if ($stmt->rowCount() == 0) {
        echo "Adding email column to admin_users table...\n";
        $pdo->exec("ALTER TABLE admin_users ADD COLUMN email VARCHAR(100) AFTER password");
    }

    // Create loan_categories table for managing loan types from admin
    $pdo->exec("CREATE TABLE IF NOT EXISTS loan_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        icon VARCHAR(100) NOT NULL,
        description TEXT,
        key_point_1 VARCHAR(200),
        key_point_2 VARCHAR(200),
        key_point_3 VARCHAR(200),
        image_url VARCHAR(500),
        min_amount DECIMAL(12,2) DEFAULT 10000,
        max_amount DECIMAL(12,2) DEFAULT 5000000,
        interest_rate VARCHAR(50) DEFAULT '7% onwards',
        is_featured BOOLEAN DEFAULT FALSE,
        sort_order INT DEFAULT 0,
        is_active BOOLEAN DEFAULT TRUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )");

    // Insert default loan categories
    $pdo->exec("INSERT INTO loan_categories (name, icon, description, key_point_1, key_point_2, key_point_3, image_url, min_amount, max_amount, interest_rate, is_featured, sort_order) VALUES
    ('Personal Loan', 'fas fa-user', 'Quick personal loans for immediate needs', 'Instant approval in 30 minutes', 'No collateral required', 'Flexible repayment up to 5 years', 'https://images.unsplash.com/photo-1633158829585-23ba8f7c8caf?w=400&h=250&fit=crop', 10000, 1000000, '10.5% onwards', 1, 1),
    ('Home Loan', 'fas fa-home', 'Affordable home loans with competitive rates', 'Up to 90% property value funding', 'Tax benefits available', 'Tenure up to 30 years', 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=250&fit=crop', 500000, 50000000, '7% onwards', 1, 2),
    ('Education Loan', 'fas fa-graduation-cap', 'Fund your education dreams', 'Cover full course fees', 'Moratorium period available', 'No processing fees', 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=400&h=250&fit=crop', 50000, 2000000, '8.5% onwards', 1, 3),
    ('Car Loan', 'fas fa-car', 'Drive your dream car today', 'Up to 90% on-road price', 'Quick approval in 2 hours', 'Zero down payment options', 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400&h=250&fit=crop', 100000, 2000000, '8% onwards', 1, 4),
    ('Business Loan', 'fas fa-briefcase', 'Grow your business with our support', 'Minimal documentation', 'Quick disbursal process', 'Flexible repayment terms', 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=300&h=200&fit=crop', 100000, 5000000, '11% onwards', 0, 5),
    ('Plot Purchase', 'fas fa-map-marked-alt', 'Buy your dream plot', 'Up to 80% plot value', 'Attractive interest rates', 'Easy documentation', 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=300&h=200&fit=crop', 200000, 10000000, '9% onwards', 0, 6)
    ON DUPLICATE KEY UPDATE name=VALUES(name)");

    // Hash the password
    $password = 'Harsh@9131';
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if admin user exists and update/create
    $stmt = $pdo->prepare("SELECT id FROM admin_users WHERE username = 'admin'");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        $stmt = $pdo->prepare("UPDATE admin_users SET password = ?, email = ?, status = 'Active' WHERE username = 'admin'");
        $stmt->execute([$hashedPassword, 'admin@jsmf.in']);
        echo "Admin user updated successfully!\n";
    } else {
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password, email, role, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute(['admin', $hashedPassword, 'admin@jsmf.in', 'super', 'Active']);
        echo "Admin user created successfully!\n";
    }

    echo "Database structure fixed!\n";
    echo "Admin Login Credentials:\n";
    echo "Username: admin\n";
    echo "Password: Harsh@9131\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
