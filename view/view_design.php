<?php
session_start();
include("../connections.php");

if (!isset($_SESSION["User_ID"])) {
    $User_ID = 1; // Default to guest user
} else {
    $User_ID = $_SESSION["User_ID"];
}

// Require a design id in query string
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die("Design not specified.");
}

$designId = (int) $_GET['id'];

// Get user info (for initials/avatar, etc.)
$userStmt = $connections->prepare("SELECT User_ID, User_FirstName, User_LastName FROM user WHERE User_ID = ?");
$userStmt->bind_param("i", $User_ID);
$userStmt->execute();
$userResult = $userStmt->get_result();
if ($userResult->num_rows === 0) {
    die("User not found.");
}
$user = $userResult->fetch_assoc();
$User_Initials = strtoupper(substr($user['User_FirstName'],0,1) . substr($user['User_LastName'],0,1));
$userStmt->close();

// NOTE: This query currently restricts viewing to owner's designs only.
// If you want non-owners to view/purchase, remove "AND d.User_ID = ?"
// and don't bind $User_ID here.
$designStmt = $connections->prepare("
    SELECT 
        d.*,
        IFNULL(AVG(r.Design_Rate), 0) AS averageRate,
        COUNT(r.Design_Rate) AS reviewCount
    FROM design d
    LEFT JOIN rating r ON d.Design_ID = r.Design_ID
    WHERE d.Design_ID = ? AND d.User_ID = ?
    GROUP BY d.Design_ID
");
$designStmt->bind_param("ii", $designId, $User_ID);
$designStmt->execute();
$designResult = $designStmt->get_result();

if ($designResult->num_rows === 0) {
    http_response_code(404);
    die("Design not found.");
}

$design = $designResult->fetch_assoc();
$designStmt->close();

// Prepare safe variables
$designName = htmlspecialchars($design['Design_Name'] ?? 'Design');
$designDescription = htmlspecialchars($design['Design_Description'] ?? 'Description');
$designCategory = htmlspecialchars($design['Design_Category'] ?? 'Category');
$designPhoto = htmlspecialchars($design['Design_Photo'] ?? '../media/placeholder.png');
$designPrice = htmlspecialchars($design['Design_Price'] ?? '0.00');
$designCreatedAt = htmlspecialchars(date("M d, Y", strtotime($design['Design_Created_At'] ?? 'now')));
$averageRate = number_format((float)$design['averageRate'], 1);
$reviewCount = (int)$design['reviewCount'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $designName; ?> - Graphio</title>
    <link rel="stylesheet" href="view_design.css">

    <!-- Lucide Icons (pinned version + robust init and CDN fallback) -->
    <script
        defer
        src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"
        onload="window.lucide && lucide.createIcons()"
        onerror="(function(){var s=document.createElement('script');s.defer=true;s.src='https://cdn.jsdelivr.net/npm/lucide@0.469.0/dist/umd/lucide.min.js';s.onload=function(){window.lucide && lucide.createIcons()};document.head.appendChild(s);}())"
    ></script>
</head>
<body>
    <div class="page-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="header-container">
                <div class="header-content">
                    <div class="header-left">
                        <a href="../index" class="logo">
                            <span class="logo-text">Graphio</span>
                        </a>
                    </div>
                    <div class="header-right">
                        <div class="user-avatar">
                            <a href="../user/profile" class="logo-link-white">
                                <span class="avatar-text"><?php echo htmlspecialchars($User_Initials); ?></span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- Breadcrumb -->
        <div class="breadcrumb-section">
            <div class="container">
                <?php if ($user['User_ID'] !== $design['User_ID']) {
                    echo '
                        <nav class="breadcrumb">
                        <a href="../index" class="breadcrumb-link">
                            <i data-lucide="home" class="icon-sm"></i>
                            Home
                        </a>
                        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                        <a href="../designs.php" class="breadcrumb-link">Designs</a>
                        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                        <span class="breadcrumb-current">' . htmlspecialchars($designName) . '</span>
                    </nav>
                    ';
                } else {
                    echo '
                        <nav class="breadcrumb">
                        <a href="../index" class="breadcrumb-link">
                            <i data-lucide="home" class="icon-sm"></i>
                            Home
                        </a>
                        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                        <a href="../user/user_designs.php" class="breadcrumb-link">My Designs</a>
                        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                        <span class="breadcrumb-current">' . htmlspecialchars($designName) . '</span>
                    </nav>
                    ';
                } ?>
            </div>
        </div>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container">
                <div class="design-layout">
                    <!-- Design Image -->
                    <div class="design-image-section">
                        <div class="main-image-container">
                            <img 
                                id="mainImage"
                                src="<?php echo $designPhoto; ?>"
                                alt="<?php echo $designName; ?>"
                                class="main-image"
                            >
                            <div class="image-actions">
                                <button class="image-action-btn" onclick="zoomImage()">
                                    <i data-lucide="zoom-in" class="icon-sm"></i>
                                    Zoom
                                </button>
                                <button class="image-action-btn" onclick="fullscreen()">
                                    <i data-lucide="maximize" class="icon-sm"></i>
                                    Fullscreen
                                </button>
                            </div>
                        </div>
                        
                        <!-- Thumbnail Gallery (single thumbnail based on main image) -->
                        <div class="thumbnail-gallery">
                            <div class="thumbnail active" onclick="changeImage(this, '<?php echo $designPhoto; ?>')">
                                <img src="<?php echo $designPhoto; ?>" alt="Main View" class="thumbnail-img">
                            </div>
                        </div>
                    </div>

                    <!-- Design Details -->
                    <div class="design-details-section">
                        <div class="design-header">
                            <div class="design-category">
                                <span class="category-tag"><?php echo $designCategory; ?></span>
                                <!-- Example badge; show if needed -->
                                <!-- <span class="featured-badge">
                                    <i data-lucide="star" class="icon-xs"></i>
                                    Featured
                                </span> -->
                            </div>
                            <h1 class="design-title"><?php echo $designName; ?></h1>
                            <div class="design-meta">
                                <div class="rating-section">
                                    <div class="stars">
                                        <!-- Simple 5-star display; you can compute filled based on $averageRate if desired -->
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i data-lucide="star" class="star <?php echo ($i <= $averageRate) ? 'filled' : ''; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="rating-text"><?php echo $averageRate; ?></span>
                                    <span class="rating-count">(<?php echo $reviewCount; ?> reviews)</span>
                                </div>
                                <div class="design-stats">
                                    <span class="stat">
                                        <i data-lucide="calendar" class="icon-xs"></i>
                                        <?php echo $designCreatedAt; ?>
                                    </span>
                                    <span class="stat">
                                        <i data-lucide="download" class="icon-xs"></i>
                                        0 downloads
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="price-section">
                            <div class="price-container">
                                <span class="current-price">₱<?php echo $designPrice; ?></span>
                            </div>
                            <div class="price-info">
                                <span class="license-info">
                                    <i data-lucide="shield-check" class="icon-xs"></i>
                                    Commercial License Included
                                </span>
                            </div>
                        </div>

                        <?php if ($user['User_ID'] !== $design['User_ID']){
                        echo '
                            <div class="purchase-section">
                            <div class="purchase-actions">
                                <button class="btn btn-gradient btn-large" onclick="purchaseDesign()">
                                    <i data-lucide="shopping-cart" class="icon-sm"></i>
                                    Purchase Design
                                </button>
                            </div>
                            <div class="purchase-guarantee">
                                <div class="guarantee-item">
                                    <i data-lucide="shield" class="icon-sm guarantee-icon"></i>
                                    <div class="guarantee-text">
                                        <span class="guarantee-title">30-Day Money Back Guarantee</span>
                                        <span class="guarantee-description">Full refund if not satisfied</span>
                                    </div>
                                </div>
                                <div class="guarantee-item">
                                    <i data-lucide="download" class="icon-sm guarantee-icon"></i>
                                    <div class="guarantee-text">
                                        <span class="guarantee-title">Instant Download</span>
                                        <span class="guarantee-description">Access files immediately after purchase</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                        } else {
                            echo '<div class="own-design-note">
                                <i data-lucide="info" class="icon-sm info-icon"></i>
                                <span class="info-text">This is your own design. You cannot purchase it.</span>
                            </div>';
                        }
                        
                        ?>

                        <br>

                        <div class="designer-info">
                            <div class="designer-header">
                                <h3 class="section-title">About the Designer</h3>
                            </div>
                            <div class="designer-card">
                                <div class="designer-avatar">
                                    <img src="../media/default_user_photo.jpg" alt="Designer" class="avatar-img">
                                </div>
                                <div class="designer-details">
                                    <h4 class="designer-name"><?php echo htmlspecialchars($user['User_FirstName'] . " " . $user['User_LastName']); ?></h4>
                                    <p class="designer-title">Designer</p>
                                    <div class="designer-stats">
                                        <span class="designer-stat"><?php echo $averageRate; ?>★ Rating</span>
                                        <span class="designer-stat">1+ Designs</span>
                                        <span class="designer-stat">Member</span>
                                    </div>
                                </div>
                                <div class="designer-actions">
                                    <a href="../user/profile" class="btn btn-outline btn-sm">View Profile</a>
                                    <button class="btn btn-gradient btn-sm" onclick="contactDesigner()">Contact</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Design Description & Details -->
                <div class="design-content">
                    <div class="content-layout">
                        <div class="main-content-area">
                            <!-- Description -->
                            <div class="content-section">
                                <h2 class="section-title">Description</h2>
                                <div class="description-content">
                                    <p>
                                        <!-- This is a placeholder description for "<?php echo $designName; ?>". You can store a description field in your database and display it here. -->
                                        <?php echo $designDescription; ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Specifications -->
                            <div class="content-section">
                                <h2 class="section-title">Specifications</h2>
                                <div class="specs-grid">
                                    <div class="spec-item">
                                        <span class="spec-label">Category</span>
                                        <span class="spec-value"><?php echo $designCategory; ?></span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label">Created</span>
                                        <span class="spec-value"><?php echo $designCreatedAt; ?></span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label">Price</span>
                                        <span class="spec-value">$<?php echo $designPrice; ?></span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label">License</span>
                                        <span class="spec-value">Commercial Use Allowed</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Reviews -->
                            <div class="content-section">
                                <div class="reviews-header">
                                    <h2 class="section-title">Customer Reviews</h2>
                                    <div class="reviews-summary">
                                        <div class="review-score">
                                            <span class="score-number"><?php echo $averageRate; ?></span>
                                            <div class="score-stars">
                    
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <i data-lucide="star" class="star <?php echo ($i <= $averageRate) ? 'filled' : ''; ?>"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <span class="score-text">Based on <?php echo $reviewCount; ?> reviews</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="sidebar">
                            <!-- Tags -->
                            <div class="sidebar-section">
                                <h3 class="sidebar-title">Categories</h3>
                                <div class="tags-list">
                                    <span class="tag"><?php echo $designCategory; ?></span>
                                </div>
                            </div>

                            <!-- Share -->
                            <div class="sidebar-section">
                                <h3 class="sidebar-title">Share This Design</h3>
                                <div class="share-buttons">
                                    <button class="share-btn facebook" onclick="shareOn('facebook')">
                                        <i data-lucide="facebook" class="icon-sm"></i>
                                        Facebook
                                    </button>
                                    <button class="share-btn twitter" onclick="shareOn('twitter')">
                                        <i data-lucide="twitter" class="icon-sm"></i>
                                        Twitter
                                    </button>
                                    <button class="share-btn linkedin" onclick="shareOn('linkedin')">
                                        <i data-lucide="linkedin" class="icon-sm"></i>
                                        LinkedIn
                                    </button>
                                    <button class="share-btn copy" onclick="copyLink()">
                                        <i data-lucide="link" class="icon-sm"></i>
                                        Copy Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-container">
                <div class="footer-content">
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

    <!-- Image Zoom Modal -->
    <div class="modal-overlay" id="imageModal">
        <div class="image-modal">
            <button class="modal-close" onclick="closeImageModal()">
                <i data-lucide="x" class="icon-lg"></i>
            </button>
            <img id="modalImage" src="" alt="" class="modal-image">
        </div>
    </div>

    <script>
        // Initialize Lucide icons robustly
        document.addEventListener('DOMContentLoaded', function() {
            if (window.lucide && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        });
        window.addEventListener('load', function() {
            if (window.lucide && typeof lucide.createIcons === 'function') {
                // Run again after full load to be safe
                lucide.createIcons();
            }
        });

        // Image gallery functionality
        function changeImage(thumbnail, imageSrc) {
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
            document.getElementById('mainImage').src = imageSrc;

            // If thumbnails are dynamically added later, re-run icon creation
            if (window.lucide && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        }

        // Zoom image functionality
        function zoomImage() {
            const mainImage = document.getElementById('mainImage');
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = mainImage.src;
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Fullscreen functionality
        function fullscreen() {
            const image = document.getElementById('mainImage');
            if (image.requestFullscreen) {
                image.requestFullscreen();
            } else if (image.webkitRequestFullscreen) {
                image.webkitRequestFullscreen();
            } else if (image.msRequestFullscreen) {
                image.msRequestFullscreen();
            }
        }

        // Purchase functionality
        function purchaseDesign() {
            alert('Redirecting to secure checkout...');
        }

        function contactDesigner() {
            alert('Opening message composer...');
        }

        // Share functionality
        function shareOn(platform) {
            const url = window.location.href;
            const title = '<?php echo addslashes($designName); ?> - Graphio';
            
            let shareUrl = '';
            switch(platform) {
                case 'facebook':
                    shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                    break;
                case 'twitter':
                    shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(url)}&text=${encodeURIComponent(title)}`;
                    break;
                case 'linkedin':
                    shareUrl = `https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(url)}`;
                    break;
            }
            if (shareUrl) {
                window.open(shareUrl, '_blank', 'width=600,height=400');
            }
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link copied to clipboard!');
            });
        }

        // Close modal when clicking outside
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
    </script>
</body>
</html>