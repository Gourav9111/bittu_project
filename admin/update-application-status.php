<?php
require_once '../config.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit;
}

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $application_id = intval($_POST['application_id']);
    $status = sanitizeInput($_POST['status']);
    $admin_notes = sanitizeInput($_POST['admin_notes'] ?? '');
    
    try {
        $stmt = $pdo->prepare("
            UPDATE dsa_applications 
            SET status = ?, admin_notes = ?, updated_at = NOW() 
            WHERE id = ?
        ");
        
        if ($stmt->execute([$status, $admin_notes, $application_id])) {
            $response['success'] = true;
            $response['message'] = 'Application status updated successfully';
        } else {
            $response['message'] = 'Failed to update application status';
        }
        
    } catch (Exception $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
    }
} else {
    $response['message'] = 'Invalid request method';
}

header('Content-Type: application/json');
echo json_encode($response);
?>