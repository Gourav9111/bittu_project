
<?php
require_once 'config.php';

$page_title = "Business Loan - Growth Support";
$page_description = "Finance your business growth with our business loans up to ₹5 crore. Working capital, expansion, or new setup funding available";

include 'includes/header.php';
?>

<div class="loan-page-hero bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Business Loan</h1>
                <p class="fs-5 mb-4">Grow your business with our comprehensive business financing solutions</p>
                <div class="hero-features">
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Growth Support: Working capital & expansion</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Higher Limits: Up to ₹5 crore</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Tax Benefits: Interest may be tax deductible</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=500&h=400&fit=crop" alt="Business Loan" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<!-- Key Features -->
<section class="features-section py-5">
    <div class="container">
        <h3 class="text-primary fw-bold text-center mb-5">Key Features of Our Business Loan</h3>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-chart-line text-primary fa-3x mb-3"></i>
                    <h5 class="fw-bold">Growth Support</h5>
                    <p class="text-muted">Finance for working capital, business expansion, or new business setup with flexible terms.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-coins text-primary fa-3x mb-3"></i>
                    <h5 class="fw-bold">Higher Limits</h5>
                    <p class="text-muted">Loan amount up to ₹5 crore depending on business turnover and requirements.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-calculator text-primary fa-3x mb-3"></i>
                    <h5 class="fw-bold">Tax Benefits</h5>
                    <p class="text-muted">Interest payments may qualify for business expense deductions under Income Tax Act.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Eligibility & Documents -->
<section class="eligibility-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-primary fw-bold mb-4">Eligibility Criteria</h3>
                <div class="eligibility-list">
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-building text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Business Vintage</h6>
                            <p class="mb-0 text-muted">Minimum 2 years in operation</p>
                        </div>
                    </div>
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-rupee-sign text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Annual Turnover</h6>
                            <p class="mb-0 text-muted">Minimum ₹40 lakh per annum</p>
                        </div>
                    </div>
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-credit-card text-primary me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Credit Score</h6>
                            <p class="mb-0 text-muted">Minimum 650 for business and promoters</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="text-primary fw-bold mb-4">Documents Required</h3>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-dot-circle text-primary me-2"></i>GST Returns (12 months)</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-primary me-2"></i>ITR (2 years)</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-primary me-2"></i>Bank Statements (12 months)</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-primary me-2"></i>Business Registration Certificate</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-primary me-2"></i>MOA & AOA (for companies)</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-primary me-2"></i>Partnership Deed (for partnerships)</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
