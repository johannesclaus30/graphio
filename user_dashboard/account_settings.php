<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings - Graphio</title>
    <link rel="stylesheet" href="account_settings_styles.css">
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
                                <a href="account_settings" class="dropdown-item active">
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
                            <h1 class="page-title">Account Settings</h1>
                            <p class="page-subtitle">Manage your account information and preferences</p>
                        </div>
                        <div class="page-actions">
                            <a href="../user/dashboard" class="btn btn-outline">
                                <i data-lucide="arrow-left" class="icon-sm"></i>
                                Back to Dashboard
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Settings Navigation -->
                <div class="settings-layout">
                    <div class="settings-sidebar">
                        <nav class="settings-nav">
                            <button class="settings-nav-item active" data-section="personal" onclick="showSection('personal')">
                                <i data-lucide="user" class="nav-icon"></i>
                                Personal Information
                            </button>
                            <button class="settings-nav-item" data-section="security" onclick="showSection('security')">
                                <i data-lucide="shield" class="nav-icon"></i>
                                Security
                            </button>
                            <button class="settings-nav-item" data-section="social" onclick="showSection('social')">
                                <i data-lucide="link" class="nav-icon"></i>
                                Social Links
                            </button>
                            <button class="settings-nav-item" data-section="notifications" onclick="showSection('notifications')">
                                <i data-lucide="bell" class="nav-icon"></i>
                                Notifications
                            </button>
                            <button class="settings-nav-item" data-section="privacy" onclick="showSection('privacy')">
                                <i data-lucide="eye-off" class="nav-icon"></i>
                                Privacy
                            </button>
                        </nav>
                    </div>

                    <div class="settings-content">
                        <!-- Personal Information Section -->
                        <div class="settings-section active" id="personal-section">
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">Personal Information</h2>
                                    <p class="section-description">Update your personal details and contact information</p>
                                </div>
                                
                                <form class="settings-form" onsubmit="savePersonalInfo(event)">
                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="firstName" class="form-label">First Name *</label>
                                            <input 
                                                type="text" 
                                                id="firstName" 
                                                name="firstName" 
                                                class="form-input" 
                                                value="Alex"
                                                required
                                            >
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="lastName" class="form-label">Last Name *</label>
                                            <input 
                                                type="text" 
                                                id="lastName" 
                                                name="lastName" 
                                                class="form-input" 
                                                value="Johnson"
                                                required
                                            >
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Email Address *</label>
                                            <input 
                                                type="email" 
                                                id="email" 
                                                name="email" 
                                                class="form-input" 
                                                value="alex.johnson@email.com"
                                                required
                                            >
                                            <p class="field-help">This will be your login email and contact email for customers</p>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="location" class="form-label">Location</label>
                                            <input 
                                                type="text" 
                                                id="location" 
                                                name="location" 
                                                class="form-input" 
                                                value="San Francisco, CA"
                                                placeholder="City, State/Country"
                                            >
                                            <p class="field-help">This helps customers know your timezone and location</p>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group">
                                            <label for="bio" class="form-label">Bio</label>
                                            <textarea 
                                                id="bio" 
                                                name="bio" 
                                                class="form-textarea" 
                                                rows="4"
                                                placeholder="Tell customers about yourself and your design experience..."
                                            >Passionate graphic designer with 5+ years of experience creating stunning visual identities for businesses. Specialized in logo design, branding, and digital marketing materials.</textarea>
                                            <div class="character-counter">
                                                <span id="bio-count">178</span>/500 characters
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-gradient">
                                            <i data-lucide="save" class="icon-sm"></i>
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="settings-section" id="security-section">
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">Security Settings</h2>
                                    <p class="section-description">Manage your password and account security</p>
                                </div>
                                
                                <form class="settings-form" onsubmit="changePassword(event)">
                                    <div class="form-group">
                                        <label for="currentPassword" class="form-label">Current Password *</label>
                                        <div class="password-input-wrapper">
                                            <input 
                                                type="password" 
                                                id="currentPassword" 
                                                name="currentPassword" 
                                                class="form-input" 
                                                required
                                            >
                                            <button type="button" class="password-toggle" onclick="togglePassword('currentPassword')">
                                                <i data-lucide="eye" class="icon-sm"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="newPassword" class="form-label">New Password *</label>
                                        <div class="password-input-wrapper">
                                            <input 
                                                type="password" 
                                                id="newPassword" 
                                                name="newPassword" 
                                                class="form-input" 
                                                required
                                            >
                                            <button type="button" class="password-toggle" onclick="togglePassword('newPassword')">
                                                <i data-lucide="eye" class="icon-sm"></i>
                                            </button>
                                        </div>
                                        <div class="password-strength">
                                            <div class="strength-meter">
                                                <div class="strength-bar" id="strength-bar"></div>
                                            </div>
                                            <span class="strength-text" id="strength-text">Enter a password</span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="confirmPassword" class="form-label">Confirm New Password *</label>
                                        <div class="password-input-wrapper">
                                            <input 
                                                type="password" 
                                                id="confirmPassword" 
                                                name="confirmPassword" 
                                                class="form-input" 
                                                required
                                            >
                                            <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')">
                                                <i data-lucide="eye" class="icon-sm"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <div class="security-tips">
                                        <h4 class="tips-title">Password Requirements:</h4>
                                        <ul class="tips-list">
                                            <li>At least 8 characters long</li>
                                            <li>Include uppercase and lowercase letters</li>
                                            <li>Include at least one number</li>
                                            <li>Include at least one special character</li>
                                        </ul>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-gradient">
                                            <i data-lucide="shield-check" class="icon-sm"></i>
                                            Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Two-Factor Authentication -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h3 class="section-title">Two-Factor Authentication</h3>
                                    <p class="section-description">Add an extra layer of security to your account</p>
                                </div>
                                
                                <div class="feature-toggle">
                                    <div class="feature-info">
                                        <h4 class="feature-title">Enable 2FA</h4>
                                        <p class="feature-description">Secure your account with SMS or authenticator app verification</p>
                                    </div>
                                    <div class="toggle-wrapper">
                                        <label class="toggle-switch">
                                            <input type="checkbox" id="enable2fa">
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Social Links Section -->
                        <div class="settings-section" id="social-section">
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">Social Media Links</h2>
                                    <p class="section-description">Connect your social profiles to showcase your work</p>
                                </div>
                                
                                <form class="settings-form" onsubmit="saveSocialLinks(event)">
                                    <div class="social-links-grid">
                                        <div class="social-link-group">
                                            <label for="facebookUrl" class="social-label">
                                                <i data-lucide="facebook" class="social-icon facebook"></i>
                                                Facebook
                                            </label>
                                            <input 
                                                type="url" 
                                                id="facebookUrl" 
                                                name="facebookUrl" 
                                                class="form-input" 
                                                value="https://facebook.com/alexjohnsondesign"
                                                placeholder="https://facebook.com/yourprofile"
                                            >
                                        </div>

                                        <div class="social-link-group">
                                            <label for="instagramUrl" class="social-label">
                                                <i data-lucide="instagram" class="social-icon instagram"></i>
                                                Instagram
                                            </label>
                                            <input 
                                                type="url" 
                                                id="instagramUrl" 
                                                name="instagramUrl" 
                                                class="form-input" 
                                                value="https://instagram.com/alexjdesigns"
                                                placeholder="https://instagram.com/yourprofile"
                                            >
                                        </div>

                                        <div class="social-link-group">
                                            <label for="linkedinUrl" class="social-label">
                                                <i data-lucide="linkedin" class="social-icon linkedin"></i>
                                                LinkedIn
                                            </label>
                                            <input 
                                                type="url" 
                                                id="linkedinUrl" 
                                                name="linkedinUrl" 
                                                class="form-input" 
                                                value="https://linkedin.com/in/alexjohnson"
                                                placeholder="https://linkedin.com/in/yourprofile"
                                            >
                                        </div>
                                    </div>

                                    <div class="social-preview">
                                        <h4 class="preview-title">Profile Preview</h4>
                                        <div class="preview-card">
                                            <div class="preview-header">
                                                <div class="preview-avatar">
                                                    <i data-lucide="user" class="avatar-icon"></i>
                                                </div>
                                                <div class="preview-info">
                                                    <h5 class="preview-name">Alex Johnson</h5>
                                                    <p class="preview-location">San Francisco, CA</p>
                                                </div>
                                            </div>
                                            <div class="preview-social">
                                                <a href="#" class="preview-social-link facebook-link">
                                                    <i data-lucide="facebook" class="icon-sm"></i>
                                                </a>
                                                <a href="#" class="preview-social-link instagram-link">
                                                    <i data-lucide="instagram" class="icon-sm"></i>
                                                </a>
                                                <a href="#" class="preview-social-link linkedin-link">
                                                    <i data-lucide="linkedin" class="icon-sm"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-gradient">
                                            <i data-lucide="link" class="icon-sm"></i>
                                            Save Social Links
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Notifications Section -->
                        <div class="settings-section" id="notifications-section">
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">Notification Preferences</h2>
                                    <p class="section-description">Choose what notifications you want to receive</p>
                                </div>
                                
                                <div class="notifications-grid">
                                    <div class="notification-group">
                                        <h4 class="group-title">Sales & Orders</h4>
                                        <div class="notification-item">
                                            <div class="notification-info">
                                                <h5 class="notification-title">New Purchase</h5>
                                                <p class="notification-description">When someone buys your design</p>
                                            </div>
                                            <div class="notification-toggles">
                                                <label class="toggle-switch">
                                                    <input type="checkbox" checked>
                                                    <span class="toggle-slider"></span>
                                                </label>
                                                <span class="toggle-label">Email</span>
                                            </div>
                                        </div>

                                        <div class="notification-item">
                                            <div class="notification-info">
                                                <h5 class="notification-title">Payment Received</h5>
                                                <p class="notification-description">When payment is processed</p>
                                            </div>
                                            <div class="notification-toggles">
                                                <label class="toggle-switch">
                                                    <input type="checkbox" checked>
                                                    <span class="toggle-slider"></span>
                                                </label>
                                                <span class="toggle-label">Email</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="notification-group">
                                        <h4 class="group-title">Reviews & Feedback</h4>
                                        <div class="notification-item">
                                            <div class="notification-info">
                                                <h5 class="notification-title">New Review</h5>
                                                <p class="notification-description">When someone reviews your design</p>
                                            </div>
                                            <div class="notification-toggles">
                                                <label class="toggle-switch">
                                                    <input type="checkbox" checked>
                                                    <span class="toggle-slider"></span>
                                                </label>
                                                <span class="toggle-label">Email</span>
                                            </div>
                                        </div>

                                        <div class="notification-item">
                                            <div class="notification-info">
                                                <h5 class="notification-title">Review Response</h5>
                                                <p class="notification-description">When someone responds to your reply</p>
                                            </div>
                                            <div class="notification-toggles">
                                                <label class="toggle-switch">
                                                    <input type="checkbox">
                                                    <span class="toggle-slider"></span>
                                                </label>
                                                <span class="toggle-label">Email</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="notification-group">
                                        <h4 class="group-title">Marketing & Updates</h4>
                                        <div class="notification-item">
                                            <div class="notification-info">
                                                <h5 class="notification-title">Platform Updates</h5>
                                                <p class="notification-description">News and feature announcements</p>
                                            </div>
                                            <div class="notification-toggles">
                                                <label class="toggle-switch">
                                                    <input type="checkbox">
                                                    <span class="toggle-slider"></span>
                                                </label>
                                                <span class="toggle-label">Email</span>
                                            </div>
                                        </div>

                                        <div class="notification-item">
                                            <div class="notification-info">
                                                <h5 class="notification-title">Tips & Best Practices</h5>
                                                <p class="notification-description">Design tips and selling advice</p>
                                            </div>
                                            <div class="notification-toggles">
                                                <label class="toggle-switch">
                                                    <input type="checkbox" checked>
                                                    <span class="toggle-slider"></span>
                                                </label>
                                                <span class="toggle-label">Email</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button class="btn btn-gradient" onclick="saveNotificationSettings()">
                                        <i data-lucide="bell-ring" class="icon-sm"></i>
                                        Save Preferences
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Privacy Section -->
                        <div class="settings-section" id="privacy-section">
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">Privacy Settings</h2>
                                    <p class="section-description">Control your privacy and data sharing preferences</p>
                                </div>
                                
                                <div class="privacy-options">
                                    <div class="privacy-item">
                                        <div class="privacy-info">
                                            <h4 class="privacy-title">Profile Visibility</h4>
                                            <p class="privacy-description">Make your profile visible to other users</p>
                                        </div>
                                        <label class="toggle-switch">
                                            <input type="checkbox" checked>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>

                                    <div class="privacy-item">
                                        <div class="privacy-info">
                                            <h4 class="privacy-title">Show Location</h4>
                                            <p class="privacy-description">Display your location on your profile</p>
                                        </div>
                                        <label class="toggle-switch">
                                            <input type="checkbox" checked>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>

                                    <div class="privacy-item">
                                        <div class="privacy-info">
                                            <h4 class="privacy-title">Analytics Data</h4>
                                            <p class="privacy-description">Allow us to use your data to improve the platform</p>
                                        </div>
                                        <label class="toggle-switch">
                                            <input type="checkbox" checked>
                                            <span class="toggle-slider"></span>
                                        </label>
                                    </div>
                                </div>

                                <div class="danger-zone">
                                    <h4 class="danger-title">Danger Zone</h4>
                                    <div class="danger-actions">
                                        <button class="btn btn-danger-outline" onclick="downloadData()">
                                            <i data-lucide="download" class="icon-sm"></i>
                                            Download My Data
                                        </button>
                                        <button class="btn btn-danger" onclick="deleteAccount()">
                                            <i data-lucide="trash-2" class="icon-sm"></i>
                                            Delete Account
                                        </button>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button class="btn btn-gradient" onclick="savePrivacySettings()">
                                        <i data-lucide="shield" class="icon-sm"></i>
                                        Save Privacy Settings
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

    <script>
        // Initialize Lucide icons
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
            initializePage();
        });

        function initializePage() {
            // Character counter for bio
            const bioTextarea = document.getElementById('bio');
            const bioCounter = document.getElementById('bio-count');
            
            bioTextarea.addEventListener('input', function() {
                const count = this.value.length;
                bioCounter.textContent = count;
                
                if (count > 500) {
                    bioCounter.style.color = '#ef4444';
                } else if (count > 450) {
                    bioCounter.style.color = '#f59e0b';
                } else {
                    bioCounter.style.color = '#6b7280';
                }
            });

            // Password strength checker
            const newPasswordInput = document.getElementById('newPassword');
            newPasswordInput.addEventListener('input', checkPasswordStrength);

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

        function showSection(sectionName) {
            // Hide all sections
            const sections = document.querySelectorAll('.settings-section');
            sections.forEach(section => section.classList.remove('active'));
            
            // Remove active class from all nav items
            const navItems = document.querySelectorAll('.settings-nav-item');
            navItems.forEach(item => item.classList.remove('active'));
            
            // Show selected section
            document.getElementById(sectionName + '-section').classList.add('active');
            
            // Add active class to clicked nav item
            document.querySelector(`[data-section="${sectionName}"]`).classList.add('active');
        }

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            
            lucide.createIcons();
        }

        function checkPasswordStrength() {
            const password = document.getElementById('newPassword').value;
            const strengthBar = document.getElementById('strength-bar');
            const strengthText = document.getElementById('strength-text');
            
            let strength = 0;
            let text = 'Weak';
            let color = '#ef4444';
            
            if (password.length >= 8) strength++;
            if (/[a-z]/.test(password)) strength++;
            if (/[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^A-Za-z0-9]/.test(password)) strength++;
            
            if (strength >= 4) {
                text = 'Strong';
                color = '#10b981';
            } else if (strength >= 3) {
                text = 'Medium';
                color = '#f59e0b';
            }
            
            strengthBar.style.width = (strength * 20) + '%';
            strengthBar.style.backgroundColor = color;
            strengthText.textContent = text;
            strengthText.style.color = color;
        }

        function savePersonalInfo(event) {
            event.preventDefault();
            alert('Personal information saved successfully!');
        }

        function changePassword(event) {
            event.preventDefault();
            
            const newPassword = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            if (newPassword !== confirmPassword) {
                alert('New passwords do not match!');
                return;
            }
            
            alert('Password updated successfully!');
        }

        function saveSocialLinks(event) {
            event.preventDefault();
            alert('Social links saved successfully!');
        }

        function saveNotificationSettings() {
            alert('Notification preferences saved successfully!');
        }

        function savePrivacySettings() {
            alert('Privacy settings saved successfully!');
        }

        function downloadData() {
            if (confirm('Are you sure you want to download all your data? This may take a few minutes.')) {
                alert('Data download initiated. You will receive an email when your data is ready.');
            }
        }

        function deleteAccount() {
            if (confirm('Are you sure you want to delete your account? This action cannot be undone and you will lose all your designs, sales, and data.')) {
                if (confirm('This is your final warning. Are you absolutely sure you want to permanently delete your account?')) {
                    alert('Account deletion initiated. You will receive a confirmation email.');
                }
            }
        }
    </script>
</body>
</html>