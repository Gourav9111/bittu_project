
<?php
// Development configuration for testing
// Use MySQL for consistency with production

// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Site constants
define('SITE_URL', 'http://localhost:5000');
define('SITE_NAME', 'Jay Shree Mahakal Finance Services');
define('CONTACT_EMAIL', 'costumercare@jsmf.in');

// MySQL database connection
try {
    // For local development, you can adjust these credentials
    $host = 'localhost';
    $dbname = 'u900473099_gourav'; // Use your actual database name
    $username = 'u900473099_gourav'; // Use your actual username
    $password = 'Harsh@9131'; // Use your actual password
    
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    // Fallback to SQLite for local development if MySQL connection fails
    try {
        $pdo = new PDO('sqlite:development.db');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        // Create tables if they don't exist (SQLite version)
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
            CREATE TABLE IF NOT EXISTS admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username VARCHAR(50) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                email VARCHAR(100) NOT NULL UNIQUE,
                role VARCHAR(20) DEFAULT 'admin',
                status VARCHAR(20) DEFAULT 'Active',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");
        
        // Insert sample data if tables are empty
        $count = $pdo->query("SELECT COUNT(*) FROM dsa_users")->fetchColumn();
        if ($count == 0) {
            // Insert sample DSA user
            $pdo->exec("
                INSERT INTO dsa_users (name, mobile, email, username, password, dsa_id, experience, address, kyc_status) 
                VALUES ('gourav', '9111968788', 'gourav9111@gmail.com', 'gourav9111', 'password123', 'DSA0003', '1-3 years', 'gourav9111', 'Approved')
            ");
            
            // Insert sample admin user
            $hashedPassword = password_hash('admin123', PASSWORD_DEFAULT);
            $pdo->exec("
                INSERT INTO admin_users (username, password, email, role) 
                VALUES ('admin', '$hashedPassword', 'admin@jsmf.in', 'super')
            ");
        }
        
    } catch (PDOException $fallbackError) {
        die("❌ Database connection failed: " . $e->getMessage() . " (SQLite fallback also failed: " . $fallbackError->getMessage() . ")");
    }
}

// Helper function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}
?>
