
<?php
require_once '../config.php';

// For development - bypass login check
$_SESSION['admin_id'] = 1;

$response = ['status' => 'error', 'message' => '', 'html' => ''];

if (isset($_GET['id'])) {
    $application_id = intval($_GET['id']);
    
    try {
        // Fetch application details with proper MySQL syntax
        $stmt = $pdo->prepare("
            SELECT da.*, du.name as dsa_name, 
                   CONCAT('DSA', LPAD(du.id, 4, '0')) as dsa_id
            FROM dsa_applications da 
            JOIN dsa_users du ON da.dsa_user_id = du.id 
            WHERE da.id = ?
        ");
        $stmt->execute([$application_id]);
        $application = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($application) {
            // Parse reference details - handle both array and string formats
            $references = [];
            if ($application['reference_details']) {
                $decoded = json_decode($application['reference_details'], true);
                $references = is_array($decoded) ? $decoded : [];
            }
            
            // Parse file arrays - handle both array and string formats
            $salary_slips = [];
            if ($application['salary_slip_files']) {
                $decoded = json_decode($application['salary_slip_files'], true);
                $salary_slips = is_array($decoded) ? $decoded : [];
            }
            
            $other_docs = [];
            if ($application['other_documents']) {
                $decoded = json_decode($application['other_documents'], true);
                $other_docs = is_array($decoded) ? $decoded : [];
            }
            
            $itr_files = [];
            if ($application['itr_files']) {
                $decoded = json_decode($application['itr_files'], true);
                $itr_files = is_array($decoded) ? $decoded : [];
            }
            
            $property_papers = [];
            if ($application['property_papers']) {
                $decoded = json_decode($application['property_papers'], true);
                $property_papers = is_array($decoded) ? $decoded : [];
            }
            
            $html = '<div class="application-details">';
            
            // Application Header
            $html .= '<div class="row mb-3">';
            $html .= '<div class="col-md-6">';
            $html .= '<h6 class="text-danger">Application Information</h6>';
            $html .= '<p><strong>Application ID:</strong> ' . htmlspecialchars($application['application_id']) . '</p>';
            $html .= '<p><strong>Loan Type:</strong> ' . htmlspecialchars($application['loan_type']) . '</p>';
            $html .= '<p><strong>Status:</strong> <span class="badge ';
            switch($application['status']) {
                case 'Pending': $html .= 'bg-warning text-dark'; break;
                case 'Approved': $html .= 'bg-success'; break;
                case 'Rejected': $html .= 'bg-danger'; break;
                case 'In Progress': $html .= 'bg-primary'; break;
                default: $html .= 'bg-secondary';
            }
            $html .= '">' . htmlspecialchars($application['status']) . '</span></p>';
            $html .= '<p><strong>Submitted by DSA:</strong> ' . htmlspecialchars($application['dsa_name']) . ' (' . htmlspecialchars($application['dsa_id']) . ')</p>';
            $html .= '<p><strong>Created:</strong> ' . date('d M Y, H:i', strtotime($application['created_at'])) . '</p>';
            $html .= '</div>';
            $html .= '<div class="col-md-6">';
            $html .= '<h6 class="text-danger">Customer Information</h6>';
            $html .= '<p><strong>Name:</strong> ' . htmlspecialchars($application['customer_name']) . '</p>';
            $html .= '<p><strong>Mobile:</strong> ' . htmlspecialchars($application['customer_mobile']) . '</p>';
            if ($application['customer_email']) {
                $html .= '<p><strong>Email:</strong> ' . htmlspecialchars($application['customer_email']) . '</p>';
            }
            if ($application['mother_name']) {
                $html .= '<p><strong>Mother Name:</strong> ' . htmlspecialchars($application['mother_name']) . '</p>';
            }
            $html .= '</div>';
            $html .= '</div>';
            
            // Document Details
            $html .= '<div class="row mb-3">';
            $html .= '<div class="col-12">';
            $html .= '<h6 class="text-danger">Documents</h6>';
            $html .= '<div class="row">';
            
            // Aadhar Card
            if ($application['aadhar_card_number']) {
                $html .= '<div class="col-md-6 mb-2">';
                $html .= '<strong>Aadhar Card:</strong> ' . htmlspecialchars($application['aadhar_card_number']);
                if ($application['aadhar_card_file']) {
                    $html .= ' <span class="badge bg-success">File Uploaded</span>';
                }
                $html .= '</div>';
            }
            
            // PAN Card
            if ($application['pan_card_number']) {
                $html .= '<div class="col-md-6 mb-2">';
                $html .= '<strong>PAN Card:</strong> ' . htmlspecialchars($application['pan_card_number']);
                if ($application['pan_card_file']) {
                    $html .= ' <span class="badge bg-success">File Uploaded</span>';
                }
                $html .= '</div>';
            }
            
            // Bank Statement
            if ($application['bank_statement_file']) {
                $html .= '<div class="col-md-6 mb-2">';
                $html .= '<strong>Bank Statement:</strong> <span class="badge bg-success">File Uploaded</span>';
                $html .= '</div>';
            }
            
            // Salary Information
            if ($application['salary_amount'] && $application['salary_amount'] > 0) {
                $html .= '<div class="col-md-6 mb-2">';
                $html .= '<strong>Salary Amount:</strong> ₹' . number_format($application['salary_amount'], 2);
                $html .= '</div>';
            }
            
            // Salary Slips
            if (!empty($salary_slips)) {
                $html .= '<div class="col-md-6 mb-2">';
                $html .= '<strong>Salary Slips:</strong> <span class="badge bg-success">' . count($salary_slips) . ' Files Uploaded</span>';
                $html .= '</div>';
            }
            
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</div>';
            
            // Loan Type Specific Information
            if ($application['loan_type'] == 'Business Loan') {
                $html .= '<div class="row mb-3">';
                $html .= '<div class="col-12">';
                $html .= '<h6 class="text-danger">Business Loan Specific</h6>';
                if ($application['gumasta_udhyam_file']) {
                    $html .= '<p><strong>Gumasta/Udhyam:</strong> <span class="badge bg-success">File Uploaded</span></p>';
                }
                if (!empty($itr_files)) {
                    $html .= '<p><strong>ITR Files:</strong> <span class="badge bg-success">' . count($itr_files) . ' Files Uploaded</span></p>';
                }
                $html .= '</div>';
                $html .= '</div>';
            }
            
            if ($application['loan_type'] == 'Home Loan') {
                $html .= '<div class="row mb-3">';
                $html .= '<div class="col-12">';
                $html .= '<h6 class="text-danger">Home Loan Specific</h6>';
                if ($application['income_type']) {
                    $html .= '<p><strong>Income Type:</strong> ' . htmlspecialchars($application['income_type']) . '</p>';
                }
                if ($application['electricity_bill_file']) {
                    $html .= '<p><strong>Electricity Bill:</strong> <span class="badge bg-success">File Uploaded</span></p>';
                }
                if (!empty($property_papers)) {
                    $html .= '<p><strong>Property Papers:</strong> <span class="badge bg-success">' . count($property_papers) . ' Files Uploaded</span></p>';
                }
                $html .= '</div>';
                $html .= '</div>';
            }
            
            // References
            if (!empty($references)) {
                $html .= '<div class="row mb-3">';
                $html .= '<div class="col-12">';
                $html .= '<h6 class="text-danger">References</h6>';
                foreach ($references as $i => $ref) {
                    if (is_array($ref) && isset($ref['name']) && isset($ref['number'])) {
                        $html .= '<p><strong>Reference ' . ($i + 1) . ':</strong> ' . htmlspecialchars($ref['name']) . ' - ' . htmlspecialchars($ref['number']) . '</p>';
                    }
                }
                $html .= '</div>';
                $html .= '</div>';
            }
            
            // Additional Information
            if ($application['office_address'] || $application['address_proof']) {
                $html .= '<div class="row mb-3">';
                $html .= '<div class="col-12">';
                $html .= '<h6 class="text-danger">Additional Information</h6>';
                if ($application['office_address']) {
                    $html .= '<p><strong>Office Address:</strong> ' . htmlspecialchars($application['office_address']) . '</p>';
                }
                if ($application['address_proof']) {
                    $html .= '<p><strong>Address Proof:</strong> ' . htmlspecialchars($application['address_proof']) . '</p>';
                }
                $html .= '</div>';
                $html .= '</div>';
            }
            
            // Other Documents
            if (!empty($other_docs)) {
                $html .= '<div class="row mb-3">';
                $html .= '<div class="col-12">';
                $html .= '<h6 class="text-danger">Other Documents</h6>';
                $html .= '<p><span class="badge bg-info">' . count($other_docs) . ' Additional Files Uploaded</span></p>';
                $html .= '</div>';
                $html .= '</div>';
            }
            
            // Admin Notes
            if ($application['admin_notes']) {
                $html .= '<div class="row mb-3">';
                $html .= '<div class="col-12">';
                $html .= '<h6 class="text-danger">Admin Notes</h6>';
                $html .= '<p>' . nl2br(htmlspecialchars($application['admin_notes'])) . '</p>';
                $html .= '</div>';
                $html .= '</div>';
            }
            
            // Status Update Form
            $html .= '<div class="row mt-4">';
            $html .= '<div class="col-12">';
            $html .= '<h6 class="text-danger">Update Status</h6>';
            $html .= '<form id="updateApplicationStatus" data-app-id="' . $application['id'] . '">';
            $html .= '<div class="row">';
            $html .= '<div class="col-md-6 mb-3">';
            $html .= '<select name="status" class="form-control" required>';
            $html .= '<option value="Pending"' . ($application['status'] == 'Pending' ? ' selected' : '') . '>Pending</option>';
            $html .= '<option value="In Progress"' . ($application['status'] == 'In Progress' ? ' selected' : '') . '>In Progress</option>';
            $html .= '<option value="Approved"' . ($application['status'] == 'Approved' ? ' selected' : '') . '>Approved</option>';
            $html .= '<option value="Rejected"' . ($application['status'] == 'Rejected' ? ' selected' : '') . '>Rejected</option>';
            $html .= '</select>';
            $html .= '</div>';
            $html .= '<div class="col-md-6 mb-3">';
            $html .= '<button type="submit" class="btn btn-danger">Update Status</button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<div class="row">';
            $html .= '<div class="col-12">';
            $html .= '<textarea name="admin_notes" class="form-control" rows="3" placeholder="Add admin notes...">' . htmlspecialchars($application['admin_notes'] ?? '') . '</textarea>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '</form>';
            $html .= '</div>';
            $html .= '</div>';
            
            $html .= '</div>';
            
            $response['status'] = 'success';
            $response['html'] = $html;
        } else {
            $response['message'] = 'Application not found';
        }
        
    } catch (Exception $e) {
        $response['message'] = 'Database error: ' . $e->getMessage();
        error_log('Get Application Details Error: ' . $e->getMessage());
        error_log('Application ID requested: ' . $application_id);
    }
} else {
    $response['message'] = 'Invalid application ID';
}

header('Content-Type: application/json');
echo json_encode($response);
?>
