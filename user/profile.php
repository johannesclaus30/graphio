<?php

session_start();

    $User_Email = $User_ContactNo = $User_Photo = $User_CoverPhoto = $User_Bio = $User_Introduction = $User_Skills = "";
    $User_EmailErr = $User_ContactNoErr = $User_PhotoErr = $User_CoverPhotoErr = $User_BioErr = $User_IntroductionErr = $User_SkillsErr = "";


if(isset($_SESSION["User_ID"])) {
    $User_ID = $_SESSION["User_ID"];
    include("../connections.php");

    $get_record = mysqli_query($connections, "SELECT * FROM user WHERE User_ID='$User_ID'");
    while($row_edit = mysqli_fetch_assoc($get_record)) {
        $User_FirstName = $row_edit["User_FirstName"];
        $User_LastName = $row_edit["User_LastName"];
        $User_Email = $row_edit["User_Email"];
        $User_ContactNo = $row_edit["User_ContactNo"];
        $User_Photo = $row_edit["User_Photo"];
        $User_CoverPhoto = $row_edit["User_CoverPhoto"];
        $User_Bio = $row_edit["User_Bio"];
        $User_Introduction = $row_edit["User_Introduction"];
        $User_Skills = $row_edit["User_Skills"];
    }
}

// Prepare phone number display value
$Phone_Display = empty($User_ContactNo) ? "Set Phone Number" : htmlspecialchars($User_ContactNo);


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Graphio</title>
    <link rel="stylesheet" href="profile.css">
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
                        <a href="dashboard.html" class="btn btn-outline btn-sm">Dashboard</a>
                        <div class="profile-menu">
                            <button class="profile-avatar active" onclick="toggleDropdown()">
                                <img src="../media/default_user_photo.jpg" alt="Profile" class="avatar-img">
                            </button>
                            <div class="dropdown-menu" id="profileDropdown">
                                <a href="account_settings.html" class="dropdown-item">
                                    <i data-lucide="settings" class="dropdown-icon"></i>
                                    Account Settings
                                </a>
                                <a href="login.html" class="dropdown-item">
                                    <i data-lucide="log-out" class="dropdown-icon"></i>
                                    Logout
                                </a>
                            </div>
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
            <!-- Profile Cover & Header -->
            <section class="profile-cover">
                <div class="cover-image">
                    <img src="../media/default_user_cover_photo.jpg" alt="Cover" class="cover-img">
                    <div class="cover-overlay"></div>
                    <button class="cover-edit-btn" onclick="openCoverUpload()">
                        <i data-lucide="camera" class="icon-sm"></i>
                        Edit Cover
                    </button>
                </div>
                
                <div class="container">
                    <div class="profile-header-content">
                        <div class="profile-avatar-container">
                            <div class="profile-avatar-large">
                                <img src="../media/default_user_photo.jpg" alt="User Photo" class="avatar-img">
                            </div>
                            <button class="avatar-edit-btn" onclick="openImageUpload()">
                                    <i data-lucide="camera" class="icon-sm"></i>
                                </button>
                        </div>
                        
                        <div class="profile-info">
                            <h1 class="profile-name"><?php echo htmlspecialchars($User_FirstName . " " . $User_LastName); ?></h1>
                            <p class="profile-title">Senior Brand Designer</p>
                            <div class="profile-contact">
                                <div class="contact-item">
                                    <i data-lucide="phone" class="icon-sm"></i>
                                    <span><?php echo $Phone_Display; ?></span>
                                </div>
                                <div class="contact-item">
                                    <i data-lucide="mail" class="icon-sm"></i>
                                    <span><?php echo htmlspecialchars($User_Email); ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="profile-actions">
                            
                            <button class="btn btn-gradient">
                                <i data-lucide="settings-2" class="icon-sm"></i>
                                Account Settings
                            </button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Profile Content -->
            <section class="profile-content">
                <div class="container">
                    <div class="profile-layout">
                        <!-- Main Content -->
                        <div class="profile-main">
                            <!-- Bio Section -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">
                                        <i data-lucide="user" class="section-icon"></i>
                                        Bio
                                    </h2>
                                    <button class="edit-btn hidden" onclick="editSection('bio')">
                                        <i data-lucide="edit-2" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="editable-content" id="bio-content">
                                    <p class="bio-text">
                                        Passionate brand designer with 8+ years of experience creating memorable visual identities for startups and Fortune 500 companies. I specialize in logo design, brand strategy, and comprehensive brand guidelines that help businesses stand out in competitive markets.
                                    </p>
                                </div>
                            </div>

                            <!-- Skills Section -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">
                                        <i data-lucide="zap" class="section-icon"></i>
                                        Skills & Expertise
                                    </h2>
                                    <button class="edit-btn hidden" onclick="editSection('skills')">
                                        <i data-lucide="edit-2" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="skills-content" id="skills-content">
                                    <div class="skills-grid">
                                        <span class="skill-tag">Brand Identity</span>
                                        <span class="skill-tag">Logo Design</span>
                                        <span class="skill-tag">Adobe Illustrator</span>
                                        <span class="skill-tag">Typography</span>
                                        <span class="skill-tag">Brand Strategy</span>
                                        <span class="skill-tag">Figma</span>
                                        <span class="skill-tag">Photoshop</span>
                                        <span class="skill-tag">InDesign</span>
                                        <span class="skill-tag">UI/UX Design</span>
                                        <span class="skill-tag">Print Design</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Designs Preview -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">
                                        <i data-lucide="briefcase" class="section-icon"></i>
                                        Recent Designs
                                    </h2>
                                    <a href="user_designs.html" class="btn btn-outline btn-sm">
                                        <i data-lucide="external-link" class="icon-sm"></i>
                                        View All
                                    </a>
                                </div>
                                <div class="designs-preview">
                                    <div class="design-card-small">
                                        <div class="design-image">
                                            <img src="https://images.unsplash.com/photo-1686526473156-e8449f0c6765?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHxtb2Rlcm4lMjBsb2dvJTIwZGVzaWdufGVufDF8fHx8MTc1ODIyMzU5M3ww&ixlib=rb-4.1.0&q=80&w=1080" alt="TechStart Brand Identity" class="design-img">
                                        </div>
                                        <div class="design-info">
                                            <h3 class="design-title">TechStart Brand Identity</h3>
                                            <p class="design-category">Logo Design</p>
                                        </div>
                                    </div>

                                    <div class="design-card-small">
                                        <div class="design-image">
                                            <img src="https://images.unsplash.com/photo-1710799885122-428e63eff691?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxkZXNpZ25lciUyMHBvcnRmb2xpbyUyMGNyZWF0aXZlfGVufDF8fHx8MTc1ODI5MDQ0OXww&ixlib=rb-4.1.0&q=80&w=1080" alt="Restaurant Branding" class="design-img">
                                        </div>
                                        <div class="design-info">
                                            <h3 class="design-title">Restaurant Branding</h3>
                                            <p class="design-category">Brand Identity</p>
                                        </div>
                                    </div>

                                    <div class="design-card-small">
                                        <div class="design-image">
                                            <img src="https://images.unsplash.com/photo-1586953208448-b95a79798f07?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3w3Nzg4Nzd8MHwxfHNlYXJjaHwxfHxidXNpbmVzcyUyMGNhcmQlMjBkZXNpZ258ZW58MXx8fHwxNzU4MjkwNDQ5fDA&ixlib=rb-4.1.0&q=80&w=1080" alt="Corporate Package" class="design-img">
                                        </div>
                                        <div class="design-info">
                                            <h3 class="design-title">Corporate Package</h3>
                                            <p class="design-category">Print Design</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Introduction Section -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">
                                        <i data-lucide="message-circle" class="section-icon"></i>
                                        Introduction
                                    </h2>
                                    <button class="edit-btn hidden" onclick="editSection('introduction')">
                                        <i data-lucide="edit-2" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="editable-content" id="introduction-content">
                                    <p class="introduction-text">
                                        Hello! I'm Alex, a creative professional who loves bringing ideas to life through thoughtful design. When I'm not working on client projects, you'll find me exploring new design trends, sketching in coffee shops, or collaborating with other creatives on passion projects. I believe great design should tell a story and create meaningful connections between brands and their audiences.
                                    </p>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">
                                        <i data-lucide="phone" class="section-icon"></i>
                                        Contact Information
                                    </h2>
                                    <button class="edit-btn hidden" onclick="editSection('contact')">
                                        <i data-lucide="edit-2" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="contact-info" id="contact-content">
                                    <div class="contact-form-view">
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label>
                                            <div class="form-display"><?php echo $Phone_Display; ?></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Email Address</label>
                                            <div class="form-display"><?php echo htmlspecialchars($User_Email); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="profile-sidebar">
                            <!-- Social Media Links -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h3 class="section-title">
                                        <i data-lucide="share-2" class="section-icon"></i>
                                        Social Media
                                    </h3>
                                    <button class="edit-btn hidden" onclick="editSection('social')">
                                        <i data-lucide="edit-2" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="social-links" id="social-content">
                                    <a href="https://facebook.com/" class="social-link facebook" target="_blank">
                                        <i data-lucide="facebook" class="icon-sm"></i>
                                        <span>Facebook</span>
                                        <i data-lucide="external-link" class="icon-xs external-icon"></i>
                                    </a>
                                    <a href="https://instagram.com/" class="social-link instagram" target="_blank">
                                        <i data-lucide="instagram" class="icon-sm"></i>
                                        <span>Instagram</span>
                                        <i data-lucide="external-link" class="icon-xs external-icon"></i>
                                    </a>
                                    <a href="https://linkedin.com/in/" class="social-link linkedin" target="_blank">
                                        <i data-lucide="linkedin" class="icon-sm"></i>
                                        <span>LinkedIn</span>
                                        <i data-lucide="external-link" class="icon-xs external-icon"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="section-card">
                                <h3 class="section-title">
                                    <i data-lucide="trending-up" class="section-icon"></i>
                                    Profile Stats
                                </h3>
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <div class="stat-number">4.9</div>
                                        <div class="stat-label">Rating</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">127</div>
                                        <div class="stat-label">Reviews</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">340</div>
                                        <div class="stat-label">Projects</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-number">2020</div>
                                        <div class="stat-label">Joined</div>
                                    </div>
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
                            <li><a href="about.html" class="footer-link">About Us</a></li>
                            <li><a href="careers" class="footer-link">Careers</a></li>
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
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                const dropdown = document.getElementById('profileDropdown');
                const profileAvatar = document.querySelector('.profile-avatar');
                
                if (!profileAvatar.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });

        // Toggle dropdown menu
        function toggleDropdown() {
            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('show');
        }

        // Edit mode functionality
        let editMode = false;

        function toggleEditMode() {
            editMode = !editMode;
            const editButtons = document.querySelectorAll('.edit-btn');
            const editModeBtn = document.querySelector('[onclick="toggleEditMode()"]');
            
            if (editMode) {
                editButtons.forEach(btn => btn.classList.remove('hidden'));
                editModeBtn.innerHTML = '<i data-lucide="x" class="icon-sm"></i> Cancel Edit';
                editModeBtn.classList.remove('btn-outline');
                editModeBtn.classList.add('btn-secondary');
            } else {
                editButtons.forEach(btn => btn.classList.add('hidden'));
                editModeBtn.innerHTML = '<i data-lucide="edit-2" class="icon-sm"></i> Edit Profile';
                editModeBtn.classList.remove('btn-secondary');
                editModeBtn.classList.add('btn-outline');
            }
            
            lucide.createIcons();
        }

        function editSection(sectionType) {
            const content = document.getElementById(sectionType + '-content');
            
            if (sectionType === 'bio') {
                editTextSection(content, 'bio-text', 'Bio');
            } else if (sectionType === 'introduction') {
                editTextSection(content, 'introduction-text', 'Introduction');
            } else if (sectionType === 'contact') {
                editContactSection(content);
            } else if (sectionType === 'social') {
                editSocialSection(content);
            } else if (sectionType === 'skills') {
                editSkillsSection(content);
            }
        }

        function editTextSection(container, textClass, label) {
            const textElement = container.querySelector('.' + textClass);
            const currentText = textElement.textContent.trim();
            
            container.innerHTML = `
                <div class="edit-form">
                    <textarea class="form-textarea" rows="4" placeholder="Enter your ${label.toLowerCase()}...">${currentText}</textarea>
                    <div class="form-actions">
                        <button class="btn btn-gradient btn-sm" onclick="saveTextSection('${textClass}', '${label}')">Save</button>
                        <button class="btn btn-outline btn-sm" onclick="cancelEdit('${textClass}', '${currentText}')">Cancel</button>
                    </div>
                </div>
            `;
        }

        function editSkillsSection(container) {
            const currentSkills = Array.from(container.querySelectorAll('.skill-tag')).map(tag => tag.textContent);
            
            container.innerHTML = `
                <div class="edit-form">
                    <div class="form-group">
                        <label class="form-label">Skills (comma-separated)</label>
                        <textarea class="form-textarea" rows="3" placeholder="Enter skills separated by commas...">${currentSkills.join(', ')}</textarea>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-gradient btn-sm" onclick="saveSkillsSection()">Save</button>
                        <button class="btn btn-outline btn-sm" onclick="cancelSkillsEdit()">Cancel</button>
                    </div>
                </div>
            `;
        }

        function editContactSection(container) {
            container.innerHTML = `
                <div class="edit-form">
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-input" id="edit-phone" value="<?php echo $User_ContactNo; ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-input" id="edit-email" value="<?php echo $User_Email; ?>">
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-gradient btn-sm" onclick="saveContactSection()">Save</button>
                        <button class="btn btn-outline btn-sm" onclick="cancelContactEdit()">Cancel</button>
                    </div>
                </div>
            `;
        }

        function editSocialSection(container) {
            container.innerHTML = `
                <div class="edit-form">
                    <div class="form-group">
                        <label class="form-label">Facebook URL</label>
                        <input type="url" class="form-input" id="edit-facebook" value="https://facebook.com/alexrivera">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Instagram URL</label>
                        <input type="url" class="form-input" id="edit-instagram" value="https://instagram.com/alexrivera">
                    </div>
                    <div class="form-group">
                        <label class="form-label">LinkedIn URL</label>
                        <input type="url" class="form-input" id="edit-linkedin" value="https://linkedin.com/in/alexrivera">
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-gradient btn-sm" onclick="saveSocialSection()">Save</button>
                        <button class="btn btn-outline btn-sm" onclick="cancelSocialEdit()">Cancel</button>
                    </div>
                </div>
            `;
        }

        function saveTextSection(textClass, label) {
            const textarea = document.querySelector('.form-textarea');
            const newText = textarea.value;
            const container = textarea.closest('.editable-content');
            
            container.innerHTML = `<p class="${textClass}">${newText}</p>`;
        }

        function saveSkillsSection() {
            const textarea = document.querySelector('.form-textarea');
            const skillsText = textarea.value;
            const skills = skillsText.split(',').map(skill => skill.trim()).filter(skill => skill);
            const container = document.getElementById('skills-content');
            
            const skillsHTML = skills.map(skill => `<span class="skill-tag">${skill}</span>`).join('');
            
            container.innerHTML = `<div class="skills-grid">${skillsHTML}</div>`;
        }

        function saveContactSection() {
            const name = document.getElementById('edit-name').value;
            const phone = document.getElementById('edit-phone').value;
            const email = document.getElementById('edit-email').value;
            const container = document.getElementById('contact-content');
            
            // Update header contact info
            document.querySelector('.profile-name').textContent = name;
            document.querySelector('.contact-item:first-child span').textContent = phone;
            document.querySelector('.contact-item:last-child span').textContent = email;
            
            container.innerHTML = `
                <div class="contact-form-view">
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <div class="form-display">${phone}</div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="form-display">${email}</div>
                    </div>
                </div>
            `;
        }

        function saveSocialSection() {
            const facebook = document.getElementById('edit-facebook').value;
            const instagram = document.getElementById('edit-instagram').value;
            const linkedin = document.getElementById('edit-linkedin').value;
            const container = document.getElementById('social-content');
            
            container.innerHTML = `
                <a href="${facebook}" class="social-link facebook" target="_blank">
                    <i data-lucide="facebook" class="icon-sm"></i>
                    <span>Facebook</span>
                    <i data-lucide="external-link" class="icon-xs external-icon"></i>
                </a>
                <a href="${instagram}" class="social-link instagram" target="_blank">
                    <i data-lucide="instagram" class="icon-sm"></i>
                    <span>Instagram</span>
                    <i data-lucide="external-link" class="icon-xs external-icon"></i>
                </a>
                <a href="${linkedin}" class="social-link linkedin" target="_blank">
                    <i data-lucide="linkedin" class="icon-sm"></i>
                    <span>LinkedIn</span>
                    <i data-lucide="external-link" class="icon-xs external-icon"></i>
                </a>
            `;
            
            lucide.createIcons();
        }

        function cancelEdit(textClass, originalText) {
            const container = document.querySelector('.edit-form').closest('.editable-content');
            container.innerHTML = `<p class="${textClass}">${originalText}</p>`;
        }

        function cancelSkillsEdit() {
            const container = document.getElementById('skills-content');
            container.innerHTML = `
                <div class="skills-grid">
                    <span class="skill-tag">Brand Identity</span>
                    <span class="skill-tag">Logo Design</span>
                    <span class="skill-tag">Adobe Illustrator</span>
                    <span class="skill-tag">Typography</span>
                    <span class="skill-tag">Brand Strategy</span>
                    <span class="skill-tag">Figma</span>
                    <span class="skill-tag">Photoshop</span>
                    <span class="skill-tag">InDesign</span>
                    <span class="skill-tag">UI/UX Design</span>
                    <span class="skill-tag">Print Design</span>
                </div>
            `;
        }

        function cancelContactEdit() {
            const container = document.getElementById('contact-content');
            container.innerHTML = `
                <div class="contact-form-view">
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <div class="form-display"></div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="form-display"><?php echo $User_Email; ?></div>
                    </div>
                </div>
            `;
        }

        function cancelSocialEdit() {
            const container = document.getElementById('social-content');
            container.innerHTML = `
                <a href="https://facebook.com/alexrivera" class="social-link facebook" target="_blank">
                    <i data-lucide="facebook" class="icon-sm"></i>
                    <span>Facebook</span>
                    <i data-lucide="external-link" class="icon-xs external-icon"></i>
                </a>
                <a href="https://instagram.com/alexrivera" class="social-link instagram" target="_blank">
                    <i data-lucide="instagram" class="icon-sm"></i>
                    <span>Instagram</span>
                    <i data-lucide="external-link" class="icon-xs external-icon"></i>
                </a>
                <a href="https://linkedin.com/in/alexrivera" class="social-link linkedin" target="_blank">
                    <i data-lucide="linkedin" class="icon-sm"></i>
                    <span>LinkedIn</span>
                    <i data-lucide="external-link" class="icon-xs external-icon"></i>
                </a>
            `;
            
            lucide.createIcons();
        }

        function openImageUpload() {
            alert('Profile image upload functionality would be implemented here');
        }

        function openCoverUpload() {
            alert('Cover image upload functionality would be implemented here');
        }

        // Profile sharing
        document.querySelector('[onclick*="Share Profile"]')?.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: 'Alex Rivera - Senior Brand Designer',
                    text: 'Check out my profile on Graphio',
                    url: window.location.href
                });
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert('Profile URL copied to clipboard!');
            }
        });
    </script>
</body>
</html>