// EMI Calculator JavaScript

let emiChart = null;

document.addEventListener('DOMContentLoaded', function() {
    initEMICalculator();
});

function initEMICalculator() {
    const form = document.getElementById('emiCalculatorForm');
    const amountSlider = document.getElementById('loanAmount');
    const rateSlider = document.getElementById('interestRate');
    const tenureSlider = document.getElementById('loanTenure');
    
    // Set up event listeners
    [amountSlider, rateSlider, tenureSlider].forEach(slider => {
        if (slider) {
            slider.addEventListener('input', function() {
                updateDisplayValues();
                calculateEMI();
            });
        }
    });
    
    // Initialize with default values
    updateDisplayValues();
    calculateEMI();
    
    // Form submission
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            calculateEMI();
        });
    }
}

function updateDisplayValues() {
    const amount = document.getElementById('loanAmount').value;
    const rate = document.getElementById('interestRate').value;
    const tenure = document.getElementById('loanTenure').value;
    
    document.getElementById('amountDisplay').textContent = formatCurrency(amount);
    document.getElementById('rateDisplay').textContent = rate + '%';
    document.getElementById('tenureDisplay').textContent = tenure + ' years';
}

function calculateEMI() {
    const principal = parseFloat(document.getElementById('loanAmount').value);
    const annualRate = parseFloat(document.getElementById('interestRate').value);
    const tenureYears = parseFloat(document.getElementById('loanTenure').value);
    
    // Convert to monthly values
    const monthlyRate = annualRate / (12 * 100);
    const tenureMonths = tenureYears * 12;
    
    // EMI calculation using formula: P * r * (1+r)^n / ((1+r)^n - 1)
    let emi = 0;
    if (monthlyRate > 0) {
        const numerator = principal * monthlyRate * Math.pow(1 + monthlyRate, tenureMonths);
        const denominator = Math.pow(1 + monthlyRate, tenureMonths) - 1;
        emi = numerator / denominator;
    } else {
        // If interest rate is 0
        emi = principal / tenureMonths;
    }
    
    const totalAmount = emi * tenureMonths;
    const totalInterest = totalAmount - principal;
    
    // Update result displays
    document.getElementById('emiAmount').textContent = '₹' + formatCurrency(Math.round(emi));
    document.getElementById('totalInterest').textContent = '₹' + formatCurrency(Math.round(totalInterest));
    document.getElementById('totalAmount').textContent = '₹' + formatCurrency(Math.round(totalAmount));
    
    // Update chart
    updateChart(principal, totalInterest);
    
    // Update breakdown table
    updateBreakdownTable(emi, monthlyRate, principal, tenureMonths);
}

function updateChart(principal, totalInterest) {
    const ctx = document.getElementById('emiChart');
    if (!ctx) return;
    
    // Destroy existing chart
    if (emiChart) {
        emiChart.destroy();
    }
    
    emiChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Principal Amount', 'Interest Amount'],
            datasets: [{
                data: [principal, totalInterest],
                backgroundColor: [
                    '#dc3545',
                    '#6c757d'
                ],
                borderWidth: 0,
                cutout: '60%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = '₹' + formatCurrency(Math.round(context.parsed));
                            const percentage = ((context.parsed / (principal + totalInterest)) * 100).toFixed(1);
                            return label + ': ' + value + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
}

function updateBreakdownTable(emi, monthlyRate, principal, tenureMonths) {
    const tableBody = document.getElementById('breakdownTableBody');
    if (!tableBody) return;
    
    let balance = principal;
    let totalInterestPaid = 0;
    let html = '';
    
    // Show only first 12 months and then yearly summary
    for (let i = 1; i <= Math.min(12, tenureMonths); i++) {
        const interestPayment = balance * monthlyRate;
        const principalPayment = emi - interestPayment;
        balance -= principalPayment;
        totalInterestPaid += interestPayment;
        
        html += `
            <tr>
                <td>${i}</td>
                <td>₹${formatCurrency(Math.round(emi))}</td>
                <td>₹${formatCurrency(Math.round(principalPayment))}</td>
                <td>₹${formatCurrency(Math.round(interestPayment))}</td>
                <td>₹${formatCurrency(Math.round(balance))}</td>
            </tr>
        `;
    }
    
    // If tenure is more than 12 months, show yearly summaries
    if (tenureMonths > 12) {
        for (let year = 2; year <= Math.ceil(tenureMonths / 12); year++) {
            const startMonth = (year - 1) * 12 + 1;
            const endMonth = Math.min(year * 12, tenureMonths);
            
            let yearlyPrincipal = 0;
            let yearlyInterest = 0;
            
            for (let month = startMonth; month <= endMonth; month++) {
                const interestPayment = balance * monthlyRate;
                const principalPayment = emi - interestPayment;
                balance -= principalPayment;
                yearlyPrincipal += principalPayment;
                yearlyInterest += interestPayment;
            }
            
            html += `
                <tr class="table-secondary">
                    <td>Year ${year}</td>
                    <td>₹${formatCurrency(Math.round(emi * (endMonth - startMonth + 1)))}</td>
                    <td>₹${formatCurrency(Math.round(yearlyPrincipal))}</td>
                    <td>₹${formatCurrency(Math.round(yearlyInterest))}</td>
                    <td>₹${formatCurrency(Math.round(Math.max(0, balance)))}</td>
                </tr>
            `;
        }
    }
    
    tableBody.innerHTML = html;
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('en-IN').format(amount);
}

// Predefined loan amount buttons
function setLoanAmount(amount) {
    document.getElementById('loanAmount').value = amount;
    updateDisplayValues();
    calculateEMI();
}

// Predefined tenure buttons
function setTenure(years) {
    document.getElementById('loanTenure').value = years;
    updateDisplayValues();
    calculateEMI();
}

// Download EMI schedule as PDF (placeholder function)
function downloadSchedule() {
    alert('EMI schedule download feature will be available soon!');
}

// Share EMI calculation (placeholder function)
function shareCalculation() {
    if (navigator.share) {
        const amount = document.getElementById('loanAmount').value;
        const rate = document.getElementById('interestRate').value;
        const tenure = document.getElementById('loanTenure').value;
        const emi = document.getElementById('emiAmount').textContent;
        
        navigator.share({
            title: 'EMI Calculator Result - Jay Shree Mahakal Finance',
            text: `Loan Amount: ₹${formatCurrency(amount)}\nInterest Rate: ${rate}%\nTenure: ${tenure} years\nEMI: ${emi}`,
            url: window.location.href
        });
    } else {
        // Fallback for browsers that don't support Web Share API
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Calculator link copied to clipboard!');
        }).catch(() => {
            alert('Unable to share. Please copy the URL manually.');
        });
    }
}
