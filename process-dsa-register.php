<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Sanitize and validate input
        $name = sanitizeInput($_POST['name']);
        $mobile = sanitizeInput($_POST['mobile']);
        $email = sanitizeInput($_POST['email']);
        $experience = sanitizeInput($_POST['experience']);
        $previous_experience = sanitizeInput($_POST['previous_experience'] ?? '');
        $username = sanitizeInput($_POST['username']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $address = sanitizeInput($_POST['address'] ?? '');
        
        // Validate required fields
        if (empty($name) || empty($mobile) || empty($email) || empty($experience) || 
            empty($username) || empty($password) || empty($address)) {
            throw new Exception('All required fields must be filled.');
        }
        
        // Validate mobile number
        if (!preg_match('/^[0-9]{10}$/', $mobile)) {
            throw new Exception('Please enter a valid 10-digit mobile number.');
        }
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address.');
        }
        
        // Validate password
        if (strlen($password) < 8) {
            throw new Exception('Password must be at least 8 characters long.');
        }
        
        if ($password !== $confirm_password) {
            throw new Exception('Passwords do not match.');
        }
        
        // Validate username
        if (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username)) {
            throw new Exception('Username must be 4-20 characters (letters, numbers, underscore only).');
        }
        
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT id FROM dsa_users WHERE username = ?");
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            throw new Exception('Username already exists. Please choose a different username.');
        }
        
        // Check if mobile already exists
        $stmt = $pdo->prepare("SELECT id FROM dsa_users WHERE mobile = ?");
        $stmt->execute([$mobile]);
        if ($stmt->fetch()) {
            throw new Exception('Mobile number already registered. Please use a different number.');
        }
        
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM dsa_users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            throw new Exception('Email already registered. Please use a different email.');
        }
        
        // Handle profile picture upload
        $profile_pic = null;
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/profiles/';
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_extension = strtolower(pathinfo($_FILES['profile_pic']['name'], PATHINFO_EXTENSION));
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            
            if (in_array($file_extension, $allowed_extensions)) {
                $file_name = 'profile_' . time() . '_' . mt_rand(1000, 9999) . '.' . $file_extension;
                $file_path = $upload_dir . $file_name;
                
                if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $file_path)) {
                    $profile_pic = $file_name;
                }
            }
        }
        
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert DSA user
        $stmt = $pdo->prepare("
            INSERT INTO dsa_users 
            (name, mobile, email, experience, previous_experience, username, password, profile_pic, address, kyc_status, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'Active')
        ");
        
        $stmt->execute([
            $name,
            $mobile,
            $email,
            $experience,
            $previous_experience,
            $username,
            $hashed_password,
            $profile_pic,
            $address
        ]);
        
        // Send confirmation email (if email function is working)
        $email_subject = "DSA Registration Received - Jay Shree Mahakal Finance";
        $email_message = "
            <h3>Dear {$name},</h3>
            <p>Thank you for registering as a Direct Selling Agent with Jay Shree Mahakal Finance Services.</p>
            <p><strong>Registration Details:</strong></p>
            <ul>
                <li>Name: {$name}</li>
                <li>Username: {$username}</li>
                <li>Mobile: {$mobile}</li>
                <li>Experience: {$experience}</li>
                <li>Status: KYC Pending</li>
            </ul>
            <p>Your application is under review. Our team will verify your details and approve your account within 24-48 hours.</p>
            <p>You will receive a notification once your account is approved and you can start accessing the DSA portal.</p>
            <p>Best regards,<br>Jay Shree Mahakal Finance Services</p>
        ";
        
        // Redirect to success page
        header("Location: dsa/register.php?success=1");
        exit;
        
    } catch (Exception $e) {
        // Redirect back with error
        header("Location: dsa/register.php?error=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    header("Location: dsa/register.php");
    exit;
}
?>
