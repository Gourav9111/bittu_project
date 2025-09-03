<?php
// process-loan.php
// Show errors during setup; you can disable later.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load PDO connection ($pdo)
require_once __DIR__ . '/config.php';

// Guard: ensure $pdo exists and is a PDO instance
if (!isset($pdo) || !($pdo instanceof PDO)) {
  http_response_code(500);
  echo "<h3 style='font-family:Arial;color:#b30000'>Database not initialized.</h3>";
  echo "<p style='font-family:Arial'>Make sure <code>config.php</code> creates <code>\$pdo = new PDO(...)</code>.</p>";
  exit;
}

// Helpers
function h($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); }
function sanitize($v){ return h(trim($v)); }
function generateApplicationId(){
  $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $r = '';
  for ($i=0; $i<8; $i++) { $r .= $chars[random_int(0, strlen($chars)-1)]; }
  return 'JSMA'.$r;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: apply-loan.php');
  exit;
}

try {
  // Collect + sanitize
  $name            = sanitize($_POST['name'] ?? '');
  $mobile          = sanitize($_POST['mobile'] ?? '');
  $city            = sanitize($_POST['city'] ?? '');
  $loan_type       = sanitize($_POST['loan_type'] ?? 'Personal Loan');
  $loan_amount_raw = str_replace(',', '', $_POST['loan_amount'] ?? '');
  $monthly_income_raw = str_replace(',', '', $_POST['monthly_income'] ?? '');
  $pan_aadhar      = sanitize($_POST['pan_aadhar'] ?? '');

  // Basic validations
  if ($name === '' || $mobile === '' || $city === '' || $loan_type === '' || $loan_amount_raw === '' || $monthly_income_raw === '') {
    throw new RuntimeException('All required fields must be filled.');
  }
  if (!preg_match('/^[0-9]{10}$/', $mobile)) {
    throw new RuntimeException('Please enter a valid 10-digit mobile number.');
  }
  if (!is_numeric($loan_amount_raw) || (float)$loan_amount_raw < 10000) {
    throw new RuntimeException('Loan amount must be at least ₹10,000.');
  }
  if (!is_numeric($monthly_income_raw) || (float)$monthly_income_raw < 10000) {
    throw new RuntimeException('Monthly income must be at least ₹10,000.');
  }

  $loan_amount    = (float)$loan_amount_raw;
  $monthly_income = (float)$monthly_income_raw;
  $application_id = generateApplicationId();

  // Insert into your existing table structure
  // Columns (from your schema):
  // id, application_id, name, mobile, city, loan_type, loan_amount, monthly_income, pan_aadhar,
  // status ENUM('Pending','Approved','Rejected','Processing') DEFAULT 'Pending',
  // assigned_dsa_id INT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_at TIMESTAMP ...
  $sql = "INSERT INTO loan_applications
          (application_id, name, mobile, city, loan_type, loan_amount, monthly_income, pan_aadhar, status, assigned_dsa_id, created_at)
          VALUES
          (:application_id, :name, :mobile, :city, :loan_type, :loan_amount, :monthly_income, :pan_aadhar, 'Pending', NULL, NOW())";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':application_id' => $application_id,
    ':name'           => $name,
    ':mobile'         => $mobile,
    ':city'           => $city,
    ':loan_type'      => $loan_type,
    ':loan_amount'    => $loan_amount,
    ':monthly_income' => $monthly_income,
    ':pan_aadhar'     => $pan_aadhar
  ]);

  // Success page (red/white UI)
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Application Submitted | JSMF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
    <style>
      body { background:#fff; }
      .card { border:0; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
      .floating { animation: floatIn .6s ease-out; }
      @keyframes floatIn { from{transform:translateY(18px);opacity:0} to{transform:translateY(0);opacity:1} }
      .btn-danger { border-radius: 10px; }
    </style>
  </head>
  <body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card floating">
          <div class="card-header bg-danger text-white text-center py-3">
            <h4 class="mb-0">🎉 Application Submitted</h4>
          </div>
          <div class="card-body p-4 text-center">
            <p class="lead mb-3">Thank you, <strong><?php echo h($name); ?></strong>.</p>
            <p>Your Application ID is:</p>
            <h3 class="text-danger fw-bold mb-4"><?php echo h($application_id); ?></h3>
            <p class="text-muted">Please save this ID for future reference. Our team will contact you shortly.</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
              <a href="index.php" class="btn btn-danger px-4">Back to Home</a>
              <a href="apply-loan.php?type=<?php echo urlencode($loan_type); ?>" class="btn btn-outline-danger px-4">Submit Another</a>
            </div>
          </div>
        </div>
        <p class="text-center text-muted mt-3 animate__animated animate__fadeInUp">Secure &amp; Confidential • Usually reviewed within 24 hours</p>
      </div>
    </div>
  </div>
  </body>
  </html>
  <?php

} catch (Throwable $e) {
  http_response_code(400);
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Submission Error | JSMF</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <div class="alert alert-danger shadow-sm">
            <h5 class="mb-2">We couldn’t submit your application</h5>
            <div><?php echo h($e->getMessage()); ?></div>
            <hr>
            <a href="javascript:history.back()" class="btn btn-danger">Go Back</a>
          </div>
        </div>
      </div>
    </div>
  </body>
  </html>
  <?php
}
