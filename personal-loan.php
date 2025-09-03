
<?php
require_once 'config.php';

$page_title = "Personal Loan - Quick Approval";
$page_description = "Get instant personal loans with minimal documentation. No collateral needed, quick approval based on income and credit score";

include 'includes/header.php';
?>

<div class="loan-page-hero bg-success text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-3">Personal Loan</h1>
                <p class="fs-5 mb-4">Quick approval with minimal documentation for all your personal needs</p>
                <div class="hero-features">
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Quick Approval: Minimal documentation</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>No Collateral Needed</span>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-2">
                        <i class="fas fa-check-circle me-3"></i>
                        <span>Flexible Use: Medical, travel, personal expenses</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="https://images.unsplash.com/photo-1633158829585-23ba8f7c8caf?w=500&h=400&fit=crop" alt="Personal Loan" class="img-fluid rounded shadow">
            </div>
        </div>
    </div>
</div>

<!-- EMI Calculator Section -->
<section class="calculator-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="text-success fw-bold">Personal Loan EMI Calculator</h3>
            <p class="text-muted">Calculate your monthly EMI for personal loan</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="calculator-widget bg-white p-4 rounded shadow">
                    <form id="personalLoanCalculator">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="calculator-input">
                                    <label class="form-label fw-bold">Loan Amount</label>
                                    <div class="amount-display text-success fs-4 fw-bold mb-2">₹2,00,000</div>
                                    <input type="range" class="form-range" id="personalAmount" min="10000" max="2000000" value="200000" step="10000">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>₹10K</span>
                                        <span>₹20L</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="calculator-input">
                                    <label class="form-label fw-bold">Rate of Interest</label>
                                    <div class="rate-display text-success fs-4 fw-bold mb-2">10.5%</div>
                                    <input type="range" class="form-range" id="personalRate" min="10.5" max="18" value="10.5" step="0.1">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>10.5%</span>
                                        <span>18%</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="calculator-input">
                                    <label class="form-label fw-bold">Loan Tenure</label>
                                    <div class="tenure-display text-success fs-4 fw-bold mb-2">3 Years</div>
                                    <input type="range" class="form-range" id="personalTenure" min="1" max="7" value="3" step="1">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>1Y</span>
                                        <span>7Y</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mt-4">
                            <div class="col-md-8">
                                <div class="emi-result text-center bg-success text-white p-3 rounded">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="emi-item">
                                                <div class="emi-label small">Monthly Payable</div>
                                                <div class="emi-value fs-4 fw-bold" id="monthlyEMI">₹6,494</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="emi-item">
                                                <div class="emi-label small">Principal Amount</div>
                                                <div class="emi-value fs-6" id="principalAmount">₹2,00,000</div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="emi-item">
                                                <div class="emi-label small">Total Interest</div>
                                                <div class="emi-value fs-6" id="totalInterest">₹33,784</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <a href="apply-loan.php?type=Personal Loan" class="btn btn-success btn-lg w-100 py-3">
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

<!-- Eligibility & Documents -->
<section class="eligibility-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-success fw-bold mb-4">Eligibility Criteria</h3>
                <div class="eligibility-list">
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-user text-success me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Age</h6>
                            <p class="mb-0 text-muted">21 to 60 years</p>
                        </div>
                    </div>
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-rupee-sign text-success me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Minimum Income</h6>
                            <p class="mb-0 text-muted">₹15,000 per month</p>
                        </div>
                    </div>
                    <div class="eligibility-item d-flex align-items-start mb-3">
                        <i class="fas fa-credit-card text-success me-3 mt-1"></i>
                        <div>
                            <h6 class="fw-bold">Credit Score</h6>
                            <p class="mb-0 text-muted">Minimum 600 (650+ preferred)</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="text-success fw-bold mb-4">Documents Required</h3>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-dot-circle text-success me-2"></i>Aadhaar Card & PAN Card</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-success me-2"></i>Salary Slips (3 months)</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-success me-2"></i>Bank Statements (3 months)</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-success me-2"></i>Employment Certificate</li>
                    <li class="mb-2"><i class="fas fa-dot-circle text-success me-2"></i>Passport Size Photographs</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountSlider = document.getElementById('personalAmount');
    const rateSlider = document.getElementById('personalRate');
    const tenureSlider = document.getElementById('personalTenure');
    
    function updatePersonalLoanCalculator() {
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
    
    amountSlider.addEventListener('input', updatePersonalLoanCalculator);
    rateSlider.addEventListener('input', updatePersonalLoanCalculator);
    tenureSlider.addEventListener('input', updatePersonalLoanCalculator);
    
    updatePersonalLoanCalculator();
});
</script>

<?php include 'includes/footer.php'; ?>
