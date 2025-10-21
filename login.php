<?php

session_start();
include("connections.php");

if(isset($_SESSION["User_ID"])) {
    header("Location: user/dashboard.php");
    exit(); 
} 


$User_Email = $User_Password = "";
$User_EmailErr = $User_PasswordErr = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(empty($_POST["User_Email"])) {
        $User_EmailErr = "Email is required!";
    } else {
        $User_Email = $_POST["User_Email"];
    }

    if(empty($_POST["User_Password"])) {
        $User_PasswordErr = "Password is required!";
    } else {
        $User_Password = $_POST["User_Password"];
    }

    if($User_Email && $User_Password) {
        $check_email = mysqli_query($connections, "SELECT * FROM user WHERE User_Email='$User_Email'");
        $check_email_row = mysqli_num_rows($check_email);

        if($check_email_row > 0) {
            while($row = mysqli_fetch_assoc($check_email)) {
                
                $User_ID = $row["User_ID"];

                $User_PasswordDB = $row["User_Password"];
                $User_Type = $row["User_Type"];

                if($User_Password == $User_PasswordDB) {

                    session_start();
                    $_SESSION["User_ID"] = $User_ID;

                    if($User_Type == "1") {
                        echo "<script>window.location.href='user/dashboard';</script>";
                    } else {
                        echo "<script>window.location.href='index';</script>";
                    }
                } else {
                    $User_PasswordErr = "Password is incorrect!";
                }
            }
        } else {
            $User_EmailErr = "Email is not registered!";
        }
    }
}
?>

<style>
.error {
    color: #f51010ff;
    font-family: "Poppins", sans-serif;
    font-size: 15px;
    margin-top: 5px;
    font-style: italic;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | graphio</title>
    <link rel="icon" type="image/jpg" sizes="30x30" href="logos/graphio.jpg">
    <link rel="stylesheet" href="login_styles.css">
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
                        <a href="index" class="logo-link">
                            <img class="graphio-logo" src="logos/graphio_logo_blue.png" />
                        </a>
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
                        <button class="btn btn-outline btn-sm active">Sign In</button>
                        <button class="btn btn-sm btn-gradient designer-btn">
                             <a href="signup" class="logo-link-white">Create a <i class="text-italic-gold"> graphio  </i> account</a>
                            </button>
                        
                        <!-- Mobile menu button -->
                        <button class="btn btn-ghost btn-sm mobile-menu">
                            <i data-lucide="menu" class="icon-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main class="main-content">
            <!-- Login Section -->
            <section class="login-section">
                <div class="container">
                    <div class="login-container">
                        <div class="login-card">
                            <!-- Left side - Welcome content -->
                            <div class="login-welcome">
                                <div class="welcome-content">
                                    <h1 class="welcome-title">Welcome Back to Graphio</h1>
                                    <p class="welcome-description">
                                        Sign in to access your account and discover amazing designs from talented creators worldwide.
                                    </p>
                                    
                                    <!-- Feature highlights -->
                                    <div class="feature-list">
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i data-lucide="palette" class="icon-sm"></i>
                                            </div>
                                            <span>Access thousands of designs</span>
                                        </div>
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i data-lucide="users" class="icon-sm"></i>
                                            </div>
                                            <span>Connect with top designers</span>
                                        </div>
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i data-lucide="download" class="icon-sm"></i>
                                            </div>
                                            <span>Download premium resources</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right side - Login form -->
                            <div class="login-form-container">
                                <div class="form-header">
                                    <h2 class="form-title">Sign In</h2>
                                    <p class="form-subtitle">Enter your credentials to access your account</p>
                                </div>

                                <form class="login-form" id="loginForm" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-container">
                                            <i data-lucide="mail" class="input-icon"></i>
                                            <input 
                                                type="email" 
                                                id="email" 
                                                name="User_Email" 
                                                class="form-input" 
                                                placeholder="Enter your email address"
                                                value="<?php echo $User_Email; ?>"
                                                required
                                            >
                                        </div>
                                        <span class="error"><?php echo $User_EmailErr; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="password" class="form-label">Password</label>
                                        <div class="input-container">
                                            <i data-lucide="lock" class="input-icon"></i>
                                            <input 
                                                type="password" 
                                                id="password" 
                                                name="User_Password" 
                                                class="form-input" 
                                                placeholder="Enter your password"
                                                required
                                            >
                                            <button type="button" class="password-toggle" id="passwordToggle">
                                                <i data-lucide="eye" class="icon-sm"></i>
                                            </button>
                                        </div>
                                        <span class="error"><?php echo $User_PasswordErr; ?></span>
                                    </div>

                                    <div class="form-options">
                                        <label class="checkbox-container">
                                            <input type="checkbox" id="remember" name="remember">
                                            <span class="checkmark"></span>
                                            <span class="checkbox-label">Remember me</span>
                                        </label>
                                        <a href="#" class="forgot-password">Forgot password?</a>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-full">
                                        <a href="" class="logo-link-white">Sign In</a>
                                        <i data-lucide="arrow-right" class="icon-sm"></i>
                                    </button>
                                <br>
                                </form>

                                <div class="signup-prompt">
                                    <p>Don't have an account? <a href="signup" class="signup-link">Sign up here</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
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

        // Password toggle functionality
        document.getElementById('passwordToggle').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const icon = this.querySelector('i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            
            // Reinitialize icons after changing the attribute
            lucide.createIcons();
        });

        
    </script>
</body>
</html>