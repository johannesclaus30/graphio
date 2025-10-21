<?php

include("connections.php");

$User_FirstName = $User_LastName = $User_Email = $User_Password = $User_ConfirmPassword = $User_Type = "";
$User_FirstNameErr = $User_LastNameErr = $User_EmailErr = $User_PasswordErr = $User_ConfirmPasswordErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["User_FirstName"])) {
        $User_FirstNameErr = "First Name is required!";
    } else {
        $User_FirstName = $_POST["User_FirstName"];
    }

    if (empty($_POST["User_LastName"])) {
        $User_LastNameErr = "Last Name is required!";
    } else {
        $User_LastName = $_POST["User_LastName"];
    }

    if (empty($_POST["User_Email"])) {
        $User_EmailErr = "Email is required!";
    } else {
        $User_Email = $_POST["User_Email"];
    }

    if (empty($_POST["User_Password"])) {
        $User_PasswordErr = "Password is required!";
    } else {
        $User_Password = $_POST["User_Password"];
    }

    if (empty($_POST["User_ConfirmPassword"])) {
        $User_ConfirmPasswordErr = "Confirm Password is required!";
    } else {
        $User_ConfirmPassword = $_POST["User_ConfirmPassword"];
    }

    $default_ProfilePic = "../media/default_user_photo.jpg";
    $default_CoverPhoto = "../media/default_user_cover_photo.jpg";

    if ($User_FirstName && $User_LastName && $User_Email && $User_Password && $User_ConfirmPassword) {
        $check_email = mysqli_query($connections, "SELECT * FROM user WHERE User_Email='$User_Email'");
        $check_email_row = mysqli_num_rows($check_email);

        if($check_email_row > 0) {
            $User_EmailErr = "Email is already registered!";
        } else if ($User_Password != $User_ConfirmPassword) {
            $User_ConfirmPasswordErr = "Password did not match!";
        } else {
            $query = mysqli_query($connections, "INSERT INTO user (User_FirstName, User_LastName, User_Email, User_Password, User_Photo, User_CoverPhoto, User_Type) VALUES ('$User_FirstName','$User_LastName','$User_Email','$User_Password','$default_ProfilePic','$default_CoverPhoto','1')");

            echo "<script language='javascript'>alert('New Record has been inserted!')</script>";
            echo "<script>window.location.href='login.php';</script>";
        }
    }
}

?>

<style>
.error {
    font-family: "Poppins", sans-serif;
    font-size: 15px;
    color: #fafafa;
    margin-top: 5px;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Graphio</title>
    <link rel="icon" type="image/jpg" sizes="30x30" href="logos/graphio.jpg">
    <link rel="stylesheet" href="signup.css">
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
                            <i data-lucide="menu" class="icon-sm"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main class="main-content">
            <!-- Signup Section -->
            <section class="signup-section">
                <div class="container">
                    <div class="signup-container">
                        <div class="signup-card">
                            <!-- Left side - Welcome content -->
                            <div class="signup-welcome">
                                <div class="welcome-content">
                                    <h1 class="welcome-title">Join graphio's Creative Community</h1>
                                    <p class="welcome-description">
                                        Create your Graphio account and start showcasing your designs or finding the perfect creative solutions for your projects.
                                    </p>
                                    
                                    <!-- Feature highlights -->
                                    <div class="feature-list">
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i data-lucide="upload" class="icon-sm"></i>
                                            </div>
                                            <span>Upload and sell your designs</span>
                                        </div>
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i data-lucide="globe" class="icon-sm"></i>
                                            </div>
                                            <span>Reach clients worldwide</span>
                                        </div>
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i data-lucide="trending-up" class="icon-sm"></i>
                                            </div>
                                            <span>Build your creative business</span>
                                        </div>
                                        <div class="feature-item">
                                            <div class="feature-icon">
                                                <i data-lucide="shield-check" class="icon-sm"></i>
                                            </div>
                                            <span>Secure payment processing</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right side - Signup form -->
                            <div class="signup-form-container">
                                <div class="form-header">
                                    <h2 class="form-title">Create Account</h2>
                                    <p class="form-subtitle">Join the graphio community!</p>
                                </div>

                                <form class="signup-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

                                    <div class="form-group">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <div class="input-container">
                                            <i data-lucide="user" class="input-icon"></i>
                                            <input 
                                                type="text" 
                                                id="firstName" 
                                                name="User_FirstName" 
                                                class="form-input" 
                                                placeholder="Enter your first name"
                                                value="<?php echo $User_FirstName; ?>"
                                                required
                                            >
                                            <span class="error"><?php echo $User_FirstNameErr; ?></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <div class="input-container">
                                            <i data-lucide="user" class="input-icon"></i>
                                            <input 
                                                type="text" 
                                                id="lastName" 
                                                name="User_LastName" 
                                                class="form-input" 
                                                placeholder="Enter your last name"
                                                value="<?php echo $User_LastName; ?>"
                                                required
                                            >
                                            <span class="error"><?php echo $User_LastNameErr; ?></span>
                                        </div>
                                    </div>

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
                                            <span class="error"><?php echo $User_EmailErr; ?></span>
                                        </div>
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
                                                placeholder="Create a strong password"
                                                value="<?php echo $User_Password; ?>"
                                                required
                                            >
                                            <span class="error"><?php echo $User_PasswordErr; ?></span>
                                            <button type="button" class="password-toggle" id="passwordToggle">
                                                <i data-lucide="eye" class="icon-sm"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength" id="passwordStrength">
                                            <div class="strength-bar">
                                                <div class="strength-fill" id="strengthFill"></div>
                                            </div>
                                            <span class="strength-text" id="strengthText">Password strength</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                                        <div class="input-container">
                                            <i data-lucide="lock" class="input-icon"></i>
                                            <input 
                                                type="password" 
                                                id="confirmPassword" 
                                                name="User_ConfirmPassword" 
                                                class="form-input" 
                                                placeholder="Confirm your password"
                                                value="<?php echo $User_ConfirmPassword; ?>"
                                                required
                                            >
                                            <span class="error"><?php echo $User_ConfirmPasswordErr; ?></span>
                                            <button type="button" class="password-toggle" id="confirmPasswordToggle">
                                                <i data-lucide="eye" class="icon-sm"></i>
                                            </button>
                                        </div>
                                        <div class="password-match" id="passwordMatch"></div>
                                    </div>

                                    <div class="form-options">
                                        <label class="checkbox-container">
                                            <input type="checkbox" id="terms" name="terms" required>
                                            <span class="checkmark"></span>
                                            <span class="checkbox-label">I agree to the <a href="#" class="terms-link">Terms of Service</a> and <a href="#" class="terms-link">Privacy Policy</a></span>
                                        </label>
                                        
                                        <label class="checkbox-container">
                                            <input type="checkbox" id="newsletter" name="newsletter">
                                            <span class="checkmark"></span>
                                            <span class="checkbox-label">Subscribe to our newsletter for design tips and updates</span>
                                        </label>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-full">
                                        Create Account
                                        <i data-lucide="arrow-right" class="icon-sm"></i>
                                    </button>
                                <br>
                                </form>

                                <div class="login-prompt">
                                    <p>Already have an account? <a href="login" class="login-link">Sign in here</a></p>
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
        function setupPasswordToggle(inputId, toggleId) {
            document.getElementById(toggleId).addEventListener('click', function() {
                const passwordInput = document.getElementById(inputId);
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
        }

        setupPasswordToggle('password', 'passwordToggle');
        setupPasswordToggle('confirmPassword', 'confirmPasswordToggle');

        // Password strength checker
        function checkPasswordStrength(password) {
            let strength = 0;
            let feedback = [];

            if (password.length >= 8) strength++;
            else feedback.push('At least 8 characters');

            if (/[a-z]/.test(password)) strength++;
            else feedback.push('Lowercase letter');

            if (/[A-Z]/.test(password)) strength++;
            else feedback.push('Uppercase letter');

            if (/[0-9]/.test(password)) strength++;
            else feedback.push('Number');

            if (/[^A-Za-z0-9]/.test(password)) strength++;
            else feedback.push('Special character');

            return { strength, feedback };
        }

        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const { strength, feedback } = checkPasswordStrength(password);
            const strengthFill = document.getElementById('strengthFill');
            const strengthText = document.getElementById('strengthText');

            const strengthLevels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
            const strengthColors = ['#ef4444', '#f59e0b', '#eab308', '#22c55e', '#16a34a'];

            if (password.length === 0) {
                strengthFill.style.width = '0%';
                strengthText.textContent = 'Password strength';
                strengthFill.style.backgroundColor = '#e5e7eb';
            } else {
                const percentage = (strength / 5) * 100;
                strengthFill.style.width = percentage + '%';
                strengthFill.style.backgroundColor = strengthColors[strength - 1] || strengthColors[0];
                strengthText.textContent = strengthLevels[strength - 1] || strengthLevels[0];
            }
        });

        // Password match checker
        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const matchDiv = document.getElementById('passwordMatch');

            if (confirmPassword.length === 0) {
                matchDiv.textContent = '';
                matchDiv.className = 'password-match';
                return;
            }

            if (password === confirmPassword) {
                matchDiv.textContent = 'Passwords match';
                matchDiv.className = 'password-match success';
            } else {
                matchDiv.textContent = 'Passwords do not match';
                matchDiv.className = 'password-match error';
            }
        }

        document.getElementById('password').addEventListener('input', checkPasswordMatch);
        document.getElementById('confirmPassword').addEventListener('input', checkPasswordMatch);

        // Form submission handling
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const fullName = document.getElementById('fullName').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const terms = document.getElementById('terms').checked;
            const newsletter = document.getElementById('newsletter').checked;

            // Validation
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }

            if (!terms) {
                alert('Please accept the Terms of Service and Privacy Policy to continue.');
                return;
            }

            const { strength } = checkPasswordStrength(password);
            if (strength < 3) {
                alert('Please choose a stronger password for better security.');
                return;
            }
            
            // // Here you would typically send the data to your backend
            // console.log('Signup attempt:', { fullName, email, password, newsletter, terms });
            
            // // For demo purposes, show an alert
            // alert('Account created successfully! Check console for form data.');
        });
    </script>
</body>
</html>