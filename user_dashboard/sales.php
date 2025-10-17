<?php

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
                        <a href="../careers" class="nav-link">Careers</a>
                        <a href="../artists" class="nav-link">Artists</a>
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
                                <span>+12.5%</span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">$3,245</h3>
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
                                <span>+8.2%</span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">127</h3>
                            <p class="stat-label">Total Sales</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon avg-price">
                                <i data-lucide="bar-chart-3" class="icon-md"></i>
                            </div>
                            <div class="stat-trend positive">
                                <i data-lucide="trending-up" class="icon-xs"></i>
                                <span>+3.8%</span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">$25.55</h3>
                            <p class="stat-label">Average Price</p>
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-header">
                            <div class="stat-icon conversion">
                                <i data-lucide="target" class="icon-md"></i>
                            </div>
                            <div class="stat-trend negative">
                                <i data-lucide="trending-down" class="icon-xs"></i>
                                <span>-2.1%</span>
                            </div>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-value">4.8%</h3>
                            <p class="stat-label">Conversion Rate</p>
                        </div>
                    </div>
                </div>

                <!-- Time Period Filter -->
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

                <!-- Sales Chart -->
                <div class="chart-section">
                    <div class="section-card">
                        <div class="section-header">
                            <h2 class="section-title">Revenue Trend</h2>
                            <div class="section-actions">
                                <select class="chart-type-select">
                                    <option value="revenue">Revenue</option>
                                    <option value="sales">Sales Count</option>
                                    <option value="conversion">Conversion Rate</option>
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
                            <a href="#" class="section-link">View All</a>
                        </div>
                        <div class="sales-table">
                            <div class="table-header">
                                <div class="table-row">
                                    <div class="table-cell header">Design</div>
                                    <div class="table-cell header">Customer</div>
                                    <div class="table-cell header">Date</div>
                                    <div class="table-cell header">Price</div>
                                    <div class="table-cell header">Status</div>
                                </div>
                            </div>
                            <div class="table-body">
                                <div class="table-row">
                                    <div class="table-cell">
                                        <div class="design-info">
                                            <div class="design-thumbnail">
                                                <i data-lucide="image" class="thumbnail-icon"></i>
                                            </div>
                                            <div class="design-details">
                                                <span class="design-name">Modern Logo Pack</span>
                                                <span class="design-category">Logo Design</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-cell">
                                        <div class="customer-info">
                                            <span class="customer-name">Sarah Johnson</span>
                                            <span class="customer-email">sarah.j@email.com</span>
                                        </div>
                                    </div>
                                    <div class="table-cell">
                                        <span class="sale-date">Dec 15, 2024</span>
                                        <span class="sale-time">2:30 PM</span>
                                    </div>
                                    <div class="table-cell">
                                        <span class="sale-price">$45.00</span>
                                    </div>
                                    <div class="table-cell">
                                        <span class="status-badge completed">Completed</span>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell">
                                        <div class="design-info">
                                            <div class="design-thumbnail">
                                                <i data-lucide="image" class="thumbnail-icon"></i>
                                            </div>
                                            <div class="design-details">
                                                <span class="design-name">Business Card Template</span>
                                                <span class="design-category">Print Design</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-cell">
                                        <div class="customer-info">
                                            <span class="customer-name">Mike Chen</span>
                                            <span class="customer-email">mike.chen@company.com</span>
                                        </div>
                                    </div>
                                    <div class="table-cell">
                                        <span class="sale-date">Dec 14, 2024</span>
                                        <span class="sale-time">4:15 PM</span>
                                    </div>
                                    <div class="table-cell">
                                        <span class="sale-price">$25.00</span>
                                    </div>
                                    <div class="table-cell">
                                        <span class="status-badge completed">Completed</span>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell">
                                        <div class="design-info">
                                            <div class="design-thumbnail">
                                                <i data-lucide="image" class="thumbnail-icon"></i>
                                            </div>
                                            <div class="design-details">
                                                <span class="design-name">Social Media Kit</span>
                                                <span class="design-category">Social Media</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-cell">
                                        <div class="customer-info">
                                            <span class="customer-name">Emily Rodriguez</span>
                                            <span class="customer-email">emily.r@startup.io</span>
                                        </div>
                                    </div>
                                    <div class="table-cell">
                                        <span class="sale-date">Dec 13, 2024</span>
                                        <span class="sale-time">11:45 AM</span>
                                    </div>
                                    <div class="table-cell">
                                        <span class="sale-price">$35.00</span>
                                    </div>
                                    <div class="table-cell">
                                        <span class="status-badge processing">Processing</span>
                                    </div>
                                </div>

                                <div class="table-row">
                                    <div class="table-cell">
                                        <div class="design-info">
                                            <div class="design-thumbnail">
                                                <i data-lucide="image" class="thumbnail-icon"></i>
                                            </div>
                                            <div class="design-details">
                                                <span class="design-name">Website Mockup</span>
                                                <span class="design-category">Web Design</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-cell">
                                        <div class="customer-info">
                                            <span class="customer-name">David Park</span>
                                            <span class="customer-email">david.park@agency.com</span>
                                        </div>
                                    </div>
                                    <div class="table-cell">
                                        <span class="sale-date">Dec 12, 2024</span>
                                        <span class="sale-time">9:20 AM</span>
                                    </div>
                                    <div class="table-cell">
                                        <span class="sale-price">$75.00</span>
                                    </div>
                                    <div class="table-cell">
                                        <span class="status-badge completed">Completed</span>
                                    </div>
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

    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            initializePage();
        });

        function initializePage() {
            // Filter button functionality
            const filterButtons = document.querySelectorAll('.filter-btn');
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    updateSalesData(this.dataset.period);
                });
            });

            // Chart type selector
            const chartSelect = document.querySelector('.chart-type-select');
            chartSelect.addEventListener('change', function() {
                updateChartType(this.value);
            });

            // User menu dropdown
            const userMenu = document.querySelector('.user-menu');
            const userAvatar = document.querySelector('.user-avatar');
            const dropdownMenu = document.querySelector('.dropdown-menu');

            userAvatar.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });

            document.addEventListener('click', function() {
                dropdownMenu.classList.remove('show');
            });
        }

        function updateSalesData(period) {
            // Simulate data update based on time period
            console.log('Updating sales data for period:', period);
            // In a real app, this would fetch new data from the API
        }

        function updateChartType(type) {
            // Simulate chart type change
            console.log('Updating chart type to:', type);
            // In a real app, this would update the chart visualization
        }

        function exportSalesData() {
            alert('Sales data export functionality would be implemented here');
        }
    </script>
</body>
</html>