<?php
// Development configuration for testing
// Use SQLite for local development

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Site constants
define('SITE_URL', 'http://localhost:5000');
define('SITE_NAME', 'Jay Shree Mahakal Finance Services');
define('CONTACT_EMAIL', 'costumercare@jsmf.in');

// SQLite database for development
try {
    $pdo = new PDO('sqlite:development.db');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    // Create tables if they don't exist
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS dsa_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            mobile VARCHAR(15) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            dsa_id VARCHAR(50),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS dsa_applications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            application_id VARCHAR(50) NOT NULL UNIQUE,
            dsa_user_id INTEGER NOT NULL,
            loan_type VARCHAR(50) NOT NULL,
            customer_name VARCHAR(100) NOT NULL,
            customer_mobile VARCHAR(15) NOT NULL,
            customer_email VARCHAR(100),
            mother_name VARCHAR(100),
            office_address TEXT,
            address_proof TEXT,
            salary_amount DECIMAL(10,2),
            aadhar_card_file VARCHAR(255),
            aadhar_card_number VARCHAR(20),
            pan_card_file VARCHAR(255),
            pan_card_number VARCHAR(15),
            salary_slip_files TEXT,
            bank_statement_file VARCHAR(255),
            other_documents TEXT,
            gumasta_udhyam_file VARCHAR(255),
            itr_files TEXT,
            income_type VARCHAR(50),
            electricity_bill_file VARCHAR(255),
            property_papers TEXT,
            reference_details TEXT,
            status VARCHAR(20) DEFAULT 'Pending',
            admin_notes TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (dsa_user_id) REFERENCES dsa_users (id)
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admin_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Insert sample data if tables are empty
    $count = $pdo->query("SELECT COUNT(*) FROM dsa_users")->fetchColumn();
    if ($count == 0) {
        // Insert sample DSA user
        $pdo->exec("
            INSERT INTO dsa_users (name, mobile, email, username, password, dsa_id) 
            VALUES ('gourav', '9111968788', 'gourav9111@gmail.com', 'gourav9111', 'password123', 'DSA0003')
        ");
        
        // Insert sample admin user (password: admin123)
        $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $pdo->exec("
            INSERT INTO admin_users (username, password, email) 
            VALUES ('admin', '$hashedPassword', 'admin@jsmf.in')
        ");
        
        // Insert sample applications
        $pdo->exec("
            INSERT INTO dsa_applications (
                application_id, dsa_user_id, loan_type, customer_name, 
                customer_mobile, customer_email, aadhar_card_number, pan_card_number,
                salary_amount, status
            ) VALUES 
            ('DSA20255773', 1, 'Business Loan', 'HARSH SAHU', '0913303768', 'harsh@example.com', '123456789012', 'ABCDE1234F', 50000, 'Pending'),
            ('DSA20258284', 1, 'Personal Loan', 'aman', '7867868788', 'aman@example.com', '987654321098', 'FGHIJ5678K', 35000, 'Pending')
        ");
    }
    
} catch (PDOException $e) {
    die("❌ Database connection failed: " . $e->getMessage());
}

// Helper function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>