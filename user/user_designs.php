<?php
session_start();
include("../connections.php");

if (!isset($_SESSION["User_ID"])) {
    // Handle guest or redirect
    die("User not logged in.");
}

$User_ID = $_SESSION["User_ID"];

// Get user info
$userQuery = mysqli_query($connections, "SELECT * FROM user WHERE User_ID='$User_ID'");
$user = mysqli_fetch_assoc($userQuery);
$User_Initials = strtoupper(substr($user['User_FirstName'],0,1) . substr($user['User_LastName'],0,1));

// Get all user designs
$designsQuery = mysqli_query($connections, "
    SELECT d.*, IFNULL(AVG(r.Design_Rate), 0) AS averageRate
    FROM design d
    LEFT JOIN rating r ON d.Design_ID = r.Design_ID
    WHERE d.User_ID = '$User_ID'
    GROUP BY d.Design_ID
    ORDER BY d.Design_Created_At DESC
");

$designs = [];
while ($row = mysqli_fetch_assoc($designsQuery)) {
    // Round averageRate to 1 decimal place
    $row['averageRate'] = number_format($row['averageRate'], 1);
    $designs[] = $row;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Designs - Graphio</title>
    <link rel="stylesheet" href="user_designs_styles.css">
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
                        <a href="../index" class="logo-link">
                            <img class="graphio-logo" src="../logos/graphio_logo_blue.png" />
                        </a>
                    </div>

                    <!-- Right side buttons -->
                    <div class="header-buttons">
                       
                        <a href="dashboard" class="btn btn-outline btn-sm">Dashboard</a>
                        <div class="profile-menu">
                            <button class="profile-avatar">
                                <img src="../media/default_user_photo.jpg" alt="Profile" class="avatar-img">
                            </button>
                        </div>
                        
                        <!-- Mobile menu button -->
                        <button class="btn btn-ghost btn-sm mobile-menu">
                            <i data-lucide="menu" class="icon-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main class="main-content">
            <!-- Page Header -->
            <section class="page-header">
                <div class="container">
                    <div class="header-content-wrapper">
                        <div class="breadcrumb">
                            <a href="profile" class="breadcrumb-link">Profile</a>
                            <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                            <span class="breadcrumb-current">My Designs</span>
                        </div>
                        
                        <div class="page-title-section">
                            <div class="page-info">
                                <h1 class="page-title">My Designs</h1>
                                <p class="page-subtitle">Showcase your creative work and portfolio</p>
                            </div>
                            <div class="page-actions">
                                <button class="btn btn-gradient">
                                    <i data-lucide="plus" class="icon-sm"></i>
                                    <a href="../user_dashboard/add_design" class="logo-link-white">Upload Design</a>
                                </button>
                            </div>
                        </div>
                        
                        
                    </div>
                </div>
            </section>

            <!-- Filters & Sort -->
            <section class="filters-section">
                <div class="container">
                    <div class="filters-wrapper">
                        <div class="filter-tabs">
                            <button class="filter-tab active" data-filter="all">All Designs (<?php echo count($designs); ?>)</button>
                            <?php foreach ($designs as $category): ?>
                            <button class="filter-tab" data-filter="<?php echo htmlspecialchars($category['Design_Category']); ?>"><?php echo htmlspecialchars($category['Design_Category']); ?></button>
                            <?php endforeach; ?>

                            <!-- <button class="filter-tab active" data-filter="all">All Designs</button>
                            <button class="filter-tab" data-filter="logo">Logo Design</button>
                            <button class="filter-tab" data-filter="branding">Branding</button>
                            <button class="filter-tab" data-filter="print">Print Design</button>
                            <button class="filter-tab" data-filter="digital">Digital Design</button>
                            <button class="filter-tab" data-filter="ui-ux">UI/UX</button> -->
                        </div>
                        
                        <div class="sort-options">
                            <!-- <select class="sort-select">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="popular">Most Popular</option>
                                <option value="views">Most Viewed</option>
                                <option value="downloads">Most Downloaded</option>
                            </select> -->
                            
                            <div class="view-options">
                                <button class="view-btn active" data-view="grid">
                                    <i data-lucide="grid-3x3" class="icon-sm"></i>
                                </button>
                                <button class="view-btn" data-view="list">
                                    <i data-lucide="list" class="icon-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Designs Grid -->
            <section class="designs-section">
                <div class="container">
                    <div class="designs-grid" id="designs-container">
                        <?php foreach ($designs as $design): ?>
                        <div class="design-card" data-category="<?php echo htmlspecialchars($design['Design_Category']); ?>">
                            <div class="design-image">
                                <img src="<?php echo htmlspecialchars($design['Design_Photo']); ?>" alt="<?php echo htmlspecialchars($design['Design_Name']); ?>" class="design-img">
                                <div class="design-overlay">
                                    <div class="design-actions">
                                        <button class="action-btn" title="Preview"><i data-lucide="eye" class="icon-sm"></i></button>
                                        <button class="action-btn" title="Edit"><i data-lucide="edit-2" class="icon-sm"></i></button>
                                        <button class="action-btn" title="Share"><i data-lucide="share-2" class="icon-sm"></i></button>
                                        <button class="action-btn danger" title="Delete"><i data-lucide="trash-2" class="icon-sm"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="design-info">
                                <h3 class="design-title"><?php echo htmlspecialchars($design['Design_Name']); ?></h3>
                                <p class="design-category"><?php echo htmlspecialchars($design['Design_Category']); ?></p>
                                <div class="design-meta">
                                    <span class="design-date"><?php echo date("M d, Y", strtotime($design['Design_Created_At'])); ?></span>
                                    <span class="design-price">$<?php echo htmlspecialchars($design['Design_Price']); ?></span>
                                </div>
                                <div class="design-stats">
                                    <span class="stat">
                                        <i data-lucide="star" class="icon-xs"></i>
                                        <?php echo $design['averageRate']; ?>
                                    </span>
                                    <span class="stat">
                                        <i data-lucide="download" class="icon-xs"></i>
                                        43
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <!-- Load More
                    <div class="load-more-section">
                        <button class="btn btn-outline btn-lg load-more-btn">
                            Load More Designs
                        </button>
                    </div> -->
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-content">
                    <div class="footer-section">
                        <h3 class="footer-title">Graphio</h3>
                        <p class="footer-description">
                            The leading marketplace for creative professionals. Connect, create, and grow your design business.
                        </p>
                        <div class="footer-social">
                            <a href="#" class="social-link">
                                <i data-lucide="twitter" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="facebook" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="instagram" class="icon-sm"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i data-lucide="linkedin" class="icon-sm"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-subtitle">For Designers</h4>
                        <ul class="footer-links">
                            <li><a href="#" class="footer-link">Join as Designer</a></li>
                            <li><a href="#" class="footer-link">Designer Resources</a></li>
                            <li><a href="#" class="footer-link">Success Stories</a></li>
                            <li><a href="#" class="footer-link">Portfolio Tips</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-subtitle">For Clients</h4>
                        <ul class="footer-links">
                            <li><a href="#" class="footer-link">Find Designers</a></li>
                            <li><a href="#" class="footer-link">Post Project</a></li>
                            <li><a href="#" class="footer-link">How It Works</a></li>
                            <li><a href="#" class="footer-link">Client Guide</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h4 class="footer-subtitle">Company</h4>
                        <ul class="footer-links">
                            <li><a href="../about.html" class="footer-link">About Us</a></li>
                            <li><a href="../careers" class="footer-link">Careers</a></li>
                            <li><a href="#" class="footer-link">Press</a></li>
                            <li><a href="#" class="footer-link">Contact</a></li>
                        </ul>
                    </div>
                </div>
                
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
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });

        // Filter functionality
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove active class from all tabs
                document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
                // Add active class to clicked tab
                this.classList.add('active');
                
                const filter = this.getAttribute('data-filter');
                const designs = document.querySelectorAll('.design-card');
                
                designs.forEach(design => {
                    if (filter === 'all' || design.getAttribute('data-category') === filter) {
                        design.style.display = 'block';
                    } else {
                        design.style.display = 'none';
                    }
                });
            });
        });

        // View toggle functionality
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.getAttribute('data-view');
                const container = document.getElementById('designs-container');
                
                if (view === 'list') {
                    container.classList.add('list-view');
                } else {
                    container.classList.remove('list-view');
                }
            });
        });

        // Modal functions (placeholders)
        function openFilterModal() {
            alert('Filter modal would open here');
        }

        function openUploadModal() {
            alert('Upload design modal would open here');
        }

        // Load more functionality
        document.querySelector('.load-more-btn').addEventListener('click', function() {
            this.innerHTML = '<i data-lucide="loader-2" class="icon-sm animate-spin"></i> Loading...';
            
            // Simulate loading
            setTimeout(() => {
                this.innerHTML = 'Load More Designs';
                alert('More designs would be loaded here');
            }, 1000);
        });
    </script>
</body>
</html>