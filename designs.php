<?php
session_start();
include("connections.php");

// Public page: no login required

$defaultDesignPhoto = 'media/default_design_photo.jpg';

// Fetch all non-archived designs with owner name and average rating
$sql = "
    SELECT 
        d.Design_ID,
        d.User_ID,
        d.Design_Name,
        d.Design_Description,
        d.Design_Category,
        d.Design_Price,
        d.Design_Photo,
        d.Design_Created_At,
        u.User_FirstName,
        u.User_LastName,
        COALESCE(AVG(r.Design_Rate), 0) AS averageRate
    FROM design d
    INNER JOIN user u ON u.User_ID = d.User_ID
    LEFT JOIN rating r ON r.Design_ID = d.Design_ID
    WHERE (d.Design_Status IS NULL OR d.Design_Status <> 2)
    GROUP BY d.Design_ID
    ORDER BY d.Design_Created_At DESC
";
$res = mysqli_query($connections, $sql);

$designs = [];
$categories = [];
if ($res) {
    while ($row = mysqli_fetch_assoc($res)) {
        $row['Design_Name'] = $row['Design_Name'] ?? 'Untitled';
        $row['Design_Category'] = $row['Design_Category'] ?? 'Uncategorized';
        // Keep raw from DB; we'll normalize per-request below
        $row['Design_Photo'] = $row['Design_Photo'] ?: $defaultDesignPhoto;
        $row['averageRate'] = number_format((float)$row['averageRate'], 1);

        $designs[] = $row;
        $categories[$row['Design_Category']] = true;
    }
}
$categoryList = array_keys($categories);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designs - Graphio</title>
    <link rel="stylesheet" href="designs.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js" defer onload="window.lucide && lucide.createIcons()"></script>
</head>
<body>
<div class="min-h-screen">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="index" class="logo-link" aria-label="Graphio Home">
                    <img class="graphio-logo" src="logos/graphio_logo_blue.png" alt="Graphio">
                </a>

                <nav class="nav-desktop">
                    <a href="designs.php" class="nav-link active">Designs</a>
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
    </header>

    <!-- Hero -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Explore Designs</h1>
                <p class="hero-description">Discover creative work you can preview and purchase from our community</p>

                <div class="search-container">
                    <div class="search-input-container">
                        <i data-lucide="search" class="icon-sm search-icon"></i>
                        <input id="search-input" type="text" class="search-input" placeholder="Search by title, category, or designer...">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filters -->
    <section class="filters-section">
        <div class="container">
            <div class="filters-content">
                <div class="filters-left">
                    <div class="category-filters">
                        <i data-lucide="sliders" class="icon-sm filter-icon"></i>
                        <div class="category-buttons" id="category-buttons">
                            <button class="btn btn-category active" data-category="all">All (<?php echo count($designs); ?>)</button>
                            <?php foreach ($categoryList as $cat): ?>
                                <button class="btn btn-category" data-category="<?php echo htmlspecialchars($cat); ?>">
                                    <?php echo htmlspecialchars($cat); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="results-count" id="results-count">
                        Showing <?php echo count($designs); ?> results
                    </div>
                </div>

                <div class="filters-right">
                    <div class="sort-container">
                        <select id="sort-select" class="sort-select" aria-label="Sort">
                            <option value="newest" selected>Newest first</option>
                            <option value="oldest">Oldest first</option>
                            <option value="price_low">Price: Low to High</option>
                            <option value="price_high">Price: High to Low</option>
                            <option value="rating_high">Rating: High to Low</option>
                            <option value="rating_low">Rating: Low to High</option>
                        </select>
                    </div>

                    <!-- <div class="view-toggle" role="group" aria-label="View toggle">
                        <button class="btn btn-view active" id="btn-grid" aria-pressed="true">
                            <i data-lucide="grid-3x3" class="icon-sm"></i>
                        </button>
                        <button class="btn btn-view" id="btn-list" aria-pressed="false">
                            <i data-lucide="list" class="icon-sm"></i>
                        </button>
                    </div> -->

                    <a href="user_dashboard/add_design" class="btn btn-gradient btn-sm">
                        <i data-lucide="plus" class="icon-sm"></i>
                        Upload Design
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Designs -->
    <section class="designs-section">
        <div class="container">

            <!-- Grid view -->
            <div class="designs-grid" id="grid-container">
                <?php foreach ($designs as $d): 
                    $id = (int)$d['Design_ID'];
                    $name = htmlspecialchars($d['Design_Name']);
                    $cat  = htmlspecialchars($d['Design_Category']);
                    $price = (float)($d['Design_Price'] ?? 0);

                    // Normalize image path for root page
                    $photoRaw = $d['Design_Photo'] ?: $defaultDesignPhoto;
                    if (!preg_match('#^https?://#i', $photoRaw)) {
                        // Strip leading ../ or ./ so it works from the web root
                        while (strpos($photoRaw, '../') === 0) {
                            $photoRaw = substr($photoRaw, 3);
                        }
                        $photoRaw = ltrim($photoRaw, './');
                    }
                    $photo = htmlspecialchars($photoRaw);

                    $createdTs = strtotime($d['Design_Created_At']);
                    $created = htmlspecialchars(date("M d, Y", $createdTs));
                    $avg = (float)$d['averageRate'];
                    $avgFmt = number_format($avg, 1);
                    $owner = htmlspecialchars(trim(($d['User_FirstName'] ?? '').' '.($d['User_LastName'] ?? '')));
                ?>
                <a class="design-card logo-link" href="view/view_design.php?id=<?php echo $id; ?>"
                   data-name="<?php echo strtolower($name); ?>"
                   data-category="<?php echo strtolower($cat); ?>"
                   data-designer="<?php echo strtolower($owner); ?>"
                   data-price="<?php echo number_format($price,2,'.',''); ?>"
                   data-date="<?php echo $createdTs; ?>"
                   data-rating="<?php echo number_format($avg,2,'.',''); ?>"
                   title="<?php echo $name; ?>">
                    <div class="design-image-container">
                        <img class="design-image" src="<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                        <div class="design-overlay"></div>
                    </div>

                    <div class="design-info">
                        <div class="design-header">
                            <span class="design-category"><?php echo $cat; ?></span>
                            <span class="design-price">$<?php echo number_format($price, 2); ?></span>
                        </div>

                        <h3 class="design-title"><?php echo $name; ?></h3>
                        <div class="design-designer">
                            <i data-lucide="user" class="icon-sm"></i>
                            <span><?php echo $owner ?: 'Designer'; ?></span>
                        </div>

                        <div class="design-stats">
                            <div class="stat-group">
                                <span class="stat-item">
                                    <i data-lucide="star" class="icon-sm"></i>
                                    <?php echo $avgFmt; ?>
                                </span>
                                <span class="stat-item">
                                    <i data-lucide="calendar" class="icon-sm"></i>
                                    <?php echo $created; ?>
                                </span>
                            </div>
                            <div class="design-rating">
                                <i data-lucide="eye" class="icon-sm"></i>
                                <span>View</span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>

                <?php if (empty($designs)): ?>
                    <div class="no-results" id="no-results-grid">
                        <div class="no-results-content">
                            <div class="no-results-icon">
                                <i data-lucide="image" class="icon-lg"></i>
                            </div>
                            <h3 class="no-results-title">No designs available yet</h3>
                            <p class="no-results-description">Please check back later or try a different search.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- List view (optional, currently disabled)
            <div class="designs-list hidden" id="list-container">
                <?php foreach ($designs as $d): 
                    $id = (int)$d['Design_ID'];
                    $name = htmlspecialchars($d['Design_Name']);
                    $cat  = htmlspecialchars($d['Design_Category']);
                    $price = (float)($d['Design_Price'] ?? 0);

                    $photoRaw = $d['Design_Photo'] ?: $defaultDesignPhoto;
                    if (!preg_match('#^https?://#i', $photoRaw)) {
                        while (strpos($photoRaw, '../') === 0) {
                            $photoRaw = substr($photoRaw, 3);
                        }
                        $photoRaw = ltrim($photoRaw, './');
                    }
                    $photo = htmlspecialchars($photoRaw);

                    $createdTs = strtotime($d['Design_Created_At']);
                    $created = htmlspecialchars(date("M d, Y", $createdTs));
                    $avg = (float)$d['averageRate'];
                    $avgFmt = number_format($avg, 1);
                    $owner = htmlspecialchars(trim(($d['User_FirstName'] ?? '').' '.($d['User_LastName'] ?? '')));
                ?>
                <a class="design-list-item"
                   href="view/view_design.php?id=<?php echo $id; ?>"
                   data-name="<?php echo strtolower($name); ?>"
                   data-category="<?php echo strtolower($cat); ?>"
                   data-designer="<?php echo strtolower($owner); ?>"
                   data-price="<?php echo number_format($price,2,'.',''); ?>"
                   data-date="<?php echo $createdTs; ?>"
                   data-rating="<?php echo number_format($avg,2,'.',''); ?>">
                    <div class="list-image-container">
                        <img class="list-image" src="<?php echo $photo; ?>" alt="<?php echo $name; ?>">
                    </div>
                    <div class="list-content">
                        <div class="list-header">
                            <div class="list-badges">
                                <span class="design-category"><?php echo $cat; ?></span>
                                <span class="design-price">$<?php echo number_format($price, 2); ?></span>
                            </div>
                            <div class="list-actions">
                                <i data-lucide="calendar" class="icon-sm"></i>
                                <span style="color:#6b7280; font-size:.875rem;"><?php echo $created; ?></span>
                            </div>
                        </div>
                        <h3 class="design-title"><?php echo $name; ?></h3>
                        <div class="design-designer">
                            <i data-lucide="user" class="icon-sm"></i>
                            <span><?php echo $owner ?: 'Designer'; ?></span>
                        </div>
                        <div class="design-stats" style="margin-top:.5rem;">
                            <div class="stat-group">
                                <span class="stat-item">
                                    <i data-lucide="star" class="icon-sm"></i>
                                    <?php echo $avgFmt; ?>
                                </span>
                                <span class="stat-item">
                                    <i data-lucide="eye" class="icon-sm"></i>
                                    View
                                </span>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>

                <?php if (empty($designs)): ?>
                    <div class="no-results" id="no-results-list">
                        <div class="no-results-content">
                            <div class="no-results-icon">
                                <i data-lucide="image" class="icon-lg"></i>
                            </div>
                            <h3 class="no-results-title">No designs available yet</h3>
                            <p class="no-results-description">Please check back later or try a different search.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div> -->

        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo"><a href=""><img class="graphio-logo-footer" src="logos/graphio_logo_white.png"/></a></div>
                    <p class="footer-description">
                        The leading marketplace for creative professionals. Connect, create, and grow your design business.
                    </p>
                    <div class="footer-social">
                        <a href="#" class="social-link"><i data-lucide="twitter" class="icon-sm"></i></a>
                        <a href="#" class="social-link"><i data-lucide="facebook" class="icon-sm"></i></a>
                        <a href="#" class="social-link"><i data-lucide="instagram" class="icon-sm"></i></a>
                        <a href="#" class="social-link"><i data-lucide="linkedin" class="icon-sm"></i></a>
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
                        <li><a href="about.html" class="footer-link">About Us</a></li>
                        <li><a href="careers" class="footer-link">Careers</a></li>
                        <li><a href="#" class="footer-link">Press</a></li>
                        <li><a href="#" class="footer-link">Contact</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div class="footer-copyright">
                    © <?php echo date('Y'); ?> Graphio Studio. All rights reserved.
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
// Init icons safely
document.addEventListener('DOMContentLoaded', function() {
    if (window.lucide && typeof lucide.createIcons === 'function') {
        lucide.createIcons();
    }

    const searchInput = document.getElementById('search-input');
    const categoryButtons = document.querySelectorAll('#category-buttons .btn-category');
    const sortSelect = document.getElementById('sort-select');

    const grid = document.getElementById('grid-container');
    const list = document.getElementById('list-container');
    const btnGrid = document.getElementById('btn-grid');
    const btnList = document.getElementById('btn-list');
    const resultsCount = document.getElementById('results-count');

    function currentCards() {
        return document.querySelectorAll((grid.classList.contains('hidden') ? '#list-container' : '#grid-container') + ' > a');
    }

    function applyFilters() {
        const q = (searchInput?.value || '').trim().toLowerCase();
        const activeCatBtn = document.querySelector('#category-buttons .btn-category.active');
        const cat = activeCatBtn ? activeCatBtn.getAttribute('data-category') : 'all';

        let visible = 0;
        [grid, list].filter(Boolean).forEach(container => {
            container.querySelectorAll('a').forEach(card => {
                const name = card.dataset.name || '';
                const category = card.dataset.category || '';
                const designer = card.dataset.designer || '';

                const matchesSearch = !q || name.includes(q) || category.includes(q) || designer.includes(q);
                const matchesCat = (cat === 'all') || (category === cat.toLowerCase());

                const show = matchesSearch && matchesCat;
                card.style.display = show ? '' : 'none';
                if (show && container === (grid.classList.contains('hidden') ? list : grid)) visible++;
            });
        });

        resultsCount.textContent = 'Showing ' + visible + ' results';
    }

    function sortContainers(criteria) {
        [grid, list].filter(Boolean).forEach(container => {
            const cards = Array.from(container.querySelectorAll('a')).filter(el => el.style.display !== 'none');
            cards.sort((a, b) => {
                const da = parseFloat(a.dataset.date);
                const db = parseFloat(b.dataset.date);
                const pa = parseFloat(a.dataset.price);
                const pb = parseFloat(b.dataset.price);
                const ra = parseFloat(a.dataset.rating);
                const rb = parseFloat(b.dataset.rating);

                switch (criteria) {
                    case 'oldest': return da - db;
                    case 'price_low': return pa - pb;
                    case 'price_high': return pb - pa;
                    case 'rating_high': return rb - ra;
                    case 'rating_low': return ra - rb;
                    case 'newest':
                    default: return db - da;
                }
            });
            cards.forEach(c => container.appendChild(c));
        });
    }

    // Event bindings
    searchInput?.addEventListener('input', () => applyFilters());

    categoryButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            categoryButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            applyFilters();
        });
    });

    sortSelect?.addEventListener('change', e => sortContainers(e.target.value));

    // View toggle
    btnGrid?.addEventListener('click', () => {
        btnGrid.classList.add('active'); btnGrid.setAttribute('aria-pressed','true');
        btnList.classList.remove('active'); btnList.setAttribute('aria-pressed','false');
        grid.classList.remove('hidden');
        list?.classList.add('hidden');
        applyFilters();
    });
    btnList?.addEventListener('click', () => {
        btnList.classList.add('active'); btnList.setAttribute('aria-pressed','true');
        btnGrid.classList.remove('active'); btnGrid.setAttribute('aria-pressed','false');
        list.classList.remove('hidden');
        grid.classList.add('hidden');
        applyFilters();
    });

    // Initial sort + filter
    sortContainers('newest');
    applyFilters();
});
</script>
</body>
</html>