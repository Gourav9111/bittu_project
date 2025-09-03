<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' . SITE_NAME : SITE_NAME; ?></title>
    <meta name="description" content="<?php echo isset($page_description) ? $page_description : 'Jay Shree Mahakal Finance Services - Your trusted finance partner for all loan needs'; ?>">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Custom CSS -->
    <link href="<?php echo SITE_URL; ?>/assets/css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="bg-white shadow-sm py-2">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <div class="logo d-flex align-items-center">
                        <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="JSMF Logo" height="50" class="me-3">
                        <div>
                            <h4 class="text-danger mb-0 fw-bold">Jay Shree Mahakal</h4>
                            <small class="text-muted">Finance Services</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <h5 class="text-danger mb-0 d-none d-md-block">Professional Financial Services</h5>
                    <small class="text-muted d-none d-md-block">Trusted by thousands of customers</small>
                </div>
                <div class="col-md-3 text-end">
                    <div class="header-buttons">
                        <a href="<?php echo SITE_URL; ?>/check-status.php" class="btn btn-outline-danger btn-sm me-2">Check Status</a>
                        <a href="<?php echo SITE_URL; ?>/apply-loan.php" class="btn btn-danger btn-sm">Apply Now</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="loansDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-coins me-1"></i>Loans
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="personal-loan.php"><i class="fas fa-user me-2"></i>Personal Loan</a></li>
                                    <li><a class="dropdown-item" href="home-loan.php"><i class="fas fa-home me-2"></i>Home Loan</a></li>
                                    <li><a class="dropdown-item" href="education-loan.php"><i class="fas fa-graduation-cap me-2"></i>Education Loan</a></li>
                                    <li><a class="dropdown-item" href="car-loan.php"><i class="fas fa-car me-2"></i>Car Loan</a></li>
                                    <li><a class="dropdown-item" href="business-loan.php"><i class="fas fa-briefcase me-2"></i>Business Loan</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="apply-loan.php?type=Plot Purchase"><i class="fas fa-map-marked-alt me-2"></i>Plot Purchase</a></li>
                                    <li><a class="dropdown-item" href="apply-loan.php?type=Construction Loan"><i class="fas fa-hammer me-2"></i>Construction Loan</a></li>
                                    <li><a class="dropdown-item" href="apply-loan.php?type=Renovation Loan"><i class="fas fa-tools me-2"></i>Renovation Loan</a></li>
                                    <li><a class="dropdown-item" href="apply-loan.php?type=Balance Transfer"><i class="fas fa-exchange-alt me-2"></i>Balance Transfer</a></li>
                                    <li><a class="dropdown-item" href="apply-loan.php?type=LAP (Loan Against Property)"><i class="fas fa-building me-2"></i>LAP</a></li>
                                </ul>
                            </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/emi/calculator.php">EMI Calculator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/contact-us.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo SITE_URL; ?>/dsa/login.php">DSA Portal</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>