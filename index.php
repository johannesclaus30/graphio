<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphio - Graphic Design Marketplace</title>
    <link rel="icon" type="image/jpg" sizes="30x30" href="logos/graphio.jpg">
    <link rel="stylesheet" href="index_styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>
    <div class="min-h-screen">
        <!-- Header -->
        <header class="header">
            <div class="container">
                <div class="header-content">
                    <!-- Logo -->
                    <div class="logo">
                        <img class="graphio-logo" src="logos/graphio_logo_blue.png" />
                    </div>

                    <!-- Desktop Navigation -->
                    <nav class="nav-desktop">
                        <a href="designs" class="nav-link">Designs</a>
                        <a href="careers" class="nav-link">Careers</a>
                        <a href="artists" class="nav-link">Artists</a>
                        <a href="about.html" class="nav-link">About</a>
                    </nav>

                    <!-- Right side buttons -->
                    <div class="header-buttons">
                        <a href="login" class="btn btn-outline btn-sm">Sign In</a>
                        <button class="btn btn-sm btn-gradient designer-btn">
                             <a href="signup" class="logo-link-white">Create a <i class="text-italic-gold"> graphio  </i> account</a>
                            </button>

                        <!-- Mobile menu button -->
                        <button class="btn btn-ghost btn-sm mobile-menu">
                            <!-- <i data-lucide="menu" class="icon-sm"></i> -->
                            <a href="javascript:void(0);" class="icon-sm" data-lucide="menu" onclick="myFunction()">
                                <i class="fa fa-bars"></i>
                            </a>
                        </button>
                    </div>
                </div>
            </div>
            <div id="myLinks" class="toggle-infos">
                        <a href="designs" class="nav-link">Designs</a><br>
                        <a href="careers" class="nav-link">Careers</a><br>
                        <a href="artists" class="nav-link">Artists</a><br>
                        <a href="about.html" class="nav-link">About</a><br>
                    </div>
        </header>

        <main>
            <!-- Hero Section -->
            <section class="hero" id="up">
                <div class="container">
                    <div class="hero-grid">
                        <!-- Left content -->
                        <div class="hero-content">
                            <h1 class="hero-title">
                                Showcase Your Amazing
                                <span class="gradient-text">Designs</span>
                            </h1>
                            <p class="hero-description">
                                Connect with talented designers, earn with your works, and build your creative career with us.
                                
                            </p>
                            
                            <div class="hero-buttons">
                                <button class="btn btn-lg btn-gradient">
                                    <a href="login" class="logo-link-white">Explore <i class="text-italic-gold">graphio</i> Now
                                    <i data-lucide="arrow-right" class="icon-sm"></i></a>
                                </button>
                                <button class="btn btn-outline btn-lg group">
                                    <a href="#contact" class="logo-link">
                                    <i data-lucide="phone" class="icon-sm"></i>
                                    Contact Us
                                    </a>
                                </button>
                            </div>

                            <!-- Stats -->
                            <div class="hero-stats">
                                <div class="stat">
                                    <div class="stat-number">Earn</div>
                                    <div class="stat-label">With Your Designs</div>
                                </div>
                                <div class="stat">
                                    <div class="stat-number">Find</div>
                                    <div class="stat-label">Designers</div>
                                </div>
                                <div class="stat">
                                    <div class="stat-number">Express</div>
                                    <div class="stat-label">Your Creativity</div>
                                </div>
                            </div>
                        </div>

                        <!-- Right image -->
                        <div class="hero-image-container">
                            <div class="hero-image">
                                <img src="https://images.unsplash.com/photo-1532617392008-5399d3d8a599?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncmFwaGljJTIwZGVzaWduJTIwY3JlYXRpdmUlMjB3b3Jrc3BhY2V8ZW58MXx8fHwxNzU4MTkyNzM3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                     alt="Creative workspace with design tools" 
                                     class="hero-img">
                            </div>
                            
                            <!-- Floating cards -->
                            <div class="floating-card floating-card-1">
                                <div class="floating-icon purple-blue"></div>
                                <div class="floating-text">Logo Design</div>
                            </div>
                            
                            <div class="floating-card floating-card-2">
                                <div class="floating-icon pink-orange"></div>
                                <div class="floating-text">Brand Identity</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Featured Designs -->
            <section id="designs" class="featured-designs">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Featured Designs</h2>
                        <p class="section-description">
                            Discover trending designs from our top creative professionals
                        </p>
                    </div>

                    <div class="designs-grid">
                        <div class="design-card">
                            <a href="view_design.html" class="logo-link">
                                <div class="design-image">
                                <img src="https://images.unsplash.com/photo-1686526473156-e8449f0c6765?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxtb2Rlcm4lMjBsb2dvJTIwZGVzaWdufGVufDF8fHx8MTc1ODIyMzU5M3ww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                     alt="Modern Logo Collection" 
                                     class="design-img">
                                <div class="design-overlay"></div>
                                <div class="design-actions">
                                    <button class="btn btn-sm btn-secondary">
                                        <i data-lucide="heart" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="design-button">
                                    <button class="btn btn-sm btn-white">
                                        <i data-lucide="download" class="icon-xs"></i>
                                        View Details
                                    </button>
                                </div>
                            </div>
                            
                            <div class="design-info">
                                <div class="design-meta">
                                    <span class="design-category">Logo Design</span>
                                    <span class="design-price">$25</span>
                                </div>
                                <h3 class="design-title">Modern Logo Collection</h3>
                                <p class="design-author">by Sarah Chen</p>
                                <div class="design-stats">
                                    <div class="stat-item">
                                        <i data-lucide="heart" class="icon-xs"></i>
                                        1234
                                    </div>
                                    <div class="stat-item">
                                        <i data-lucide="eye" class="icon-xs"></i>
                                        5678
                                    </div>
                                </div>
                            </div>
                            </a>
                        </div>

                        <div class="design-card">
                            <div class="design-image">
                                <img src="https://images.unsplash.com/photo-1710799885122-428e63eff691?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxkZXNpZ25lciUyMHBvcnRmb2xpbyUyMGNyZWF0aXZlfGVufDF8fHx8MTc1ODI5MDQ0OXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                     alt="Brand Identity Package" 
                                     class="design-img">
                                <div class="design-overlay"></div>
                                <div class="design-actions">
                                    <button class="btn btn-sm btn-secondary">
                                        <i data-lucide="heart" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="design-button">
                                    <button class="btn btn-sm btn-white">
                                        <i data-lucide="download" class="icon-xs"></i>
                                        View Details
                                    </button>
                                </div>
                            </div>
                            
                            <div class="design-info">
                                <div class="design-meta">
                                    <span class="design-category">Branding</span>
                                    <span class="design-price">$89</span>
                                </div>
                                <h3 class="design-title">Brand Identity Package</h3>
                                <p class="design-author">by Alex Rodriguez</p>
                                <div class="design-stats">
                                    <div class="stat-item">
                                        <i data-lucide="heart" class="icon-xs"></i>
                                        890
                                    </div>
                                    <div class="stat-item">
                                        <i data-lucide="eye" class="icon-xs"></i>
                                        3456
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="design-card">
                            <div class="design-image">
                                <img src="https://images.unsplash.com/photo-1532617392008-5399d3d8a599?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncmFwaGljJTIwZGVzaWduJTIwY3JlYXRpdmUlMjB3b3Jrc3BhY2V8ZW58MXx8fHwxNzU4MTkyNzM3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                     alt="Creative Poster Set" 
                                     class="design-img">
                                <div class="design-overlay"></div>
                                <div class="design-actions">
                                    <button class="btn btn-sm btn-secondary">
                                        <i data-lucide="heart" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="design-button">
                                    <button class="btn btn-sm btn-white">
                                        <i data-lucide="download" class="icon-xs"></i>
                                        View Details
                                    </button>
                                </div>
                            </div>
                            
                            <div class="design-info">
                                <div class="design-meta">
                                    <span class="design-category">Print Design</span>
                                    <span class="design-price">$35</span>
                                </div>
                                <h3 class="design-title">Creative Poster Set</h3>
                                <p class="design-author">by Maya Patel</p>
                                <div class="design-stats">
                                    <div class="stat-item">
                                        <i data-lucide="heart" class="icon-xs"></i>
                                        567
                                    </div>
                                    <div class="stat-item">
                                        <i data-lucide="eye" class="icon-xs"></i>
                                        2345
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="design-card">
                            <div class="design-image">
                                <img src="https://images.unsplash.com/photo-1753162660733-45bcad593b16?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjcmVhdGl2ZSUyMGRlc2lnbmVyJTIwcG9ydHJhaXR8ZW58MXx8fHwxNzU4MTk1NjQ2fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                     alt="UI Kit Bundle" 
                                     class="design-img">
                                <div class="design-overlay"></div>
                                <div class="design-actions">
                                    <button class="btn btn-sm btn-secondary">
                                        <i data-lucide="heart" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="design-button">
                                    <button class="btn btn-sm btn-white">
                                        <i data-lucide="download" class="icon-xs"></i>
                                        View Details
                                    </button>
                                </div>
                            </div>
                            
                            <div class="design-info">
                                <div class="design-meta">
                                    <span class="design-category">UI/UX</span>
                                    <span class="design-price">$45</span>
                                </div>
                                <h3 class="design-title">UI Kit Bundle</h3>
                                <p class="design-author">by James Wilson</p>
                                <div class="design-stats">
                                    <div class="stat-item">
                                        <i data-lucide="heart" class="icon-xs"></i>
                                        756
                                    </div>
                                    <div class="stat-item">
                                        <i data-lucide="eye" class="icon-xs"></i>
                                        4567
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-footer">
                        <a href="designs" class="btn btn-lg btn-outline">View All Designs</a>
                    </div>
                </div>
            </section>

            <!-- Career Opportunities -->
            <section id="careers" class="careers">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Career Opportunities</h2>
                        <p class="section-description">
                            Discover exciting design positions from top companies looking for creative talent
                        </p>
                    </div>

                    <div class="careers-grid">
                        <div class="career-card featured">
                            <a href="view_career.html" class="logo-link">
                                <div class="career-header">
                                <div class="company-logo">TC</div>
                                <div class="career-meta">
                                    <span class="career-posted">2 days ago</span>
                                    <div class="featured-badge">
                                        <i data-lucide="star" class="icon-xs"></i>
                                        Featured
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="career-title">Senior Graphic Designer</h3>
                            <p class="career-company">TechCorp Solutions</p>
                            
                            <div class="career-details">
                                <div class="career-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    San Francisco, CA
                                </div>
                                <div class="career-salary">
                                    <i data-lucide="dollar-sign" class="icon-xs"></i>
                                    $75,000 - $95,000
                                </div>
                            </div>
                            
                            <p class="career-description">
                                Lead creative projects and mentor junior designers in a fast-paced tech environment.
                            </p>
                            
                            <div class="career-tags">
                                <span class="career-tag">Branding</span>
                                <span class="career-tag">UI/UX</span>
                                <span class="career-tag">Leadership</span>
                            </div>
                            
                            <div class="career-footer">
                                <span class="career-type full-time">Full-time</span>
                                <button class="btn btn-sm btn-outline">View Details</button>
                            </div>
                            </a>
                            
                        </div>

                        <div class="career-card">
                            <div class="career-header">
                                <div class="company-logo">CS</div>
                                <div class="career-meta">
                                    <span class="career-posted">1 week ago</span>
                                </div>
                            </div>
                            
                            <h3 class="career-title">Brand Identity Designer</h3>
                            <p class="career-company">Creative Studios Inc</p>
                            
                            <div class="career-details">
                                <div class="career-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    Remote
                                </div>
                                <div class="career-salary">
                                    <i data-lucide="dollar-sign" class="icon-xs"></i>
                                    $60 - $80/hour
                                </div>
                            </div>
                            
                            <p class="career-description">
                                Develop comprehensive brand identities for diverse clients across various industries.
                            </p>
                            
                            <div class="career-tags">
                                <span class="career-tag">Logo Design</span>
                                <span class="career-tag">Brand Strategy</span>
                            </div>
                            
                            <div class="career-footer">
                                <span class="career-type contract">Contract</span>
                                <button class="btn btn-sm btn-outline">View Details</button>
                            </div>
                        </div>

                        <div class="career-card">
                            <div class="career-header">
                                <div class="company-logo">SX</div>
                                <div class="career-meta">
                                    <span class="career-posted">3 days ago</span>
                                </div>
                            </div>
                            
                            <h3 class="career-title">UI/UX Designer</h3>
                            <p class="career-company">StartupXYZ</p>
                            
                            <div class="career-details">
                                <div class="career-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    New York, NY
                                </div>
                                <div class="career-salary">
                                    <i data-lucide="dollar-sign" class="icon-xs"></i>
                                    $70,000 - $90,000
                                </div>
                            </div>
                            
                            <p class="career-description">
                                Design intuitive user interfaces and enhance user experiences for mobile and web applications.
                            </p>
                            
                            <div class="career-tags">
                                <span class="career-tag">Figma</span>
                                <span class="career-tag">Prototyping</span>
                            </div>
                            
                            <div class="career-footer">
                                <span class="career-type full-time">Full-time</span>
                                <button class="btn btn-sm btn-outline">View Details</button>
                            </div>
                        </div>

                        <div class="career-card">
                            <div class="career-header">
                                <div class="company-logo">GC</div>
                                <div class="career-meta">
                                    <span class="career-posted">5 days ago</span>
                                </div>
                            </div>
                            
                            <h3 class="career-title">Marketing Designer</h3>
                            <p class="career-company">GrowthCo</p>
                            
                            <div class="career-details">
                                <div class="career-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    Austin, TX
                                </div>
                                <div class="career-salary">
                                    <i data-lucide="dollar-sign" class="icon-xs"></i>
                                    $45,000 - $55,000
                                </div>
                            </div>
                            
                            <p class="career-description">
                                Create compelling marketing materials and social media graphics to drive brand awareness.
                            </p>
                            
                            <div class="career-tags">
                                <span class="career-tag">Social Media</span>
                                <span class="career-tag">Print Design</span>
                            </div>
                            
                            <div class="career-footer">
                                <span class="career-type part-time">Part-time</span>
                                <button class="btn btn-sm btn-outline">View Details</button>
                            </div>
                        </div>

                        <div class="career-card featured">
                            <div class="career-header">
                                <div class="company-logo">DA</div>
                                <div class="career-meta">
                                    <span class="career-posted">1 day ago</span>
                                    <div class="featured-badge">
                                        <i data-lucide="star" class="icon-xs"></i>
                                        Featured
                                    </div>
                                </div>
                            </div>
                            
                            <h3 class="career-title">Creative Director</h3>
                            <p class="career-company">Design Agency Pro</p>
                            
                            <div class="career-details">
                                <div class="career-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    Los Angeles, CA
                                </div>
                                <div class="career-salary">
                                    <i data-lucide="dollar-sign" class="icon-xs"></i>
                                    $100,000 - $130,000
                                </div>
                            </div>
                            
                            <p class="career-description">
                                Lead creative teams and oversee multiple client projects from concept to completion.
                            </p>
                            
                            <div class="career-tags">
                                <span class="career-tag">Leadership</span>
                                <span class="career-tag">Strategy</span>
                            </div>
                            
                            <div class="career-footer">
                                <span class="career-type full-time">Full-time</span>
                                <button class="btn btn-sm btn-outline">View Details</button>
                            </div>
                        </div>

                        <div class="career-card">
                            <div class="career-header">
                                <div class="company-logo">MC</div>
                                <div class="career-meta">
                                    <span class="career-posted">4 days ago</span>
                                </div>
                            </div>
                            
                            <h3 class="career-title">Freelance Illustrator</h3>
                            <p class="career-company">Multiple Clients</p>
                            
                            <div class="career-details">
                                <div class="career-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    Remote
                                </div>
                                <div class="career-salary">
                                    <i data-lucide="dollar-sign" class="icon-xs"></i>
                                    $40 - $75/hour
                                </div>
                            </div>
                            
                            <p class="career-description">
                                Create custom illustrations for books, websites, and marketing campaigns.
                            </p>
                            
                            <div class="career-tags">
                                <span class="career-tag">Digital Art</span>
                                <span class="career-tag">Illustration</span>
                            </div>
                            
                            <div class="career-footer">
                                <span class="career-type freelance">Freelance</span>
                                <button class="btn btn-sm btn-outline">View Details</button>
                            </div>
                        </div>
                    </div>

                    <div class="section-footer">
                        <a href="careers" class="btn btn-lg btn-gradient">
                            View All Career Opportunities
                            <i data-lucide="arrow-right" class="icon-sm"></i>
                        </a>
                    </div>
                </div>
            </section>

            <!-- Featured Artists -->
            <section id="artists" class="featured-artists">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Top Designers and Artists</h2>
                        <p class="section-description">
                            Work with talented professionals who bring your creative vision to life
                        </p>
                    </div>

                    <div class="artists-grid">
                        <div class="artist-card">
                            <a href="view_artist.html" class="logo-link">
                                <div class="featured-badge">
                                <i data-lucide="award" class="icon-xs"></i>
                                Featured
                            </div>
                            
                            <div class="artist-content">
                                <div class="artist-avatar">
                                    <img src="https://images.unsplash.com/photo-1753162660733-45bcad593b16?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxjcmVhdGl2ZSUyMGRlc2lnbmVyJTIwcG9ydHJhaXR8ZW58MXx8fHwxNzU4MTk1NjQ2fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                         alt="Sarah Chen" 
                                         class="avatar-img">
                                    <div class="online-indicator"></div>
                                </div>
                                
                                <h3 class="artist-name">Sarah Chen</h3>
                                
                                <p class="artist-specialty">Brand Identity & Logo Design</p>
                                
                                <div class="artist-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    San Francisco, CA
                                </div>
                                
                                <div class="artist-rating">
                                    <i data-lucide="star" class="star-icon"></i>
                                    <span class="rating-score">4.9</span>
                                    <span class="rating-reviews">(127)</span>
                                </div>
                                
                                <div class="artist-projects">340 projects completed</div>
                                
                                <button class="btn btn-sm btn-outline artist-btn">View Profile</button>
                            </div>
                            </a>
                            
                        </div>

                        <div class="artist-card">
                            <div class="artist-content">
                                <div class="artist-avatar">
                                    <img src="https://images.unsplash.com/photo-1710799885122-428e63eff691?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxkZXNpZ25lciUyMHBvcnRmb2xpbyUyMGNyZWF0aXZlfGVufDF8fHx8MTc1ODI5MDQ0OXww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                         alt="Alex Rodriguez" 
                                         class="avatar-img">
                                    <div class="online-indicator"></div>
                                </div>
                                
                                <h3 class="artist-name">Alex Rodriguez</h3>
                                
                                <p class="artist-specialty">Web & UI/UX Design</p>
                                
                                <div class="artist-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    New York, NY
                                </div>
                                
                                <div class="artist-rating">
                                    <i data-lucide="star" class="star-icon"></i>
                                    <span class="rating-score">4.8</span>
                                    <span class="rating-reviews">(89)</span>
                                </div>
                                
                                <div class="artist-projects">256 projects completed</div>
                                
                                <button class="btn btn-sm btn-outline artist-btn">View Profile</button>
                            </div>
                        </div>

                        <div class="artist-card">
                            <div class="featured-badge">
                                <i data-lucide="award" class="icon-xs"></i>
                                Featured
                            </div>
                            
                            <div class="artist-content">
                                <div class="artist-avatar">
                                    <img src="https://images.unsplash.com/photo-1532617392008-5399d3d8a599?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxncmFwaGljJTIwZGVzaWduJTIwY3JlYXRpdmUlMjB3b3Jrc3BhY2V8ZW58MXx8fHwxNzU4MTkyNzM3fDA&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                         alt="Maya Patel" 
                                         class="avatar-img">
                                    <div class="online-indicator"></div>
                                </div>
                                
                                <h3 class="artist-name">Maya Patel</h3>
                                
                                <p class="artist-specialty">Print & Marketing Design</p>
                                
                                <div class="artist-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    Austin, TX
                                </div>
                                
                                <div class="artist-rating">
                                    <i data-lucide="star" class="star-icon"></i>
                                    <span class="rating-score">4.9</span>
                                    <span class="rating-reviews">(156)</span>
                                </div>
                                
                                <div class="artist-projects">423 projects completed</div>
                                
                                <button class="btn btn-sm btn-outline artist-btn">View Profile</button>
                            </div>
                        </div>

                        <div class="artist-card">
                            <div class="artist-content">
                                <div class="artist-avatar">
                                    <img src="https://images.unsplash.com/photo-1686526473156-e8449f0c6765?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxtb2Rlcm4lMjBsb2dvJTIwZGVzaWdufGVufDF8fHx8MTc1ODIyMzU5M3ww&ixlib=rb-4.1.0&q=80&w=1080&utm_source=figma&utm_medium=referral" 
                                         alt="James Wilson" 
                                         class="avatar-img">
                                    <div class="online-indicator"></div>
                                </div>
                                
                                <h3 class="artist-name">James Wilson</h3>
                                
                                <p class="artist-specialty">Illustration & Character Design</p>
                                
                                <div class="artist-location">
                                    <i data-lucide="map-pin" class="icon-xs"></i>
                                    Seattle, WA
                                </div>
                                
                                <div class="artist-rating">
                                    <i data-lucide="star" class="star-icon"></i>
                                    <span class="rating-score">4.7</span>
                                    <span class="rating-reviews">(73)</span>
                                </div>
                                
                                <div class="artist-projects">189 projects completed</div>
                                
                                <button class="btn btn-sm btn-outline artist-btn">View Profile</button>
                            </div>
                        </div>
                    </div>

                    <div class="section-footer">
                        <button class="btn btn-lg btn-outline"><a href="artists" class="logo-link">Browse All Artists</a></button>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="cta">
                <div class="container">
                    <div class="cta-header">
                        <h2 class="cta-title">Ready to Start Your Creative Journey?</h2>
                        <p class="cta-description">
                            Join thousands of designers earning money doing what they love, or find the perfect design for your project.
                        </p>
                    </div>

                    <div class="cta-grid">
                        <!-- For Clients -->
                        <div class="cta-card">
                            <div class="cta-icon">
                                <i data-lucide="users" class="icon-lg"></i>
                            </div>
                            
                            <h3 class="cta-card-title">For Businesses and Companies</h3>
                            
                            <p class="cta-card-description">
                                Need a Graphic Designer or Artist? Look for professional and qualified Graphio Designers for your company or business.

                            </p>
                            
                            <ul class="cta-features">
                                <li class="cta-feature">
                                    <i data-lucide="zap" class="feature-icon"></i>
                                    Discover Graphio Professionals
                                </li>
                                <li class="cta-feature">
                                    <i data-lucide="trophy" class="feature-icon"></i>
                                    High-quality standards
                                </li>
                                <li class="cta-feature">
                                    <i data-lucide="users" class="feature-icon"></i>
                                    Reach the Target Audience
                                </li>
                            </ul>
                            
                            <button class="btn btn-lg btn-white">
                                
                                <a href="login_business.html" class="logo-link">Apply Graphio for Business</a>
                                <i data-lucide="arrow-right" class="icon-sm"></i>
                            </button>
                        </div>

                        <!-- For Designers -->
                        <div class="cta-card">
                            <div class="cta-icon">
                                <i data-lucide="zap" class="icon-lg"></i>
                            </div>
                            
                            <h3 class="cta-card-title">For Designers</h3>
                            
                            <p class="cta-card-description">
                                Showcase your work, connect with clients worldwide, and build a thriving design business on our platform.
                            </p>
                            
                            <ul class="cta-features">
                                <li class="cta-feature">
                                    <i data-lucide="zap" class="feature-icon"></i>
                                    Flexible working hours
                                </li>
                                <li class="cta-feature">
                                    <i data-lucide="trophy" class="feature-icon"></i>
                                    Competitive earnings
                                </li>
                                <li class="cta-feature">
                                    <i data-lucide="users" class="feature-icon"></i>
                                    Global client base
                                </li>
                            </ul>
                            
                            <button class="btn btn-lg btn-yellow">
                                <a href="signup" class="logo-link">Be a Graphio Designer</a>
                                <i data-lucide="arrow-right" class="icon-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="cta-stats">
                        <div class="cta-stat">
                            <div class="cta-stat-number">50K+</div>
                            <div class="cta-stat-label">Active Designs</div>
                        </div>
                        <div class="cta-stat">
                            <div class="cta-stat-number">10K+</div>
                            <div class="cta-stat-label">Happy Clients</div>
                        </div>
                        <div class="cta-stat">
                            <div class="cta-stat-number">5K+</div>
                            <div class="cta-stat-label">Designers</div>
                        </div>
                        <div class="cta-stat">
                            <div class="cta-stat-number">98%</div>
                            <div class="cta-stat-label">Satisfaction Rate</div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <!-- Company Info -->
                    <div class="footer-section">
                        <div class="footer-logo"><a href="#up" class="logo-link-white">
                            <img class="graphio-logo-footer" src="logos/graphio_logo_white.png"/></a></div>
                        <p class="footer-description">
                            The premier marketplace connecting businesses with talented graphic designers worldwide. 
                            Quality designs, competitive prices, exceptional service.
                        </p>
                        <div class="footer-social">
                            <a href="#" class="social-link">
                                <i data-lucide="facebook" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="twitter" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="instagram" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="linkedin" class="icon-sm"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-section">
                        <h3 class="footer-title">Quick Links</h3>
                        <ul class="footer-links">
                            <li><a href="#designs" class="footer-link">Browse Designs</a></li>
                            <li><a href="#services" class="footer-link">Services</a></li>
                            <li><a href="#artists" class="footer-link">Find Designers</a></li>
                            <li><a href="#" class="footer-link">Pricing</a></li>
                            <li><a href="about.html" class="footer-link">About Us</a></li>
                        </ul>
                    </div>

                    <!-- For Designers -->
                    <div class="footer-section">
                        <h3 class="footer-title">For Designers</h3>
                        <ul class="footer-links">
                            <li><a href="signup" class="footer-link">Join as Designer</a></li>
                            <li><a href="#" class="footer-link">Designer Resources</a></li>
                            <li><a href="#" class="footer-link">Success Stories</a></li>
                            <li><a href="#" class="footer-link">Design Tips</a></li>
                            <li><a href="#" class="footer-link">Community</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div class="footer-section" id="contact">
                        <h3 class="footer-title">Contact Us</h3>
                        <ul class="footer-contact">
                            <li class="contact-item">
                                <i data-lucide="mail" class="contact-icon"></i>
                                graphiostudio25@gmail.com
                            </li>
                            <li class="contact-item">
                                <i data-lucide="phone" class="contact-icon"></i>
                                +63 927 072 3224
                            </li>
                            <li class="contact-item">
                                <i data-lucide="map-pin" class="contact-icon"></i>
                                SM City Lipa,<br>
                                Lipa City, Batangas, Philippines
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="footer-bottom">
                    <div class="footer-copyright">
                        © 2025 Graphio Studio. All rights reserved.
                    </div>
                    <div class="footer-legal">
                        <a href="#" class="legal-link">Privacy Policy</a>
                        <a href="#" class="legal-link">Terms of Service</a>
                        <a href="#" class="legal-link">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        /* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
        function myFunction() {
        var x = document.getElementById("myLinks");
        if (x.style.display === "block") {
            x.style.display = "none";
        } else {
            x.style.display = "block";
        }
        }

    </script>
</body>
</html>