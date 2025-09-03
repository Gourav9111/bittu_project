<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $message = sanitizeInput($_POST['message']);
        
        // Validate required fields
        if (empty($name) || empty($email) || empty($phone) || empty($message)) {
            throw new Exception('All fields are required.');
        }
        
        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address.');
        }
        
        // Validate phone
        if (!preg_match('/^[0-9]{10}$/', $phone)) {
            throw new Exception('Please enter a valid 10-digit phone number.');
        }
        
        // Insert contact message
        $stmt = $pdo->prepare("
            INSERT INTO contact_messages (name, email, phone, message, status) 
            VALUES (?, ?, ?, ?, 'New')
        ");
        
        $stmt->execute([$name, $email, $phone, $message]);
        
        // Send confirmation email
        $email_subject = "Contact Form Submission - Jay Shree Mahakal Finance";
        $email_message = "
            <h3>Dear {$name},</h3>
            <p>Thank you for contacting Jay Shree Mahakal Finance Services.</p>
            <p>We have received your message and our team will get back to you within 24 hours.</p>
            <p><strong>Your Message:</strong></p>
            <p>{$message}</p>
            <p>Best regards,<br>Jay Shree Mahakal Finance Services</p>
        ";
        
        // Redirect with success message
        header("Location: contact-us.php?success=1");
        exit;
        
    } catch (Exception $e) {
        // Redirect with error message
        header("Location: contact-us.php?error=" . urlencode($e->getMessage()));
        exit;
    }
} else {
    header("Location: contact-us.php");
    exit;
}
?>
