<?php
session_start();

/*
  IMPORTANT: We handle the purchase BEFORE rendering any HTML,
  and we start output buffering BEFORE including connections.php.
  This guarantees a clean JSON response even if connections.php
  or PHP warnings echo output.
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'purchase') {
    header('Content-Type: application/json; charset=utf-8');
    ini_set('display_errors', '0');

    // Start buffering before any includes to capture stray output
    ob_start();

    include("../connections.php");

    try {
        // Enable MySQLi exceptions for precise error reporting
        if (function_exists('mysqli_report')) {
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }

        // Validate input
        $purchaseDesignId = isset($_POST['design_id']) ? (int)$_POST['design_id'] : 0;
        if ($purchaseDesignId <= 0) {
            ob_clean();
            echo json_encode(['ok' => false, 'message' => 'Missing or invalid design id.']);
            exit;
        }

        // Fetch design (owner + price), exclude archived (Design_Status = 2)
        $stmt = $connections->prepare("
            SELECT Design_ID, User_ID, COALESCE(Design_Price, 0) AS Design_Price, Design_Status
            FROM design
            WHERE Design_ID = ?
            LIMIT 1
        ");
        $stmt->bind_param("i", $purchaseDesignId);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows === 0) {
            $stmt->close();
            ob_clean();
            echo json_encode(['ok' => false, 'message' => 'Design not found.']);
            exit;
        }
        $d = $res->fetch_assoc();
        $stmt->close();

        if (isset($d['Design_Status']) && (string)$d['Design_Status'] === '2') {
            ob_clean();
            echo json_encode(['ok' => false, 'message' => 'This design is not available.']);
            exit;
        }

        $ownerId = (int)$d['User_ID'];                 // Designer who will be credited
        $amount  = (float)$d['Design_Price'];          // Amount to add

        if ($amount <= 0) {
            ob_clean();
            echo json_encode(['ok' => false, 'message' => 'Design price is invalid or zero.']);
            exit;
        }

        // Insert a sale row in your sales table
        // Store Design_ID in Payment_ID column (or we can add a Design_ID column to sales table)
        // Note: If foreign key constraint exists on Payment_ID, it needs to be removed
        $ins = $connections->prepare("
            INSERT INTO sales (Payment_ID, User_ID, Sales_Amount, Sales_Date)
            VALUES (?, ?, ?, NOW())
        ");
        $ins->bind_param("iid", $purchaseDesignId, $ownerId, $amount);
        $ins->execute();
        $saleId = $connections->insert_id;
        $ins->close();

        // Clean any prior buffered output and return JSON
        ob_clean();
        echo json_encode([
            'ok'        => true,
            'message'   => 'Purchase recorded.',
            'sale_id'   => $saleId,
            'owner_id'  => $ownerId,
            'amount'    => $amount
        ]);
        exit;
    } catch (Throwable $e) {
        // If anything fails, clear buffer and return JSON with debug info
        $debug = $e->getMessage();
        ob_clean();
        echo json_encode([
            'ok'      => false,
            'message' => 'Could not record sale.',
            'debug'   => $debug
        ]);
        exit;
    }
}

// -------- Normal page render (GET) below --------
include("../connections.php");

// Allow guests to view. If logged in, use the ID for ownership checks.
$User_ID = isset($_SESSION["User_ID"]) ? (int)$_SESSION["User_ID"] : null;

// Validate design id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die("Design not specified.");
}
$designId = (int) $_GET['id'];

// Fetch the design publicly (exclude archived)
$designStmt = $connections->prepare("
    SELECT 
        d.*,
        IFNULL(AVG(r.Design_Rate), 0) AS averageRate,
        COUNT(r.Design_Rate) AS reviewCount
    FROM design d
    LEFT JOIN rating r ON d.Design_ID = r.Design_ID
    WHERE d.Design_ID = ? AND (d.Design_Status IS NULL OR d.Design_Status <> 2)
    GROUP BY d.Design_ID
");
$designStmt->bind_param("i", $designId);
$designStmt->execute();
$designResult = $designStmt->get_result();

if ($designResult->num_rows === 0) {
    http_response_code(404);
    die("Design not found.");
}
$design = $designResult->fetch_assoc();
$designStmt->close();

// Fetch owner info (to show designer details)
$ownerId = (int) $design['User_ID'];
$ownerStmt = $connections->prepare("
    SELECT User_FirstName, User_LastName, COALESCE(User_Photo, '') AS User_Photo 
    FROM user 
    WHERE User_ID = ?
");
$ownerStmt->bind_param("i", $ownerId);
$ownerStmt->execute();
$ownerRes = $ownerStmt->get_result();
$owner = $ownerRes->fetch_assoc();
$ownerStmt->close();

// Determine if viewer is the owner
$isOwner = ($User_ID !== null && $User_ID === $ownerId);

// Prepare viewer initials if logged in (optional, used in header)
$User_Initials = "G";
if ($User_ID !== null) {
    $viewerStmt = $connections->prepare("SELECT User_FirstName, User_LastName FROM user WHERE User_ID = ?");
    $viewerStmt->bind_param("i", $User_ID);
    $viewerStmt->execute();
    $viewerRes = $viewerStmt->get_result();
    if ($viewerRes->num_rows > 0) {
        $viewer = $viewerRes->fetch_assoc();
        $User_Initials = strtoupper(substr($viewer['User_FirstName'] ?? '', 0, 1) . substr($viewer['User_LastName'] ?? '', 0, 1));
    } else {
        $User_Initials = "U";
    }
    $viewerStmt->close();
}

// Helper: normalize asset paths for a page inside /view/
function normalizeForView($path, $default) {
    $p = trim((string)$path);
    if ($p === '') return $default;
    if (preg_match('#^https?://#i', $p)) return $p; // absolute URL
    if ($p[0] === '/') return $p;                   // site-root relative
    if (strpos($p, '../') === 0) return $p;         // already relative to parent
    if (strpos($p, './') === 0) $p = substr($p, 2);
    return '../' . ltrim($p, '/');
}

// Safe variables for template
$designName = htmlspecialchars($design['Design_Name'] ?? 'Design');
$designCategory = htmlspecialchars($design['Design_Category'] ?? 'Category');
$designPhoto = htmlspecialchars(normalizeForView($design['Design_Photo'] ?? '', '../media/placeholder.png'));
$designPrice = htmlspecialchars(number_format((float)($design['Design_Price'] ?? 0), 2));
$designCreatedAt = htmlspecialchars(date("M d, Y", strtotime($design['Design_Created_At'] ?? 'now')));
$averageRate = number_format((float)$design['averageRate'], 1);
$reviewCount = (int)$design['reviewCount'];
$designDescription = htmlspecialchars($design['Design_Description'] ?? '');
$ownerName = htmlspecialchars(trim(($owner['User_FirstName'] ?? '') . ' ' . ($owner['User_LastName'] ?? '')));
$ownerPhoto = htmlspecialchars(normalizeForView($owner['User_Photo'] ?? '', '../media/default_user_photo.jpg'));
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
                <?php if ($isOwner): ?>
                    <nav class="breadcrumb">
                        <a href="../index" class="breadcrumb-link">
                            <i data-lucide="home" class="icon-sm"></i>
                            Home
                        </a>
                        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                        <a href="../user/user_designs.php" class="breadcrumb-link">My Designs</a>
                        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                        <span class="breadcrumb-current"><?php echo $designName; ?></span>
                    </nav>
                <?php else: ?>
                    <nav class="breadcrumb">
                        <a href="../index" class="breadcrumb-link">
                            <i data-lucide="home" class="icon-sm"></i>
                            Home
                        </a>
                        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                        <a href="../designs.php" class="breadcrumb-link">Designs</a>
                        <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                        <span class="breadcrumb-current"><?php echo $designName; ?></span>
                    </nav>
                <?php endif; ?>
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
                        
                        <!-- Thumbnail Gallery -->
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
                            </div>
                            <h1 class="design-title"><?php echo $designName; ?></h1>
                            <div class="design-meta">
                                <div class="rating-section">
                                    <div class="stars">
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

                        <?php if (!$isOwner): ?>
                            <div class="purchase-section">
                                <div class="purchase-actions">
                                    <button class="btn btn-gradient btn-large" onclick="purchaseDesign(<?php echo (int)$designId; ?>)">
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
                        <?php else: ?>
                            <div class="own-design-note">
                                <i data-lucide="info" class="icon-sm info-icon"></i>
                                <span class="info-text">This is your own design. You cannot purchase it.</span>
                            </div>
                        <?php endif; ?>

                        <br>

                        <div class="designer-info">
                            <div class="designer-header">
                                <h3 class="section-title">About the Designer</h3>
                            </div>
                            <div class="designer-card">
                                <div class="designer-details">
                                    <h4 class="designer-name"><?php echo $ownerName; ?></h4>
                                    <p class="designer-title">Designer</p>
                                    <div class="designer-stats">
                                        <span class="designer-stat"><?php echo $averageRate; ?>★ Rating</span>
                                        <span class="designer-stat">1+ Designs</span>
                                        <span class="designer-stat">Member</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Design Description & Details -->
                <div class="design-content">
                    <div class="content-layout">
                        <div class="main-content-area">
                            <div class="content-section">
                                <h2 class="section-title">Description</h2>
                                <div class="description-content">
                                    <p><?php echo $designDescription; ?></p>
                                </div>
                            </div>

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
                                        <span class="spec-value">₱<?php echo $designPrice; ?></span>
                                    </div>
                                    <div class="spec-item">
                                        <span class="spec-label">License</span>
                                        <span class="spec-value">Commercial Use Allowed</span>
                                    </div>
                                </div>
                            </div>

                            <div class="content-section">
                                <div class="reviews-header">
                                    <h2 class="section-title">Customer Reviews</h2>
                                    <div class="reviews-summary">
                                        <div class="review-score">
                                            <span class="score-number"><?php echo $averageRate; ?></span>
                                            <div class="review-stars">
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
                            <div class="sidebar-section">
                                <h3 class="sidebar-title">Categories</h3>
                                <div class="tags-list">
                                    <span class="tag"><?php echo $designCategory; ?></span>
                                </div>
                            </div>

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

    <!-- Success Notification Modal -->
    <div class="modal-overlay" id="successModal">
        <div class="success-modal">
            <div class="success-icon-wrapper">
                <div class="success-icon">
                    <i data-lucide="check-circle" class="icon-xxl"></i>
                </div>
            </div>
            <h2 class="success-title">Transaction Successful!</h2>
            <p class="success-message">Your purchase has been completed successfully. The design is now available in your library.</p>
            <div class="success-details">
                <div class="success-detail-item">
                    <i data-lucide="shopping-bag" class="icon-sm"></i>
                    <span>Design purchased</span>
                </div>
                <div class="success-detail-item">
                    <i data-lucide="credit-card" class="icon-sm"></i>
                    <span id="purchaseAmount">₱0.00</span>
                </div>
            </div>
            <button class="btn btn-gradient btn-large" onclick="closeSuccessModal()">
                Continue Browsing
            </button>
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
                lucide.createIcons();
            }
        });

        function changeImage(thumbnail, imageSrc) {
            document.querySelectorAll('.thumbnail').forEach(thumb => {
                thumb.classList.remove('active');
            });
            thumbnail.classList.add('active');
            document.getElementById('mainImage').src = imageSrc;

            if (window.lucide && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        }

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

        // Robust purchase: show backend debug in console if something goes wrong
        async function purchaseDesign(designId) {
            try {
                const fd = new FormData();
                fd.append('action', 'purchase');
                fd.append('design_id', String(designId));

                const res = await fetch(window.location.pathname + window.location.search, { method: 'POST', body: fd });
                const text = await res.text();

                let data;
                try { data = JSON.parse(text); }
                catch (e) {
                    console.error('Purchase response was not JSON:', text);
                    alert('Server error while purchasing. Open Console for details.');
                    return;
                }

                if (data.ok) {
                    // Show success modal with purchase details
                    showSuccessModal(data.amount || 0);
                } else {
                    console.error('Purchase failed:', data);
                    alert(data.message || 'Could not complete purchase.');
                }
            } catch (err) {
                console.error(err);
                alert('Network error while purchasing.');
            }
        }

        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link copied to clipboard!');
            });
        }

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
            if (shareUrl) window.open(shareUrl, '_blank', 'width=600,height=400');
        }

        document.getElementById('imageModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeImageModal();
        });

        function showSuccessModal(amount) {
            const modal = document.getElementById('successModal');
            const amountEl = document.getElementById('purchaseAmount');
            if (amountEl) {
                amountEl.textContent = '₱' + parseFloat(amount).toFixed(2);
            }
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Reinitialize icons for the modal
            if (window.lucide && typeof lucide.createIcons === 'function') {
                lucide.createIcons();
            }
        }

        function closeSuccessModal() {
            const modal = document.getElementById('successModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        document.getElementById('successModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeSuccessModal();
        });
    </script>
</body>
</html>