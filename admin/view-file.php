
<?php
require_once '../config.php';

// For development - bypass login check
$_SESSION['admin_id'] = 1;

if (!isset($_GET['file']) || !isset($_GET['dsa_id'])) {
    http_response_code(404);
    exit('File not found');
}

$dsa_id = intval($_GET['dsa_id']);
$filename = basename($_GET['file']); // Sanitize filename

// Construct file path
$file_path = '../uploads/dsa_applications/' . $dsa_id . '/' . $filename;

// Check if file exists
if (!file_exists($file_path)) {
    http_response_code(404);
    exit('File not found');
}

// Get file info
$file_info = pathinfo($file_path);
$file_extension = strtolower($file_info['extension']);

// Set appropriate content type
$content_types = [
    'pdf' => 'application/pdf',
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'doc' => 'application/msword',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'txt' => 'text/plain'
];

$content_type = isset($content_types[$file_extension]) ? $content_types[$file_extension] : 'application/octet-stream';

// Set headers
header('Content-Type: ' . $content_type);
header('Content-Length: ' . filesize($file_path));
header('Content-Disposition: inline; filename="' . $filename . '"');

// Output file
readfile($file_path);
?>
