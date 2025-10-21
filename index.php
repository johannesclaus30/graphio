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
                        <!-- <a href="careers" class="nav-link">Careers</a>
                        <a href="artists" class="nav-link">Artists</a> -->
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

                    <?php
                    // Fetch latest uploaded designs (public, non-archived)
                    include_once __DIR__ . "/connections.php";

                    // Helper: normalize DB photo path for root page
                    function normalizeForRoot($path, $default) {
                        $p = trim((string)$path);
                        if ($p === "") return $default;
                        if (preg_match('#^https?://#i', $p)) return $p;  // absolute
                        if ($p[0] === '/') return $p;                    // site-root
                        // Strip leading ../ segments so it works from web root (index.php)
                        while (strpos($p, '../') === 0) $p = substr($p, 3);
                        if (strpos($p, './') === 0) $p = substr($p, 2);
                        return ltrim($p, '/');
                    }

                    $defaultDesignPhoto = 'media/default_design_photo.jpg';

                    $sql = "
                        SELECT 
                            d.Design_ID,
                            d.Design_Name,
                            d.Design_Category,
                            d.Design_Price,
                            d.Design_Photo,
                            d.Design_Created_At,
                            u.User_FirstName,
                            u.User_LastName
                        FROM design d
                        INNER JOIN user u ON u.User_ID = d.User_ID
                        WHERE (d.Design_Status IS NULL OR d.Design_Status <> 2)
                        ORDER BY d.Design_Created_At DESC
                        LIMIT 4
                    ";
                    $res = mysqli_query($connections, $sql);
                    $featuredDesigns = [];
                    if ($res) {
                        while ($row = mysqli_fetch_assoc($res)) {
                            $row['Design_Photo'] = normalizeForRoot($row['Design_Photo'] ?: $defaultDesignPhoto, $defaultDesignPhoto);
                            $row['Design_Name'] = $row['Design_Name'] ?? 'Untitled';
                            $row['Design_Category'] = $row['Design_Category'] ?? 'Uncategorized';
                            $row['User_FirstName'] = $row['User_FirstName'] ?? '';
                            $row['User_LastName'] = $row['User_LastName'] ?? '';
                            $featuredDesigns[] = $row;
                        }
                    }
                    ?>

                    <div class="designs-grid">
                        <?php if (!empty($featuredDesigns)): ?>
                            <?php foreach ($featuredDesigns as $d): 
                                $id = (int)$d['Design_ID'];
                                $name = htmlspecialchars($d['Design_Name']);
                                $cat  = htmlspecialchars($d['Design_Category']);
                                $price = number_format((float)($d['Design_Price'] ?? 0), 2);
                                $photo = htmlspecialchars($d['Design_Photo']);
                                $owner = htmlspecialchars(trim(($d['User_FirstName'] ?? '') . ' ' . ($d['User_LastName'] ?? '')));
                            ?>
                            <div class="design-card">
                                <a href="view/view_design.php?id=<?php echo $id; ?>" class="logo-link">
                                    <div class="design-image">
                                        <img src="<?php echo $photo; ?>" alt="<?php echo $name; ?>" class="design-img">
                                        <div class="design-overlay"></div>
                                        <div class="design-actions">
                                            <button class="btn btn-sm btn-secondary" type="button" aria-label="Like">
                                                <i data-lucide="heart" class="icon-xs"></i>
                                            </button>
                                        </div>
                                        <div class="design-button">
                                            <button class="btn btn-sm btn-white" type="button">
                                                <i data-lucide="download" class="icon-xs"></i>
                                                View Details
                                            </button>
                                        </div>
                                    </div>
                                    
                                    <div class="design-info">
                                        <div class="design-meta">
                                            <span class="design-category"><?php echo $cat; ?></span>
                                            <span class="design-price">$<?php echo $price; ?></span>
                                        </div>
                                        <h3 class="design-title"><?php echo $name; ?></h3>
                                        <p class="design-author">by <?php echo $owner ?: 'Designer'; ?></p>
                                        <div class="design-stats">
                                            <div class="stat-item">
                                                <i data-lucide="heart" class="icon-xs"></i>
                                                <!-- Optional: likes count -->
                                                0
                                            </div>
                                            <div class="stat-item">
                                                <i data-lucide="eye" class="icon-xs"></i>
                                                View
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p style="color:#6b7280;">No designs available yet.</p>
                        <?php endif; ?>
                    </div>

                    <div class="section-footer">
                        <a href="designs" class="btn btn-lg btn-outline">View All Designs</a>
                    </div>
                </div>
            </section>

            <!-- Career Opportunities -->
            <!-- ... (unchanged, omitted for brevity) ... -->

            <!-- Featured Artists -->
            <section id="artists" class="featured-artists">
                <div class="container">
                    <div class="artists-grid">
                        <!-- Intentionally left empty (original static cards commented out) -->
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

                    <div class="cta-grid"></div>

                    <!-- Stats -->
                    <div class="cta-stats">
                        <div class="cta-stat">
                            <div class="cta-stat-number">Editable</div>
                            <div class="cta-stat-label">Active Designs</div>
                        </div>
                        <div class="cta-stat">
                            <div class="cta-stat-number">Trusted</div>
                            <div class="cta-stat-label">By Clients</div>
                        </div>
                        <div class="cta-stat">
                            <div class="cta-stat-number">Professional</div>
                            <div class="cta-stat-label">Designers</div>
                        </div>
                        <div class="cta-stat">
                            <div class="cta-stat-number">Excellent</div>
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