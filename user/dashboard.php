<?php

session_start();
include("../connections.php");

if(isset($_SESSION["User_ID"])) {
    $User_ID = $_SESSION["User_ID"];

    $get_record = mysqli_query($connections, "SELECT * FROM user WHERE User_ID='$User_ID'");
    while($row_edit = mysqli_fetch_assoc($get_record)) {
        $User_FirstName = $row_edit["User_FirstName"];
        $User_LastName = $row_edit["User_LastName"];
        $User_Email = $row_edit["User_Email"];

        // Generate initials
        $first_initial = !empty($User_FirstName) ? strtoupper(substr(trim($User_FirstName), 0, 1)) : "";
        $last_initial = !empty($User_LastName) ? strtoupper(substr(trim($User_LastName), 0, 1)) : "";
        $User_Initials = $first_initial . ($last_initial ? "" . $last_initial . "" : "");
    } 
} else {
    header("Location: ../login.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Graphio</title>
    <link rel="icon" type="image/jpg" sizes="30x30" href="logos/graphio.jpg">
    <link rel="stylesheet" href="dashboard.css">
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
                    <div class="header-left">
                        <h1 class="dashboard-title">Dashboard</h1>
                        <span class="user-badge">Pro Designer</span>
                    </div>
                    <div class="header-right">
                        <!-- <button class="btn btn-ghost btn-sm notification-btn">
                            <i data-lucide="bell" class="icon-sm"></i>
                        </button> -->
                        <div class="user-avatar">
                            <a href="profile" class="logo-link-white"><span class="avatar-text"><?php echo htmlspecialchars($User_Initials); ?></span></a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main class="main-content">
            <div class="container">
                <!-- Welcome Section -->
                <section class="welcome-section">
                    <div class="welcome-card">
                        <div class="welcome-content">
                            <div class="welcome-text">
                                <h2 class="welcome-title">Welcome back, <?php echo $User_FirstName; ?>!</h2>
                                <p class="welcome-description">
                                    Ready to showcase your creativity and grow your design business?
                                </p>
                                <div class="welcome-meta">
                                    <span class="meta-item">Member since March 2023</span>
                                    <div class="meta-separator"></div>
                                    <span class="meta-item rating">
                                        <i data-lucide="star" class="icon-sm star-filled"></i>
                                        4.8 rating
                                    </span>
                                </div>
                            </div>
                            <div class="welcome-actions">
                                <button class="btn btn-primary">
                                    <i data-lucide="plus" class="icon-sm"></i>
                                    <a href="../user_dashboard/add_design" class="logo-link-white">Upload New Design</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Quick Stats -->
                <section class="stats-section">
                    <div class="stats-grid">
                        <div class="stat-card">
                            <div class="stat-content">
                                <div class="stat-text">
                                    <p class="stat-label">Total Designs</p>
                                    <p class="stat-value">47</p>
                                </div>
                                <div class="stat-icon purple">
                                    <i data-lucide="palette" class="icon-md"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-content">
                                <div class="stat-text">
                                    <p class="stat-label">Subscription Status</p>
                                    <p class="stat-value">Active</p>
                                </div>
                                <div class="stat-icon blue">
                                    <i data-lucide="check" class="icon-md"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-content">
                                <div class="stat-text">
                                    <p class="stat-label">Downloads</p>
                                    <p class="stat-value">2,834</p>
                                </div>
                                <div class="stat-icon green">
                                    <i data-lucide="download" class="icon-md"></i>
                                </div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-content">
                                <div class="stat-text">
                                    <p class="stat-label">Earnings</p>
                                    <p class="stat-value">$4,750</p>
                                </div>
                                <div class="stat-icon yellow">
                                    <i data-lucide="wallet" class="icon-md"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main Actions -->
                <section class="actions-section">
                    <div class="actions-grid">
                        <!-- Showcase Designs -->
                        <div class="action-card" onclick="">
                            <a href="../user_dashboard/add_design" class="logo-link-white">
                            <div class="card-header">
                                <div class="card-header-top">
                                    <div class="card-icon purple">
                                        <i data-lucide="palette" class="icon-md"></i>
                                    </div>
                                    <i data-lucide="arrow-right" class="arrow-icon"></i>
                                </div>
                                <h3 class="card-title">Showcase Designs</h3>
                                <p class="card-description">
                                    Upload, manage, and showcase your creative portfolio to the world
                                </p>
                            </div>
                            <div class="card-content">
                                <div class="card-stats">
                                    <button class="btn btn-full btn-purple">
                                        Upload New Design
                                    </button>
                                </div>
                            </div>
                            </a>
                        </div>

                        <!-- Hire Designers -->
                        <div class="action-card" onclick="">
                            <a href="login_business" class="logo-link-white">
                            <div class="card-header">
                                <div class="card-header-top">
                                    <div class="card-icon blue">
                                        <i data-lucide="users" class="icon-md"></i>
                                    </div>
                                    <i data-lucide="arrow-right" class="arrow-icon"></i>
                                </div>
                                <h3 class="card-title">Hire Designers</h3>
                                <p class="card-description">
                                    Browse talented designers and collaborate on your next project
                                </p>
                            </div>
                            <div class="card-content">
                                <div class="card-stats">
                                    <button class="btn btn-full btn-blue">
                                        Go to Graphio for Business
                                    </button>
                                </div>
                            </div>
                            </a>
                        </div>

                        <!-- My Graphiofolio -->
                        <div class="action-card" onclick="">
                            <a href="profile" class="logo-link-white">
                            <div class="card-header">
                                <div class="card-header-top">
                                    <div class="card-icon indigo">
                                        <i data-lucide="folder-open" class="icon-md"></i>
                                    </div>
                                    <i data-lucide="arrow-right" class="arrow-icon"></i>
                                </div>
                                <h3 class="card-title">My Graphiofolio</h3>
                                <p class="card-description">
                                    Your personalized online portfolio showcasing your best work
                                </p>
                            </div>
                            <div class="card-content">
                                <div class="card-stats">
                                    <button class="btn btn-full btn-indigo">
                                        View Portfolio
                                    </button>
                                </div>
                            </div>
                            </a>
                        </div>

                        <!-- Sales -->
                        <div class="action-card" onclick="">
                            <a href="../user_dashboard/sales" class="logo-link-white">
                            <div class="card-header">
                                <div class="card-header-top">
                                    <div class="card-icon green">
                                        <i data-lucide="bar-chart-3" class="icon-md"></i>
                                    </div>
                                    <i data-lucide="arrow-right" class="arrow-icon"></i>
                                </div>
                                <h3 class="card-title">Sales & Graphio Wallet</h3>
                                <p class="card-description">
                                    Track your earnings, sales analytics, and financial performance
                                </p>
                            </div>
                            <div class="card-content">
                                <div class="card-stats">
                                    <div class="stat-row">
                                        <span class="stat-name">This Month</span>
                                        <span class="stat-number positive">+$1,240</span>
                                    </div>
                                    <button class="btn btn-full btn-green">
                                        View Analytics
                                    </button>
                                </div>
                            </div>
                            </a>
                        </div>

                        <!-- Reviews -->
                        <div class="action-card" onclick="">
                            <a href="../user_dashboard/reviews" class="logo-link-white">
                            <div class="card-header">
                                <div class="card-header-top">
                                    <div class="card-icon yellow">
                                        <i data-lucide="message-square" class="icon-md"></i>
                                    </div>
                                    <i data-lucide="arrow-right" class="arrow-icon"></i>
                                </div>
                                <h3 class="card-title">Reviews</h3>
                                <p class="card-description">
                                    Manage feedback, testimonials, and client communications
                                </p>
                            </div>
                            <div class="card-content">
                                <div class="card-stats">
                                    <div class="stat-row">
                                        <span class="stat-name">Average Rating</span>
                                        <span class="stat-number rating-display">
                                            <i data-lucide="star" class="icon-xs star-filled"></i>
                                            4.8
                                        </span>
                                    </div>
                                    <button class="btn btn-full btn-yellow">
                                        Manage Reviews
                                    </button>
                                </div>
                            </div>
                            </a>
                        </div>

                        <!-- Account Settings -->
                        <div class="action-card" onclick="">
                            <a href="../user_dashboard/account_settings" class="logo-link-white">
                            <div class="card-header">
                                <div class="card-header-top">
                                    <div class="card-icon gray">
                                        <i data-lucide="settings" class="icon-md"></i>
                                    </div>
                                    <i data-lucide="arrow-right" class="arrow-icon"></i>
                                </div>
                                <h3 class="card-title">Account Settings</h3>
                                <p class="card-description">
                                    Manage your profile, preferences, and account security
                                </p>
                            </div>
                            <div class="card-content">
                                <div class="card-stats">
                                    <div class="stat-row">
                                        <span class="stat-name">Security Score</span>
                                        <span class="stat-number positive">Strong</span>
                                    </div>
                                    <button class="btn btn-full btn-gray">
                                        Account Settings
                                    </button>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </section>

                
            </div>
        </main>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Navigation function
        function navigateTo(section) {
            console.log('Navigating to:', section);
            // Here you would implement actual navigation
            // For demo, we'll just show an alert
            const sectionNames = {
                'showcase': 'Showcase Designs',
                'hire': 'Hire Designers', 
                'portfolio': 'My Graphiofolio',
                'sales': 'Sales Analytics',
                'reviews': 'Reviews Management',
                'settings': 'Account Settings'
            };
            
            alert(`Navigating to ${sectionNames[section] || section}`);
        }

        // Notification button functionality
        document.querySelector('.notification-btn').addEventListener('click', function() {
            alert('You have 3 new notifications!');
        });

        // Add hover effects to cards
        document.querySelectorAll('.action-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
                this.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';
            });
        });

        // Add click animation to buttons
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', function(e) {
                // Create ripple effect
                const ripple = document.createElement('span');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.height, rect.width);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;
                
                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
                ripple.classList.add('ripple');
                
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    </script>
</body>
</html>