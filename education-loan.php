
<?php
require_once 'config.php';

$page_title = "Education Loan - Fund Your Dreams";
$page_description = "Study in India & abroad with our education loans. Low interest rates, moratorium period, and covers tuition, living expenses";

include 'includes/header.php';
?>

<div class="loan-page-hero bg-info text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Education Loan</h1>
                <p class="fs-5 mb-4">Fund your education dreams with our student-friendly loan solutions</p>
                <div class="hero-features">
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Study in India & Abroad</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Low Interest Rates: Special student plans</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Moratorium Period: Pay after completion</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=500&h=400&fit=crop" alt="Education Loan" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<!-- Key Features -->
<section class="features-section py-5">
    <div class="container">
        <h3 class="text-info fw-bold text-center mb-5">Key Features of Our Education Loan</h3>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-globe text-info fa-3x mb-3"></i>
                    <h5 class="fw-bold">Study in India & Abroad</h5>
                    <p class="text-muted">Covers tuition fees, living expenses, and travel costs for domestic and international education.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-percentage text-info fa-3x mb-3"></i>
                    <h5 class="fw-bold">Low Interest Rates</h5>
                    <p class="text-muted">Special student-friendly repayment plans with competitive interest rates.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-clock text-info fa-3x mb-3"></i>
                    <h5 class="fw-bold">Moratorium Period</h5>
                    <p class="text-muted">Repayment starts after course completion or 6 months after getting a job.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
