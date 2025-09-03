<?php

// This section simulates a database connection and data fetching.
// In a real-world application, this would be in a 'config.php' file.
// For this single-file solution, we define the data directly.

$page_title = "Home";
$page_description = "Jay Shree Mahakal Finance Services - Your trusted finance partner for Personal Loans, Home Loans, Education Loans, Car Loans and more in Bhopal, Madhya Pradesh";

$featured_loans = [
    [
        'name' => 'Personal Loan',
        'icon' => 'fas fa-user',
        'description' => 'Quick personal loans for immediate needs',
        'min_amount' => 10000,
        'max_amount' => 1000000,
        'image' => 'https://images.unsplash.com/photo-1633158829585-23ba8f7c8caf?w=400&h=250&fit=crop'
    ],
    [
        'name' => 'Home Loan',
        'icon' => 'fas fa-home',
        'description' => 'Affordable home loans with competitive rates',
        'min_amount' => 500000,
        'max_amount' => 50000000,
        'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=400&h=250&fit=crop'
    ],
    [
        'name' => 'Business Loan',
        'icon' => 'fas fa-briefcase',
        'description' => 'Expand your business with flexible loan options',
        'min_amount' => 100000,
        'max_amount' => 10000000,
        'image' => 'https://cubitfinance.com/assets/public/upload/Business_Loan.jpg?w=400&h=250&fit=crop'
    ],
    [
        'name' => 'Car Loan',
        'icon' => 'fas fa-car',
        'description' => 'Drive your dream car today',
        'min_amount' => 100000,
        'max_amount' => 2000000,
        'image' => 'https://images.pexels.com/photos/29566880/pexels-photo-29566880.jpeg?w=400&h=250&fit=crop'
    ]
];


// Other loan types
$other_loans = [
    ['name' => 'Education Loan', 'icon' => 'fas fa-graduation-cap', 'description' => 'Fund your education dreams', 'min_amount' => 50000, 'max_amount' => 2000000, 'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=300&h=200&fit=crop'],
    ['name' => 'Plot Purchase', 'icon' => 'fas fa-map-marked-alt', 'image' => 'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=300&h=200&fit=crop'],
    ['name' => 'Construction Loan', 'icon' => 'fas fa-hammer', 'image' => 'https://images.unsplash.com/photo-1541888946425-d81bb19240f5?w=300&h=200&fit=crop'],
    ['name' => 'Renovation Loan', 'icon' => 'fas fa-tools', 'image' => 'https://images.unsplash.com/photo-1582268611958-ebfd161ef9cf?w=300&h=200&fit=crop'],
    ['name' => 'Balance Transfer', 'icon' => 'fas fa-exchange-alt', 'image' => 'https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=300&h=200&fit=crop'],
    ['name' => 'LAP (Loan Against Property)', 'icon' => 'fas fa-building', 'image' => 'https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=300&h=200&fit=crop']
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <meta name="description" content="<?php echo $page_description; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
/* Centering text on hero carousel images */
.hero-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 10;
    padding: 20px;
}
.hero-slide {
    height: 600px; /* Adjust as needed */
    background-size: cover;
    background-position: center;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}
.carousel-item {
    transition: transform 0.6s ease-in-out, opacity 0.6s ease-in-out;
}
.carousel-item.active {
    opacity: 1;
}

/* Fix for product card image and icon overlap */
.product-image, .product-mini-image {
    position: relative;
    overflow: hidden;
}

.product-overlay, .mini-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(220, 53, 69, 0.6); /* Semi-transparent overlay */
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease-in-out;
}

.product-card:hover .product-overlay,
.other-product-card:hover .mini-overlay {
    opacity: 1;
}

.product-icon {
    /* No need for special positioning, flexbox handles it */
}

/* Correcting the layout for "Other Products" */
.other-product-card {
    display: flex;
    align-items: center;
    border: 1px solid #dee2e6;
    border-radius: 0.5rem;
    padding: 1rem;
    transition: box-shadow 0.3s ease-in-out;
}
.other-product-card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.product-mini-image {
    flex-shrink: 0;
    width: 80px;
    height: 80px;
    border-radius: 0.5rem;
    margin-right: 1rem;
    overflow: hidden;
}
.product-mini-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-info {
    flex-grow: 1;
}
    </style>
</head>
<body>

<!-- Navigation Bar (Mockup) -->
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img src="https://placehold.co/40x40/fff/ccc?text=Logo" alt="Logo" class="rounded-circle me-2">
            Jay Shree Mahakal Finance
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="check-status.php">check-status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="services.php">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact-us.php">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Hero Carousel Section -->
<section class="hero-carousel-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="hero-slide" style="background-image: linear-gradient(rgba(220, 53, 69, 0.8), rgba(114, 28, 36, 0.8)), url('https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1200&h=600&fit=crop');">
                    <div class="container">
                        <div class="hero-content text-center text-white">
                            <h1 class="hero-title display-4 fw-bold mb-4">Make Your Dream Home a Reality</h1>
                            <p class="hero-subtitle fs-5 mb-4">Get instant home loan approval with competitive interest rates starting from 7% per annum</p>
                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                <a href="apply-loan.php?type=Home Loan" class="btn btn-light btn-lg px-4 py-3">
                                    <i class="fas fa-home me-2"></i>Apply for Home Loan
                                </a>
                                <a href="emi/calculator.php" class="btn btn-outline-light btn-lg px-4 py-3">
                                    <i class="fas fa-calculator me-2"></i>Calculate EMI
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-slide" style="background-image: linear-gradient(rgba(40, 167, 69, 0.8), rgba(30, 126, 52, 0.8)), url('https://images.unsplash.com/photo-1633158829585-23ba8f7c8caf?w=1200&h=600&fit=crop');">
                    <div class="container">
                        <div class="hero-content text-center text-white">
                            <h1 class="hero-title display-4 fw-bold mb-4">Personal Loans Made Simple</h1>
                            <p class="hero-subtitle fs-5 mb-4">Quick approval for immediate needs with minimal documentation</p>
                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                <a href="apply-loan.php?type=Personal Loan" class="btn btn-light btn-lg px-4 py-3">
                                    <i class="fas fa-user me-2"></i>Apply for Personal Loan
                                </a>
                                <a href="check-status.php" class="btn btn-outline-light btn-lg px-4 py-3">
                                    <i class="fas fa-search me-2"></i>Check Status
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="hero-slide" style="background-image: linear-gradient(rgba(0, 123, 255, 0.8), rgba(0, 86, 179, 0.8)), url('https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=1200&h=600&fit=crop');">
                    <div class="container">
                        <div class="hero-content text-center text-white">
                            <h1 class="hero-title display-4 fw-bold mb-4">Grow Your Business with Us</h1>
                            <p class="hero-subtitle fs-5 mb-4">Business loans up to ₹50 lakhs with flexible repayment options</p>
                            <div class="d-flex flex-wrap gap-3 justify-content-center">
                                <a href="apply-loan.php?type=Business Loan" class="btn btn-light btn-lg px-4 py-3">
                                    <i class="fas fa-briefcase me-2"></i>Apply for Business Loan
                                </a>
                                <a href="contact-us.php" class="btn btn-outline-light btn-lg px-4 py-3">
                                    <i class="fas fa-phone me-2"></i>Contact Expert
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<!-- Trust Indicators -->
<section class="trust-section py-4 bg-light">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="trust-item">
                    <img src="https://images.unsplash.com/photo-1553729459-efe14ef6055d?w=80&h=80&fit=crop&crop=center" alt="RBI Approved" class="trust-icon rounded-circle mb-2">
                    <h6 class="mb-1">RBI Approved</h6>
                    <small class="text-muted">Licensed NBFC</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="trust-item">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=80&h=80&fit=crop&crop=center" alt="Quick Processing" class="trust-icon rounded-circle mb-2">
                    <h6 class="mb-1">24 Hour Processing</h6>
                    <small class="text-muted">Fast Approval</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="trust-item">
                    <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=80&h=80&fit=crop&crop=center" alt="Best Rates" class="trust-icon rounded-circle mb-2">
                    <h6 class="mb-1">Best Interest Rates</h6>
                    <small class="text-muted">Starting 7% p.a.</small>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="trust-item">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=80&h=80&fit=crop&crop=center" alt="Digital Process" class="trust-icon rounded-circle mb-2">
                    <h6 class="mb-1">100% Digital</h6>
                    <small class="text-muted">Paperless Process</small>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="stats-section py-5 bg-danger text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-rupee-sign fa-3x"></i>
                    </div>
                    <div class="stat-number display-4 fw-bold">₹26624 Cr+</div>
                    <div class="stat-label h6">Loans Disbursed</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                    <div class="stat-number display-4 fw-bold">30000+</div>
                    <div class="stat-label h6">Happy Customers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-user-tie fa-3x"></i>
                    </div>
                    <div class="stat-number display-4 fw-bold">8000</div>
                    <div class="stat-label h6">Expert Team</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-item">
                    <div class="stat-icon mb-3">
                        <i class="fas fa-map-marker-alt fa-3x"></i>
                    </div>
                    <div class="stat-number display-4 fw-bold">600+</div>
                    <div class="stat-label h6">Branches Across India</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Our Products Section -->
<section class="products-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-danger mb-3">Our Products</h2>
            <p class="lead text-muted">Choose from our comprehensive range of financial products designed to meet your every need</p>
        </div>
        
        <div class="row mb-5">
            <?php foreach($featured_loans as $loan): ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="product-card h-100">
                    <div class="product-image">
                        <img src="<?php echo $loan['image']; ?>" alt="<?php echo $loan['name']; ?>" class="card-img-top">
                        <div class="product-overlay">
                            <div class="product-icon">
                                <i class="<?php echo $loan['icon']; ?> fa-2x text-white"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold"><?php echo $loan['name']; ?></h5>
                        <p class="card-text text-muted"><?php echo $loan['description']; ?></p>
                        <div class="loan-amount mb-3">
                            <small class="text-muted">
                                ₹<?php echo number_format($loan['min_amount']); ?> - ₹<?php echo number_format($loan['max_amount']); ?>
                            </small>
                        </div>
                        <div class="d-grid gap-2">
                            <a href="apply-loan.php?type=<?php echo urlencode($loan['name']); ?>" class="btn btn-danger">Apply For Loan</a>
                            <a href="#" class="btn btn-outline-danger btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Other Products Grid -->
        <div class="text-center mb-4">
            <h4 class="fw-bold text-danger">Other Loan Products</h4>
        </div>
        <div class="row">
            <?php foreach($other_loans as $loan): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="other-product-card">
                    <div class="product-mini-image">
                        <img src="<?php echo $loan['image']; ?>" alt="<?php echo $loan['name']; ?>">
                        <div class="mini-overlay">
                            <i class="<?php echo $loan['icon']; ?> fa-2x text-white"></i>
                        </div>
                    </div>
                    <div class="product-info">
                        <h6 class="fw-bold mb-2"><?php echo $loan['name']; ?></h6>
                        <p class="text-muted small mb-3">Quick approval with competitive rates</p>
                        <a href="apply-loan.php?type=<?php echo urlencode($loan['name']); ?>" class="btn btn-outline-danger btn-sm">Apply Now</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Your Home Loan in 4 Easy Steps -->
<section class="steps-section py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-danger mb-3">Your Home Loan in 4 Easy Steps</h2>
            <p class="lead text-muted">Simple and transparent loan process designed for your convenience</p>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="step-card text-center">
                    <div class="step-image mb-3">
                        <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?w=150&h=150&fit=crop&crop=center" alt="Assessment" class="step-img">
                        <div class="step-number">1</div>
                    </div>
                    <h5 class="fw-bold text-danger">Assessment</h5>
                    <p class="text-muted">Complete your loan application online in just a few minutes with our simple form.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="step-card text-center">
                    <div class="step-image mb-3">
                        <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=150&h=150&fit=crop&crop=center" alt="Conditional Loan Sanction" class="step-img">
                        <div class="step-number">2</div>
                    </div>
                    <h5 class="fw-bold text-danger">Conditional Loan Sanction</h5>
                    <p class="text-muted">Upload your documents for quick digital verification and get conditional approval.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="step-card text-center">
                    <div class="step-image mb-3">
                        <img src="https://images.unsplash.com/photo-1554224154-26032fbc4d72?w=150&h=150&fit=crop&crop=center" alt="Security Assessment" class="step-img">
                        <div class="step-number">3</div>
                    </div>
                    <h5 class="fw-bold text-danger">Security Assessment</h5>
                    <p class="text-muted">Property valuation and legal verification completed by our expert team.</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="step-card text-center">
                    <div class="step-image mb-3">
                        <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=150&h=150&fit=crop&crop=center" alt="Loan Disbursement" class="step-img">
                        <div class="step-number">4</div>
                    </div>
                    <h5 class="fw-bold text-danger">Loan Disbursement</h5>
                    <p class="text-muted">Receive funds directly in your bank account within 24-48 hours of approval.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Key Benefits Section -->
<section class="benefits-section py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-danger mb-3">Key Benefits of Your Loan</h2>
            <p class="lead text-muted">Why choose Jay Shree Mahakal Finance Services for your financial needs</p>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card text-center">
                    <div class="benefit-image mb-3">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=120&h=120&fit=crop&crop=center" alt="Home loans without guarantee" class="benefit-img">
                    </div>
                    <h5 class="fw-bold text-danger">Home loans available without guarantee</h5>
                    <p class="text-muted">Get your loan approved without requiring a guarantor, making the process simpler and faster.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card text-center">
                    <div class="benefit-image mb-3">
                        <img src="https://images.unsplash.com/photo-1434626881859-194d67b2b86f?w=120&h=120&fit=crop&crop=center" alt="Loan tenure up to" class="benefit-img">
                    </div>
                    <h5 class="fw-bold text-danger">Loan tenure: up to 30 years</h5>
                    <p class="text-muted">Flexible repayment tenure up to 30 years to reduce your EMI burden and improve affordability.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="benefit-card text-center">
                    <div class="benefit-image mb-3">
                        <img src="https://images.unsplash.com/photo-1579621970563-ebec7560ff3e?w=120&h=120&fit=crop&crop=center" alt="Eligibility starts from" class="benefit-img">
                    </div>
                    <h5 class="fw-bold text-danger">Eligibility starts from ₹15,000</h5>
                    <p class="text-muted">Low minimum income requirement makes our loans accessible to a wide range of customers.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- EMI Calculator Section -->
<section class="calculator-preview py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-5 fw-bold text-danger mb-3">Calculate Your EMI</h2>
                <p class="lead text-muted mb-4">Use our advanced EMI calculator to plan your loan repayment and make informed financial decisions.</p>
                <div class="feature-list">
                    <div class="feature-item d-flex align-items-center mb-3">
                        <div class="feature-icon me-3">
                            <i class="fas fa-calculator text-danger"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Instant Calculation</h6>
                            <small class="text-muted">Get your EMI amount instantly</small>
                        </div>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-3">
                        <div class="feature-icon me-3">
                            <i class="fas fa-chart-pie text-danger"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Visual Breakdown</h6>
                            <small class="text-muted">See principal vs interest breakdown</small>
                        </div>
                    </div>
                    <div class="feature-item d-flex align-items-center mb-4">
                        <div class="feature-icon me-3">
                            <i class="fas fa-mobile-alt text-danger"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Mobile Friendly</h6>
                            <small class="text-muted">Calculate on any device</small>
                        </div>
                    </div>
                </div>
                <a href="emi/calculator.php" class="btn btn-danger btn-lg">
                    <i class="fas fa-calculator me-2"></i>Try EMI Calculator
                </a>
            </div>
            <div class="col-lg-6">
                <div class="calculator-mockup text-center">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=500&h=400&fit=crop" alt="EMI Calculator" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section py-5 bg-danger text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="display-6 fw-bold mb-3">Ready to Get Started?</h3>
                <p class="fs-5 mb-0">Apply for your loan today and get instant approval with competitive interest rates. Our expert team is here to guide you through every step.</p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="apply-loan.php" class="btn btn-light btn-lg me-md-2 px-4 py-3">
                        <i class="fas fa-file-alt me-2"></i>Apply Now
                    </a>
                    <a href="contact-us.php" class="btn btn-outline-light btn-lg px-4 py-3">
                        <i class="fas fa-phone me-2"></i>Call Expert
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer (Mockup) -->
<footer class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Jay Shree Mahakal Finance</h5>
                <p class="text-muted">Your trusted finance partner for all your lending needs in Bhopal, Madhya Pradesh.</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Sitemap</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold">Contact Us</h5>
                <ul class="list-unstyled text-muted">
                    <li><i class="fas fa-map-marker-alt me-2"></i>Bhopal, Madhya Pradesh</li>
                    <li><i class="fas fa-phone me-2"></i>+91 98765 43210</li>
                    <li><i class="fas fa-envelope me-2"></i>info@mahakalfinance.com</li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p class="mb-0 text-muted">&copy; 2024 Jay Shree Mahakal Finance. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
