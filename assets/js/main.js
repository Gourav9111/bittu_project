// Main JavaScript file for Jay Shree Mahakal Finance Services

document.addEventListener('DOMContentLoaded', function() {
    // Initialize animations
    initAnimations();
    
    // Initialize form validations
    initFormValidations();
    
    // Initialize tooltips and popovers
    initBootstrapComponents();
    
    // Initialize custom components
    initCustomComponents();
});

// Animation initialization
function initAnimations() {
    // Add fade-in animation to elements when they come into view
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in');
            }
        });
    }, observerOptions);

    // Observe all loan cards and feature items
    document.querySelectorAll('.loan-card, .feature-item, .dashboard-card').forEach(el => {
        observer.observe(el);
    });
}

// Form validation initialization
function initFormValidations() {
    // Generic form validation
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // Focus on first invalid field
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    firstInvalid.focus();
                }
            }
            
            form.classList.add('was-validated');
        });
    });

    // Phone number validation
    const phoneInputs = document.querySelectorAll('input[type="tel"], input[name="mobile"], input[name="phone"]');
    phoneInputs.forEach(input => {
        input.addEventListener('input', function() {
            const value = this.value.replace(/\D/g, '');
            if (value.length === 10) {
                this.setCustomValidity('');
            } else {
                this.setCustomValidity('Please enter a valid 10-digit mobile number');
            }
        });
    });

    // PAN validation
    const panInputs = document.querySelectorAll('input[name="pan"], input[name="pan_aadhar"]');
    panInputs.forEach(input => {
        input.addEventListener('input', function() {
            const value = this.value.toUpperCase();
            const panPattern = /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/;
            
            this.value = value;
            
            if (value === '' || panPattern.test(value)) {
                this.setCustomValidity('');
            } else {
                this.setCustomValidity('Please enter a valid PAN number (e.g., ABCDE1234F)');
            }
        });
    });
}

// Bootstrap components initialization
function initBootstrapComponents() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
}

// Custom components initialization
function initCustomComponents() {
    // Loan amount formatter
    const amountInputs = document.querySelectorAll('input[name="loan_amount"], input[name="amount"]');
    amountInputs.forEach(input => {
        input.addEventListener('input', function() {
            const value = this.value.replace(/\D/g, '');
            const formattedValue = formatCurrency(value);
            this.value = formattedValue;
        });
    });

    // Auto-complete city names
    initCityAutocomplete();
    
    // Status check functionality
    initStatusCheck();
    
    // Initialize modern interactions
    initModernInteractions();
}

// Modern interactions
function initModernInteractions() {
    // Smooth hover effects for cards
    const cards = document.querySelectorAll('.product-card-3d, .mini-product-card, .step-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Parallax effect for hero section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const heroElements = document.querySelectorAll('.hero-slide');
        heroElements.forEach(hero => {
            hero.style.transform = `translateY(${scrolled * 0.5}px)`;
        });
    });

    // Loading states for buttons
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function() {
            if (this.form && this.form.checkValidity()) {
                this.classList.add('loading');
                this.disabled = true;
                setTimeout(() => {
                    this.classList.remove('loading');
                    this.disabled = false;
                }, 2000);
            }
        });
    });
}

// Format currency
function formatCurrency(amount) {
    if (!amount) return '';
    return new Intl.NumberFormat('en-IN').format(amount);
}

// City autocomplete
function initCityAutocomplete() {
    const cityInputs = document.querySelectorAll('input[name="city"]');
    const popularCities = [
        'Mumbai', 'Delhi', 'Bangalore', 'Hyderabad', 'Chennai', 'Kolkata', 'Pune', 'Ahmedabad',
        'Jaipur', 'Lucknow', 'Kanpur', 'Nagpur', 'Indore', 'Bhopal', 'Visakhapatnam', 'Patna',
        'Vadodara', 'Ghaziabad', 'Ludhiana', 'Agra', 'Nashik', 'Faridabad', 'Meerut', 'Rajkot'
    ];

    cityInputs.forEach(input => {
        const datalist = document.createElement('datalist');
        datalist.id = 'cities-' + Math.random().toString(36).substr(2, 9);
        
        popularCities.forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            datalist.appendChild(option);
        });
        
        input.setAttribute('list', datalist.id);
        input.parentNode.appendChild(datalist);
    });
}

// Status check functionality
function initStatusCheck() {
    const statusForm = document.getElementById('statusCheckForm');
    if (statusForm) {
        statusForm.addEventListener('submit', function(e) {
            e.preventDefault();
            checkLoanStatus();
        });
    }
}

// Check loan status
function checkLoanStatus() {
    const identifier = document.getElementById('identifier').value;
    const resultDiv = document.getElementById('statusResult');
    
    if (!identifier) {
        showAlert('Please enter your mobile number or application ID', 'warning');
        return;
    }

    // Show loading
    resultDiv.innerHTML = '<div class="text-center"><div class="spinner-border text-danger" role="status"></div></div>';
    
    fetch('check-status.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'identifier=' + encodeURIComponent(identifier)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayStatusResult(data.application);
        } else {
            resultDiv.innerHTML = '<div class="alert alert-warning">' + data.message + '</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        resultDiv.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
    });
}

// Display status result
function displayStatusResult(application) {
    const resultDiv = document.getElementById('statusResult');
    const statusClass = getStatusClass(application.status);
    
    resultDiv.innerHTML = `
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Application Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Application ID:</strong> ${application.application_id}</p>
                        <p><strong>Name:</strong> ${application.name}</p>
                        <p><strong>Mobile:</strong> ${application.mobile}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Loan Type:</strong> ${application.loan_type}</p>
                        <p><strong>Amount:</strong> ₹${formatCurrency(application.loan_amount)}</p>
                        <p><strong>Status:</strong> <span class="badge ${statusClass}">${application.status}</span></p>
                    </div>
                </div>
                <p><strong>Applied On:</strong> ${new Date(application.created_at).toLocaleDateString()}</p>
            </div>
        </div>
    `;
}

// Get status CSS class
function getStatusClass(status) {
    switch (status.toLowerCase()) {
        case 'approved': return 'bg-success';
        case 'rejected': return 'bg-danger';
        case 'processing': return 'bg-info';
        default: return 'bg-warning text-dark';
    }
}

// Show alert
function showAlert(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.container');
    if (container) {
        container.insertBefore(alertDiv, container.firstChild);
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
}

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Back to top button
function initBackToTop() {
    const backToTopBtn = document.createElement('button');
    backToTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
    backToTopBtn.className = 'btn btn-danger btn-floating';
    backToTopBtn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: none;
        z-index: 1000;
    `;
    
    document.body.appendChild(backToTopBtn);
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTopBtn.style.display = 'block';
        } else {
            backToTopBtn.style.display = 'none';
        }
    });
    
    backToTopBtn.addEventListener('click', function() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// Initialize back to top button
initBackToTop();
