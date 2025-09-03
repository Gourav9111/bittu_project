<?php
require_once '../config.php';

// Check if user is logged in
if (!isset($_SESSION['dsa_id'])) {
    header("Location: login.php");
    exit;
}

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $dsa_user_id = $_SESSION['dsa_id'];
        $loan_type = sanitizeInput($_POST['loan_type']);
        $customer_name = sanitizeInput($_POST['customer_name']);
        $customer_mobile = sanitizeInput($_POST['customer_mobile']);
        $customer_email = sanitizeInput($_POST['customer_email']);
        
        // Generate unique application ID
        $application_id = 'DSA' . date('Y') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        
        // Handle file uploads
        $upload_dir = '../uploads/dsa_applications/' . $dsa_user_id . '/';
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $uploaded_files = [];
        
        // Function to handle file upload
        function uploadFile($file, $upload_dir, $prefix = '') {
            if ($file['error'] !== UPLOAD_ERR_OK) {
                return null;
            }
            
            $file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $new_filename = $prefix . uniqid() . '.' . $file_extension;
            $destination = $upload_dir . $new_filename;
            
            if (move_uploaded_file($file['tmp_name'], $destination)) {
                return $new_filename;
            }
            
            return null;
        }
        
        // Handle multiple files upload
        function uploadMultipleFiles($files, $upload_dir, $prefix = '') {
            $uploaded = [];
            
            if (is_array($files['name'])) {
                for ($i = 0; $i < count($files['name']); $i++) {
                    if ($files['error'][$i] === UPLOAD_ERR_OK) {
                        $file = [
                            'name' => $files['name'][$i],
                            'tmp_name' => $files['tmp_name'][$i],
                            'error' => $files['error'][$i]
                        ];
                        $filename = uploadFile($file, $upload_dir, $prefix);
                        if ($filename) {
                            $uploaded[] = $filename;
                        }
                    }
                }
            } else {
                $filename = uploadFile($files, $upload_dir, $prefix);
                if ($filename) {
                    $uploaded[] = $filename;
                }
            }
            
            return $uploaded;
        }
        
        // Upload documents
        $aadhar_card_file = isset($_FILES['aadhar_card_file']) ? uploadFile($_FILES['aadhar_card_file'], $upload_dir, 'aadhar_') : null;
        $pan_card_file = isset($_FILES['pan_card_file']) ? uploadFile($_FILES['pan_card_file'], $upload_dir, 'pan_') : null;
        $bank_statement_file = isset($_FILES['bank_statement_file']) ? uploadFile($_FILES['bank_statement_file'], $upload_dir, 'bank_') : null;
        
        $salary_slip_files = isset($_FILES['salary_slip_files']) ? uploadMultipleFiles($_FILES['salary_slip_files'], $upload_dir, 'salary_') : [];
        $other_documents = isset($_FILES['other_documents']) ? uploadMultipleFiles($_FILES['other_documents'], $upload_dir, 'other_') : [];
        
        // Loan type specific uploads
        $gumasta_udhyam_file = isset($_FILES['gumasta_udhyam_file']) ? uploadFile($_FILES['gumasta_udhyam_file'], $upload_dir, 'gumasta_') : null;
        $itr_files = isset($_FILES['itr_files']) ? uploadMultipleFiles($_FILES['itr_files'], $upload_dir, 'itr_') : [];
        $electricity_bill_file = isset($_FILES['electricity_bill_file']) ? uploadFile($_FILES['electricity_bill_file'], $upload_dir, 'electricity_') : null;
        $property_papers = isset($_FILES['property_papers']) ? uploadMultipleFiles($_FILES['property_papers'], $upload_dir, 'property_') : [];
        
        // Prepare reference details
        $reference_details = [];
        if (isset($_POST['reference1_name']) && isset($_POST['reference1_number'])) {
            $reference_details[] = [
                'name' => sanitizeInput($_POST['reference1_name']),
                'number' => sanitizeInput($_POST['reference1_number'])
            ];
        }
        if (isset($_POST['reference2_name']) && isset($_POST['reference2_number'])) {
            $reference_details[] = [
                'name' => sanitizeInput($_POST['reference2_name']),
                'number' => sanitizeInput($_POST['reference2_number'])
            ];
        }
        
        // Insert into database
        $sql = "INSERT INTO dsa_applications (
            application_id, dsa_user_id, loan_type, customer_name, customer_mobile, customer_email,
            mother_name, office_address, address_proof, salary_amount,
            aadhar_card_file, aadhar_card_number, pan_card_file, pan_card_number,
            salary_slip_files, bank_statement_file, other_documents,
            gumasta_udhyam_file, itr_files, income_type, electricity_bill_file, property_papers,
            reference_details, status, created_at
        ) VALUES (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', NOW()
        )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $application_id,
            $dsa_user_id,
            $loan_type,
            $customer_name,
            $customer_mobile,
            $customer_email,
            sanitizeInput($_POST['mother_name'] ?? ''),
            sanitizeInput($_POST['office_address'] ?? ''),
            sanitizeInput($_POST['address_proof'] ?? ''),
            floatval($_POST['salary_amount'] ?? 0),
            $aadhar_card_file,
            sanitizeInput($_POST['aadhar_card_number'] ?? ''),
            $pan_card_file,
            sanitizeInput($_POST['pan_card_number'] ?? ''),
            json_encode($salary_slip_files),
            $bank_statement_file,
            json_encode($other_documents),
            $gumasta_udhyam_file,
            json_encode($itr_files),
            sanitizeInput($_POST['income_type'] ?? ''),
            $electricity_bill_file,
            json_encode($property_papers),
            json_encode($reference_details)
        ]);
        
        $_SESSION['success_message'] = "Loan application submitted successfully! Application ID: " . $application_id;
        header("Location: dashboard.php");
        exit;
        
    } catch (Exception $e) {
        $_SESSION['error_message'] = "Error submitting application: " . $e->getMessage();
        header("Location: dashboard.php");
        exit;
    }
}

// If not POST request, redirect back
header("Location: dashboard.php");
exit;
?>