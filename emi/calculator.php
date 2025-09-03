<?php
require_once '../config.php';

$page_title = "EMI Calculator";
$page_description = "Calculate your loan EMI with our easy-to-use EMI calculator. Get instant results for Home Loans, Personal Loans, Car Loans and more";

include '../includes/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="calculator-container">
                <div class="text-center mb-4">
                    <h2 class="text-danger fw-bold">EMI Calculator</h2>
                    <p class="text-muted">Calculate your Equated Monthly Installment (EMI) instantly</p>
                </div>

                <form id="emiCalculatorForm">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loanAmount" class="form-label">Loan Amount (₹)</label>
                                <input type="range" class="form-range" id="loanAmount" min="10000" max="5000000" value="500000" step="10000">
                                <div class="d-flex justify-content-between">
                                    <small>₹10K</small>
                                    <small id="amountDisplay" class="fw-bold text-danger">₹5,00,000</small>
                                    <small>₹50L</small>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="setLoanAmount(100000)">₹1L</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="setLoanAmount(500000)">₹5L</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="setLoanAmount(1000000)">₹10L</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="setLoanAmount(2000000)">₹20L</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="interestRate" class="form-label">Interest Rate (% per annum)</label>
                                <input type="range" class="form-range" id="interestRate" min="7" max="24" value="11" step="0.1">
                                <div class="d-flex justify-content-between">
                                    <small>7%</small>
                                    <small id="rateDisplay" class="fw-bold text-danger">11%</small>
                                    <small>24%</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="loanTenure" class="form-label">Loan Tenure (Years)</label>
                                <input type="range" class="form-range" id="loanTenure" min="1" max="30" value="20" step="1">
                                <div class="d-flex justify-content-between">
                                    <small>1Y</small>
                                    <small id="tenureDisplay" class="fw-bold text-danger">20 years</small>
                                    <small>30Y</small>
                                </div>
                                <div class="mt-2">
                                    <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="setTenure(5)">5Y</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="setTenure(10)">10Y</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger me-1" onclick="setTenure(15)">15Y</button>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="setTenure(20)">20Y</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Results -->
                <div class="calculator-result">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="result-item">
                                <span id="emiAmount" class="result-value">₹48,251</span>
                                <span class="result-label">Monthly EMI</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="result-item">
                                <span id="totalInterest" class="result-value">₹61,60,240</span>
                                <span class="result-label">Total Interest</span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="result-item">
                                <span id="totalAmount" class="result-value">₹1,15,60,240</span>
                                <span class="result-label">Total Amount</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart -->
                <div class="mt-4">
                    <h5 class="text-center mb-3">Loan Breakdown</h5>
                    <div style="height: 300px; position: relative;">
                        <canvas id="emiChart"></canvas>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <a href="../apply-loan.php" class="btn btn-danger btn-lg me-3">
                        <i class="fas fa-file-alt me-2"></i>Apply for Loan
                    </a>
                    <button type="button" class="btn btn-outline-danger btn-lg me-3" onclick="shareCalculation()">
                        <i class="fas fa-share me-2"></i>Share
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-lg" onclick="downloadSchedule()">
                        <i class="fas fa-download me-2"></i>Download Schedule
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">Loan Information</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Processing fee: 0.5% to 2%</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>No prepayment charges</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Quick approval in 24 hours</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Flexible repayment options</li>
                        <li><i class="fas fa-check text-success me-2"></i>Minimal documentation</li>
                    </ul>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">Interest Rates</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Personal Loan:</span>
                        <span class="fw-bold">10.5% - 18%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Home Loan:</span>
                        <span class="fw-bold">7% - 12%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Car Loan:</span>
                        <span class="fw-bold">8% - 14%</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Education Loan:</span>
                        <span class="fw-bold">8.5% - 15%</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Business Loan:</span>
                        <span class="fw-bold">11% - 20%</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">Need Help?</h6>
                </div>
                <div class="card-body text-center">
                    <p class="mb-3">Speak with our loan experts</p>
                    <a href="tel:<?php echo CONTACT_PHONE; ?>" class="btn btn-danger btn-sm mb-2 w-100">
                        <i class="fas fa-phone me-2"></i><?php echo CONTACT_PHONE; ?>
                    </a>
                    <a href="../contact-us.php" class="btn btn-outline-danger btn-sm w-100">
                        <i class="fas fa-envelope me-2"></i>Send Message
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Amortization Schedule -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Amortization Schedule (First 12 months + Yearly Summary)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Period</th>
                                    <th>EMI</th>
                                    <th>Principal</th>
                                    <th>Interest</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody id="breakdownTableBody">
                                <!-- Table content will be populated by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/emi-calculator.js"></script>

<?php include '../includes/footer.php'; ?>
