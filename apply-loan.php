<?php
// apply-loan.php
// Get loan type from query (fallback to "Personal Loan")
$current_type = isset($_GET['type']) ? htmlspecialchars($_GET['type'], ENT_QUOTES, 'UTF-8') : 'Personal Loan';

// Allowed loan types (for dropdown and server-side safety)
$loan_types = [
  'Personal Loan','Home Loan','Education Loan','Car Loan','Business Loan',
  'Plot Purchase','Construction Loan','Renovation Loan','Balance Transfer','LAP (Loan Against Property)'
];
// If provided type isn't in list, reset to default
if (!in_array($current_type, $loan_types, true)) { $current_type = 'Personal Loan'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Apply for <?php echo $current_type; ?> | JSMF</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Animate.css for subtle motion -->
  <link href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" rel="stylesheet">
  <style>
    body { background:#fff; }
    .navbar { box-shadow: 0 6px 16px rgba(0,0,0,0.06); }
    .card { border:0; border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); }
    .card-header { border-top-left-radius:14px; border-top-right-radius:14px; }
    .form-control:focus, .form-select:focus {
      border-color:#dc3545; box-shadow: 0 0 0 .2rem rgba(220,53,69,.15);
    }
    .btn-danger { border-radius: 10px; }
    .floating {
      animation: floatIn .7s ease-out;
    }
    @keyframes floatIn {
      from { transform: translateY(18px); opacity: 0; }
      to   { transform: translateY(0); opacity: 1; }
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Jay Shree Mahakal Finance</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="services.php">Services</a></li>
        <li class="nav-item"><a class="nav-link" href="contact-us.php">Contact</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-7">
      <div class="card floating">
        <div class="card-header bg-danger text-white text-center py-3">
          <h4 class="mb-0">Apply for <?php echo $current_type; ?></h4>
        </div>
        <div class="card-body p-4">
          <form action="process-loan.php" method="POST" novalidate>
            <!-- Keep both hidden and visible select so user may change loan type -->
            <input type="hidden" name="loan_type" value="<?php echo $current_type; ?>">
            <div class="mb-3">
              <label class="form-label">Loan Type</label>
              <select class="form-select" id="loan_type_select">
                <?php foreach ($loan_types as $type): ?>
                  <option value="<?php echo htmlspecialchars($type, ENT_QUOTES); ?>" <?php echo $type === $current_type ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($type); ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="form-text">You can change the loan type here.</div>
            </div>

            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                <input type="tel" name="mobile" class="form-control" pattern="[0-9]{10}" maxlength="10" required>
                <div class="form-text">10-digit number only</div>
              </div>
              <div class="col-md-6">
                <label class="form-label">City <span class="text-danger">*</span></label>
                <input type="text" name="city" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Loan Amount (₹) <span class="text-danger">*</span></label>
                <input type="number" name="loan_amount" class="form-control" min="10000" step="1000" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Monthly Income (₹) <span class="text-danger">*</span></label>
                <input type="number" name="monthly_income" class="form-control" min="10000" step="500" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">PAN / Aadhar (optional)</label>
                <input type="text" name="pan_aadhar" class="form-control">
              </div>
            </div>

            <div class="d-grid mt-4">
              <button type="submit" class="btn btn-danger btn-lg">Submit Application</button>
            </div>
          </form>
        </div>
      </div>

      <p class="text-center text-muted mt-3 animate__animated animate__fadeInUp">Secure &amp; Confidential. We usually respond within 24 hours.</p>
    </div>
  </div>
</div>

<script>
  // Keep hidden loan_type in sync with dropdown (so server receives updated value)
  const select = document.getElementById('loan_type_select');
  const hidden = document.querySelector('input[name="loan_type"]');
  select.addEventListener('change', () => { hidden.value = select.value; });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
