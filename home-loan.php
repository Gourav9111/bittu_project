
<?php
require_once 'config.php';

$page_title = "Home Loan - Starting 7% p.a.";
$page_description = "Get affordable home loans starting at 7% p.a. with flexible tenure up to 30 years and loan amounts up to ₹5 crore";

include 'includes/header.php';
?>

<div class="loan-page-hero bg-danger text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Home Loan</h1>
                <p class="fs-5 mb-4">Make your dream home a reality with our affordable home loans starting at just 7% p.a.</p>
                <div class="hero-features">
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Interest rates starting from 7% p.a.</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Loan amount up to ₹5 crore</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Flexible tenure: 1 to 30 years</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=500&h=400&fit=crop" alt="Home Loan" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<!-- EMI Calculator Section -->
<section class="calculator-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="text-danger fw-bold">Home Loan EMI Calculator</h3>
            <p class="text-muted">Calculate your monthly EMI for home loan</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="calculator-widget bg-white p-4 rounded shadow">
                    <form id="homeLoanCalculator">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="calculator-input">
                                    <label class="form-label fw-bold">Loan Amount</label>
                                    <div class="amount-display text-danger fs-4 fw-bold mb-2">₹10,00,000</div>
                                    <input type="range" class="form-range" id="homeAmount" min="100000" max="50000000" value="1000000" step="50000">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>₹1L</span>
                                        <span>₹5Cr</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="calculator-input">
                                    <label class="form-label fw-bold">Rate of Interest</label>
                                    <div class="rate-display text-danger fs-4 fw-bold mb-2">7.0%</div>
                                    <input type="range" class="form-range" id="homeRate" min="7" max="15" value="7" step="0.1">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>7%</span>
                                        <span>15%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="calculator-input">
                                    <label class="form-label fw-bold">Loan Tenure</label>
                                    <div class="tenure-display text-danger fs-4 fw-bold mb-2">20 Years</div>
                                    <input type="range" class="form-range" id="homeTenure" min="1" max="30" value="20" step="1">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>1Y</span>
                                        <span>30Y</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="emi-result text-center bg-danger text-white p-3 rounded">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="emi-item">
                                                <div class="emi-label small">Monthly Payable</div>
                                                <div class="emi-value fs-4 fw-bold" id="monthlyEMI">₹77,530</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="emi-item">
                                                <div class="emi-label small">Principal Amount</div>
                                                <div class="emi-value fs-6" id="principalAmount">₹10,00,000</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="emi-item">
                                                <div class="emi-label small">Total Interest</div>
                                                <div class="emi-value fs-6" id="totalInterest">₹86,07,200</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <a href="apply-loan.php?type=Home Loan" class="btn btn-success btn-lg w-100 py-3">
                                    <i class="fas fa-file-alt me-2"></i>Apply Now
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Key Features -->
<section class="features-section py-5">
    <div class="container">
        <h3 class="text-danger fw-bold text-center mb-5">Key Features of Our Home Loan</h3>
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-percentage text-danger fa-3x mb-3"></i>
                    <h5 class="fw-bold">Affordable Interest Rates</h5>
                    <p class="text-muted">Starting as low as 7% p.a., among the lowest in the market with competitive rates.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-calendar-alt text-danger fa-3x mb-3"></i>
                    <h5 class="fw-bold">Flexible Tenure</h5>
                    <p class="text-muted">Repay over 1 to 30 years as per your convenience with flexible EMI options.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm">
                    <i class="fas fa-coins text-danger fa-3x mb-3"></i>
                    <h5 class="fw-bold">High Loan Amounts</h5>
                    <p class="text-muted">Get funding up to ₹5 crore depending on your eligibility and requirements.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Eligibility Section -->
<section class="eligibility-section py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-danger fw-bold mb-4">Eligibility Criteria</h3>
                <div class="eligibility-list">
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-user text-danger me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Age</h6>
                            <p class="mb-0 text-muted">21 to 65 years for salaried, 21 to 70 years for self-employed</p>
                        </div>
                    </div>
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-rupee-sign text-danger me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Minimum Income</h6>
                            <p class="mb-0 text-muted">₹25,000 per month for salaried, ₹3 lakh annual income for self-employed</p>
                        </div>
                    </div>
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-briefcase text-danger me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Employment</h6>
                            <p class="mb-0 text-muted">Minimum 2 years work experience, 1 year with current employer</p>
                        </div>
                    </div>
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-credit-card text-danger me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Credit Score</h6>
                            <p class="mb-0 text-muted">Minimum CIBIL score of 650 (higher scores get better rates)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="text-danger fw-bold mb-4">Documents Required</h3>
                <div class="documents-list">
                    <div class="document-category mb-4">
                        <h6 class="fw-bold text-dark">Identity Proof:</h6>
                        <ul class="list-unstyled ms-3">
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>Aadhaar Card</li>
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>PAN Card</li>
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>Passport</li>
                        </ul>
                    </div>
                    <div class="document-category mb-4">
                        <h6 class="fw-bold text-dark">Income Proof:</h6>
                        <ul class="list-unstyled ms-3">
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>Salary Slips (3 months)</li>
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>Bank Statements (6 months)</li>
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>ITR (2 years)</li>
                        </ul>
                    </div>
                    <div class="document-category">
                        <h6 class="fw-bold text-dark">Property Documents:</h6>
                        <ul class="list-unstyled ms-3">
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>Sale Agreement</li>
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>Property Papers</li>
                            <li><i class="fas fa-dot-circle text-danger me-2"></i>NOC from Builder</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountSlider = document.getElementById('homeAmount');
    const rateSlider = document.getElementById('homeRate');
    const tenureSlider = document.getElementById('homeTenure');
    
    function updateHomeLoanCalculator() {
        const amount = parseInt(amountSlider.value);
        const rate = parseFloat(rateSlider.value);
        const tenure = parseInt(tenureSlider.value);
        
        // Update displays
        document.querySelector('.amount-display').textContent = '₹' + formatAmount(amount);
        document.querySelector('.rate-display').textContent = rate.toFixed(1) + '%';
        document.querySelector('.tenure-display').textContent = tenure + ' Years';
        
        // Calculate EMI
        const monthlyRate = rate / (12 * 100);
        const months = tenure * 12;
        const emi = amount * monthlyRate * Math.pow(1 + monthlyRate, months) / (Math.pow(1 + monthlyRate, months) - 1);
        const totalAmount = emi * months;
        const totalInterest = totalAmount - amount;
        
        document.getElementById('monthlyEMI').textContent = '₹' + formatAmount(Math.round(emi));
        document.getElementById('principalAmount').textContent = '₹' + formatAmount(amount);
        document.getElementById('totalInterest').textContent = '₹' + formatAmount(Math.round(totalInterest));
    }
    
    function formatAmount(amount) {
        return new Intl.NumberFormat('en-IN').format(amount);
    }
    
    amountSlider.addEventListener('input', updateHomeLoanCalculator);
    rateSlider.addEventListener('input', updateHomeLoanCalculator);
    tenureSlider.addEventListener('input', updateHomeLoanCalculator);
    
    updateHomeLoanCalculator();
});
</script>

<?php include 'includes/footer.php'; ?>
