<?php
session_start();
include("../connections.php");

// Require login (seller/designer)
if (!isset($_SESSION["User_ID"])) {
    header("Location: ../login.php");
    exit();
}
$User_ID = (int) $_SESSION["User_ID"];
$currencySymbol = "₱";

// Normalize design photo path from this folder level
function normalizeForThis(string $path, string $default = '../media/default_design_photo.jpg'): string {
    $p = trim($path);
    if ($p === '') return $default;
    if (preg_match('#^https?://#i', $p)) return $p;
    if ($p[0] === '/') return $p;
    if (strpos($p, '../') === 0) return $p;
    if (strpos($p, './') === 0) $p = substr($p, 2);
    return '../' . ltrim($p, '/');
}

// Totals for this seller from sales table
$totals = ['sum' => 0.00, 'count' => 0];
$stmt = $connections->prepare("SELECT COALESCE(SUM(Sales_Amount),0) AS s, COUNT(*) AS c FROM sales WHERE User_ID = ?");
$stmt->bind_param("i", $User_ID);
$stmt->execute();
$res = $stmt->get_result()->fetch_assoc();
$stmt->close();
if ($res) {
    $totals['sum'] = (float)$res['s'];
    $totals['count'] = (int)$res['c'];
}

// Recent 10 sales joined with design by Payment_ID (we store Design_ID in Payment_ID)
$recentSales = [];
$stmt = $connections->prepare("
    SELECT s.Sales_ID, s.Sales_Amount, s.Sales_Date, s.Payment_ID,
           d.Design_Name, d.Design_Category, d.Design_Photo
    FROM sales s
    LEFT JOIN design d ON d.Design_ID = s.Payment_ID
    WHERE s.User_ID = ?
    ORDER BY s.Sales_Date DESC
    LIMIT 10
");
$stmt->bind_param("i", $User_ID);
$stmt->execute();
$r = $stmt->get_result();
while ($row = $r->fetch_assoc()) {
    $row['Design_Photo'] = normalizeForThis($row['Design_Photo'] ?? '');
    $recentSales[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Overview - Graphio</title>
    <link rel="stylesheet" href="sales.css">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
</head>
<body>
    <div class="page-wrapper">
        <!-- Header -->
        <header class="header">
            <div class="header-container">
                <div class="header-content">
                    <div class="header-left">
                        <div class="logo">
                            <a href="../index" class="logo-link">
                                <img class="graphio-logo" src="../logos/graphio_logo_blue.png" />
                            </a>
                        </div>
                    </div>
                    
                    <nav class="header-nav">
                        <a href="../designs" class="nav-link">Designs</a>
                        <a href="../about.html" class="nav-link">About</a>
                    </nav>
                    
                    <div class="header-right">
                        <div class="user-menu">
                            <div class="user-avatar">
                                <i data-lucide="user" class="avatar-icon"></i>
                            </div>
                            <div class="dropdown-menu">
                                <a href="../user/dashboard" class="dropdown-item">
                                    <i data-lucide="layout-dashboard" class="dropdown-icon"></i>
                                    Dashboard
                                </a>
                                <a href="../user/profile" class="dropdown-item">
                                    <i data-lucide="user" class="dropdown-icon"></i>
                                    Profile
                                </a>
                                <a href="../user_dashboard/account_settings" class="dropdown-item">
                                    <i data-lucide="settings" class="dropdown-icon"></i>
                                    Settings
                                </a>
                                <a href="../login" class="dropdown-item">
                                    <i data-lucide="log-out" class="dropdown-icon"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="container">
                <!-- Page Header -->
                <div class="page-header">
                    <div class="page-header-content">
                        <div class="page-header-left">
                            <h1 class="page-title">Sales Overview</h1>
                            <p class="page-subtitle">Track your design sales and earnings</p>
                        </div>
                        <div class="page-actions">
                            <a href="../user/dashboard" class="btn btn-outline">
                                <i data-lucide="arrow-left" class="icon-sm"></i>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sales Stats -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon total-sales">
                                <i data-lucide="dollar-sign" class="icon-md"></i>
                            </div>
                            <div class="stat-trend positive">
                                <i data-lucide="trending-up" class="icon-xs"></i>
                                <span></span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value"><?php echo $currencySymbol . number_format($totals['sum'], 2); ?></h3>
                            <p class="stat-label">Total Earnings</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon total-designs">
                                <i data-lucide="shopping-bag" class="icon-md"></i>
                            </div>
                            <div class="stat-trend positive">
                                <i data-lucide="trending-up" class="icon-xs"></i>
                                <span></span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value"><?php echo number_format($totals['count']); ?></h3>
                            <p class="stat-label">Total Sales</p>
                        </div>
                    </div>
                </div>

                <!-- Time Period Filter (static UI only) -->
                <div class="filters-section">
                    <div class="filter-group">
                        <label class="filter-label">Time Period:</label>
                        <div class="filter-buttons">
                            <button class="filter-btn active" data-period="7d">7 Days</button>
                            <button class="filter-btn" data-period="30d">30 Days</button>
                            <button class="filter-btn" data-period="90d">90 Days</button>
                            <button class="filter-btn" data-period="1y">1 Year</button>
                        </div>
                    </div>
                </div>

                <!-- Sales Chart (placeholder) -->
                <div class="chart-section">
                    <div class="section-card">
                        <div class="section-header">
                            <h2 class="section-title">Revenue Trend</h2>
                            <div class="section-actions">
                                <select class="chart-type-select">
                                    <option value="revenue">Revenue</option>
                                    <option value="sales">Sales Count</option>
                                </select>
                            </div>
                        </div>
                        <div class="chart-container">
                            <div class="chart-placeholder">
                                <i data-lucide="bar-chart-2" class="chart-icon"></i>
                                <p>Sales chart will be displayed here</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Sales -->
                <div class="sales-section">
                    <div class="section-card">
                        <div class="section-header">
                            <h2 class="section-title">Recent Sales</h2>
                        </div>
                        <div class="sales-table">
                            <div class="table-header">
                                <div class="table-row">
                                    <div class="table-cell header">Design</div>
                                    <div class="table-cell header">Date</div>
                                    <div class="table-cell header">Amount</div>
                                    <div class="table-cell header">Link</div>
                                </div>
                            </div>
                            <div class="table-body">
                                <?php if (empty($recentSales)): ?>
                                    <div class="table-row">
                                        <div class="table-cell" colspan="4" style="color:#6b7280;">No sales yet.</div>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($recentSales as $row): ?>
                                        <div class="table-row">
                                            <div class="table-cell">
                                                <div class="design-info">
                                                    <div class="design-thumbnail">
                                                        <?php if (!empty($row['Design_Photo'])): ?>
                                                            <img src="<?php echo htmlspecialchars($row['Design_Photo']); ?>" alt="" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                                        <?php else: ?>
                                                            <i data-lucide="image" class="thumbnail-icon"></i>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="design-details">
                                                        <span class="design-name"><?php echo htmlspecialchars($row['Design_Name'] ?? 'Design'); ?></span>
                                                        <span class="design-category"><?php echo htmlspecialchars($row['Design_Category'] ?? ''); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-cell">
                                                <span class="sale-date"><?php echo htmlspecialchars(date("M d, Y", strtotime($row['Sales_Date']))); ?></span>
                                                <span class="sale-time"><?php echo htmlspecialchars(date("h:i A", strtotime($row['Sales_Date']))); ?></span>
                                            </div>
                                            <div class="table-cell">
                                                <span class="sale-price"><?php echo $currencySymbol . number_format((float)$row['Sales_Amount'], 2); ?></span>
                                            </div>
                                            <div class="table-cell">
                                                <?php if (!empty($row['Payment_ID'])): ?>
                                                    <a class="btn btn-outline btn-sm" href="../view/view_design.php?id=<?php echo (int)$row['Payment_ID']; ?>">View</a>
                                                <?php else: ?>
                                                    <span style="color:#6b7280;">N/A</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });

        // (Optional) Hook up time period buttons later to filter by ?period=...
    </script>
</body>
</html>