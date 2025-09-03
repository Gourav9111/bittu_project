
<?php
require_once 'config.php';

$page_title = "Car Loan - Drive Your Dreams";
$page_description = "Get attractive car loans with low EMI options and fast disbursal. Flexible tenure up to 7 years with competitive rates";

include 'includes/header.php';
?>

<div class="loan-page-hero bg-warning text-dark py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Car Loan</h1>
                <p class="fs-5 mb-4">Drive your dream car today with our attractive car loan offers</p>
                <div class="hero-features">
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Attractive Interest Rates: Tailored low EMI</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Fast Disbursal: Quick approval process</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Flexible Tenure: Up to 7 years</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=500&h=400&fit=crop" alt="Car Loan" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
