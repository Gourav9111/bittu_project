<?php
// --------------------------
// Config for Jay Shree Mahakal Finance Services
// --------------------------

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
        CREATE TABLE IF NOT EXISTS admin_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            role VARCHAR(20) DEFAULT 'admin',
            status VARCHAR(20) DEFAULT 'Active',
            last_login DATETIME,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS dsa_users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL,
            mobile VARCHAR(15) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            dsa_id VARCHAR(50),
            experience VARCHAR(50),
            previous_experience TEXT,
            address TEXT,
            kyc_status VARCHAR(20) DEFAULT 'Pending',
            status VARCHAR(20) DEFAULT 'Active',
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
        CREATE TABLE IF NOT EXISTS loan_applications (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            applicant_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            application_id VARCHAR(20) NOT NULL UNIQUE,
            name VARCHAR(100) NOT NULL,
            mobile VARCHAR(15) NOT NULL,
            city VARCHAR(50) NOT NULL,
            loan_type VARCHAR(50) NOT NULL,
            loan_amount DECIMAL(12,2) NOT NULL,
            monthly_income DECIMAL(10,2) NOT NULL,
            pan_aadhar VARCHAR(50),
            status VARCHAR(20) DEFAULT 'Pending',
            assigned_dsa INTEGER,
            assigned_dsa_id INTEGER,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS loan_types (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(100) NOT NULL UNIQUE,
            description TEXT,
            min_amount DECIMAL(12,2) DEFAULT 10000.00,
            max_amount DECIMAL(12,2) DEFAULT 5000000.00,
            min_interest_rate DECIMAL(5,2) DEFAULT 7.00,
            max_interest_rate DECIMAL(5,2) DEFAULT 24.00,
            is_active INTEGER DEFAULT 1
        )
    ");
    
    // Insert sample data if tables are empty
    $count = $pdo->query("SELECT COUNT(*) FROM admin_users")->fetchColumn();
    if ($count == 0) {
        // Insert admin user (username: admin, password: Harsh@9131)
        $pdo->exec("
            INSERT INTO admin_users (username, password, email) 
            VALUES ('admin', 'Harsh@9131', 'admin@jsmf.in')
        ");
        
        // Insert DSA users matching your production data
        $pdo->exec("
            INSERT INTO dsa_users (id, name, mobile, email, username, password, dsa_id, experience, previous_experience, address, kyc_status, status) 
            VALUES 
            (1, 'HARSH SAHU', '8131703768', 'jsmfbhopal@gmail.com', 'namo', 'password123', 'DSA0001', '1-3 years', '1e2qwrty', 'Shop No 2, Near Mittal College, Karond', 'Pending', 'Active'),
            (2, 'HARSH SAHU', '0913703767', 'jsmfbh4fopal@gmail.com', 'aaaa', 'password123', 'DSA0002', '5-10 years', 'qadsfg', 'Shop No 2, Near Mittal College, Karond', 'Approved', 'Active'),
            (3, 'gourav', '9111968788', 'gourav9111@gmail.com', 'gourav9111', 'password123', 'DSA0003', '1-3 years', 'i am demo user for check server working', 'gourav9111', 'Approved', 'Active')
        ");
        
        // Insert sample DSA applications
        $pdo->exec("
            INSERT INTO dsa_applications (
                application_id, dsa_user_id, loan_type, customer_name, 
                customer_mobile, customer_email, aadhar_card_number, pan_card_number,
                salary_amount, status
            ) VALUES 
            ('DSA20255773', 3, 'Business Loan', 'HARSH SAHU', '0913303768', 'harsh@example.com', '123456789012', 'ABCDE1234F', 50000, 'Pending'),
            ('DSA20258284', 3, 'Personal Loan', 'aman', '7867868788', 'aman@example.com', '987654321098', 'FGHIJ5678K', 35000, 'Pending')
        ");
        
        // Insert basic loan types
        $pdo->exec("
            INSERT INTO loan_types (name, description, min_amount, max_amount, min_interest_rate, max_interest_rate, is_active) VALUES
            ('Personal Loan', 'Quick personal loans for immediate needs', 10000.00, 1000000.00, 10.50, 18.00, 1),
            ('Home Loan', 'Affordable home loans with competitive rates', 500000.00, 50000000.00, 7.00, 12.00, 1),
            ('Business Loan', 'Grow your business with our support', 100000.00, 5000000.00, 11.00, 20.00, 1),
            ('Car Loan', 'Drive your dream car today', 100000.00, 2000000.00, 8.00, 14.00, 1)
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
