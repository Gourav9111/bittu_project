
<?php
require_once '../config.php';

// For development - bypass login check
$_SESSION['admin_id'] = 1;

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['application_id'])) {
    $application_id = intval($_POST['application_id']);
    $status = $_POST['status'] ?? '';
    $admin_notes = $_POST['admin_notes'] ?? '';
    
    if ($application_id > 0 && !empty($status)) {
        try {
            $stmt = $pdo->prepare("
                UPDATE dsa_applications 
                SET status = ?, admin_notes = ?, updated_at = CURRENT_TIMESTAMP 
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
            error_log('Update Application Status Error: ' . $e->getMessage());
        }
    } else {
        $response['message'] = 'Invalid application ID or status. Received ID: ' . $application_id . ', Status: ' . $status;
    }
} else {
    $response['message'] = 'Invalid request method or missing data. POST data: ' . json_encode($_POST);
}

header('Content-Type: application/json');
echo json_encode($response);
?>
