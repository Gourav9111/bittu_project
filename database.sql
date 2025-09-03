-- Database schema for Jay Shree Mahakal Finance Services

-- Loan applications table
CREATE TABLE IF NOT EXISTS loan_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id VARCHAR(20) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    city VARCHAR(50) NOT NULL,
    loan_type VARCHAR(50) NOT NULL,
    loan_amount DECIMAL(12,2) NOT NULL,
    monthly_income DECIMAL(10,2) NOT NULL,
    pan_aadhar VARCHAR(50),
    status ENUM('Pending', 'Approved', 'Rejected', 'Processing') DEFAULT 'Pending',
    assigned_dsa_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- DSA users table
CREATE TABLE IF NOT EXISTS dsa_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    mobile VARCHAR(15) NOT NULL,
    experience VARCHAR(50) NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_pic VARCHAR(255),
    kyc_status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admin users table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('super', 'admin') DEFAULT 'admin',
    status ENUM('Active', 'Inactive') DEFAULT 'Active',
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Notifications table
CREATE TABLE IF NOT EXISTS notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message TEXT NOT NULL,
    target ENUM('dsa', 'all') DEFAULT 'all',
    target_user_id INT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contact messages table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('New', 'Read', 'Replied') DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Lead assignments table
CREATE TABLE IF NOT EXISTS lead_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_id INT NOT NULL,
    dsa_id INT NOT NULL,
    assigned_by INT NOT NULL,
    status ENUM('Assigned', 'In Progress', 'Follow-Up', 'Submitted', 'Completed') DEFAULT 'Assigned',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (application_id) REFERENCES loan_applications(id),
    FOREIGN KEY (dsa_id) REFERENCES dsa_users(id),
    FOREIGN KEY (assigned_by) REFERENCES admin_users(id)
);

-- Loan categories table for admin-managed loan types
CREATE TABLE IF NOT EXISTS loan_categories (
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
);

-- Insert default admin user (remove existing first)
DELETE FROM admin_users WHERE username = 'admin';
INSERT INTO admin_users (username, password, email, role, status) VALUES 
('admin', '$2y$10$EUIKgzpE7P4Y8GQwnGn.kuIxKBFnLgJcwjJxP9vKh4oHGY8KQpj/6', 'admin@jsmf.in', 'super', 'Active');
-- Password is: admin123

-- Sample loan types for reference
CREATE TABLE IF NOT EXISTS loan_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    min_amount DECIMAL(12,2) DEFAULT 10000,
    max_amount DECIMAL(12,2) DEFAULT 5000000,
    min_interest_rate DECIMAL(5,2) DEFAULT 7.00,
    max_interest_rate DECIMAL(5,2) DEFAULT 24.00,
    is_active BOOLEAN DEFAULT TRUE
);

INSERT INTO loan_types (name, description, min_amount, max_amount, min_interest_rate, max_interest_rate) VALUES
('Personal Loan', 'Quick personal loans for immediate needs', 10000, 1000000, 10.50, 18.00),
('Home Loan', 'Affordable home loans with competitive rates', 500000, 50000000, 7.00, 12.00),
('Education Loan', 'Fund your education dreams', 50000, 2000000, 8.50, 15.00),
('Car Loan', 'Drive your dream car today', 100000, 2000000, 8.00, 14.00),
('Business Loan', 'Grow your business with our support', 100000, 5000000, 11.00, 20.00),
('Plot Purchase', 'Buy your dream plot', 200000, 10000000, 9.00, 15.00),
('Construction Loan', 'Build your dream home', 500000, 5000000, 9.50, 16.00),
('Renovation Loan', 'Renovate and upgrade your home', 50000, 1000000, 10.00, 17.00),
('Balance Transfer', 'Transfer and save on interest', 100000, 5000000, 8.50, 15.00),
('LAP (Loan Against Property)', 'Leverage your property value', 500000, 10000000, 9.00, 16.00);
