<?php
session_start();
include("../connections.php");

if (!isset($_SESSION["User_ID"])) {
    header("Location: ../login.php");
    exit("User not logged in");
}

$User_ID = $_SESSION["User_ID"];

// Fetch user record
$stmt = $connections->prepare("SELECT User_FirstName, User_LastName, User_Email, User_ContactNo, User_Photo, User_CoverPhoto, User_Bio, User_Introduction, User_Skills, User_Title, User_Facebook, User_Instagram, User_LinkedIn FROM user WHERE User_ID = ?");
$stmt->bind_param("i", $User_ID);
$stmt->execute();
$result = $stmt->get_result();
$row_edit = $result->fetch_assoc();
$stmt->close();

$User_FirstName = $row_edit["User_FirstName"] ?? '';
$User_LastName = $row_edit["User_LastName"] ?? '';
$User_Email = $row_edit["User_Email"] ?? '';
$User_ContactNo = $row_edit["User_ContactNo"] ?? '';
$User_Photo = $row_edit["User_Photo"] ?? '../media/default_user_photo.jpg';
$User_CoverPhoto = $row_edit["User_CoverPhoto"] ?? '../media/default_user_cover_photo.jpg';
$User_Bio = $row_edit["User_Bio"] ?? '';
$User_Introduction = $row_edit["User_Introduction"] ?? '';
$User_Skills = $row_edit["User_Skills"] ?? '';
$User_Title = $row_edit["User_Title"] ?? '';
$User_Facebook = $row_edit["User_Facebook"] ?? '';
$User_Instagram = $row_edit["User_Instagram"] ?? '';
$User_LinkedIn = $row_edit["User_LinkedIn"] ?? '';

// Handle AJAX updates for profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fieldsToUpdate = [];
    $types = "";
    $values = [];

    if (isset($_POST['bio'])) {
        $fieldsToUpdate[] = "User_Bio = ?";
        $types .= "s";
        $values[] = $_POST['bio'];
    }
    if (isset($_POST['introduction'])) {
        $fieldsToUpdate[] = "User_Introduction = ?";
        $types .= "s";
        $values[] = $_POST['introduction'];
    }
    if (isset($_POST['title'])) {
        $fieldsToUpdate[] = "User_Title = ?";
        $types .= "s";
        $values[] = $_POST['title'];
    }
    if (isset($_POST['skills'])) {
        $fieldsToUpdate[] = "User_Skills = ?";
        $types .= "s";
        $values[] = $_POST['skills'];
    }
    if (isset($_POST['phone'])) {
        $fieldsToUpdate[] = "User_ContactNo = ?";
        $types .= "s";
        $values[] = $_POST['phone'];
    }
    if (isset($_POST['email'])) {
        $fieldsToUpdate[] = "User_Email = ?";
        $types .= "s";
        $values[] = $_POST['email'];
    }
    if (isset($_POST['facebook'])) {
        $fieldsToUpdate[] = "User_Facebook = ?";
        $types .= "s";
        $values[] = $_POST['facebook'];
    }
    if (isset($_POST['instagram'])) {
        $fieldsToUpdate[] = "User_Instagram = ?";
        $types .= "s";
        $values[] = $_POST['instagram'];
    }
    if (isset($_POST['linkedin'])) {
        $fieldsToUpdate[] = "User_LinkedIn = ?";
        $types .= "s";
        $values[] = $_POST['linkedin'];
    }

    if (!empty($fieldsToUpdate)) {
        $sql = "UPDATE user SET " . implode(", ", $fieldsToUpdate) . " WHERE User_ID = ?";
        $types .= "i";
        $values[] = $User_ID;

        $stmt = $connections->prepare($sql);
        $stmt->bind_param($types, ...$values);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Profile updated successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to update profile"]);
        }
        $stmt->close();
    }
    exit;
}

// Fetch recent designs (limit to 3 for preview)
$recentDesigns = [];
$stmt = $connections->prepare("SELECT Design_ID, Design_Name, Design_Description, Design_Category, Design_Price, Design_Photo, Design_Created_At FROM design WHERE User_ID = ? AND Design_Status <> 2 ORDER BY Design_Created_At DESC LIMIT 3");
$stmt->bind_param("i", $User_ID);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $design_id = $row["Design_ID"];
    // Fetch average rating
    $rating_stmt = $connections->prepare("SELECT AVG(Design_Rate) as avg_rating FROM rating WHERE Design_ID = ?");
    $rating_stmt->bind_param("i", $design_id);
    $rating_stmt->execute();
    $rating_result = $rating_stmt->get_result();
    $rating_row = $rating_result->fetch_assoc();
    $rating = $rating_row["avg_rating"] ? round($rating_row["avg_rating"], 1) : 0;
    $rating_stmt->close();

    $recentDesigns[] = [
        'Design_ID' => $design_id,
        'Design_Name' => $row["Design_Name"],
        'Design_Description' => $row["Design_Description"],
        'Design_Category' => $row["Design_Category"],
        'Design_Price' => $row["Design_Price"],
        'Design_Photo' => $row["Design_Photo"] ?: '../media/default_design_photo.jpg',
        'Design_Rate' => $rating,
        'Design_Created_At' => $row["Design_Created_At"]
    ];
}
$stmt->close();
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
                        <a href="../user/dashboard" class="btn btn-outline btn-sm">Dashboard</a>
                        <div class="profile-menu">
                            <button class="profile-avatar active" onclick="toggleDropdown()">
                                <img src="../media/default_user_photo.jpg" alt="Profile" class="avatar-img">
                            </button>
                            <div class="dropdown-menu" id="profileDropdown">
                                <a href="../user_dashboard/account_settings" class="dropdown-item">
                                    <i data-lucide="settings" class="dropdown-icon"></i>
                                    Account Settings
                                </a>
                                <a href="../logout.php" class="dropdown-item">
                                    <i data-lucide="log-out" class="dropdown-icon"></i>
                                    Sign Out
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
                    <button type="file" class="cover-edit-btn" onclick="openCoverUpload()">
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
                            <p class="profile-title"><?php echo htmlspecialchars($User_Title); ?></p>
                            <div class="profile-contact">
                                <div class="contact-item">
                                    <i data-lucide="phone" class="icon-sm"></i>
                                    <span><?php echo htmlspecialchars($User_ContactNo); ?></span>
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
                                <a href="../user_dashboard/account_settings" class="logo-link-white">Account Settings</a>
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
                                    <p class="bio-text" maxlength="1000">
                                        <?php echo htmlspecialchars($User_Bio); ?>
                                    </p>
                                </div>
                            </div>

                            <!-- Title Section -->
                            <div class="section-card">
                                <div class="section-header">
                                    <h2 class="section-title">
                                        <i data-lucide="user" class="section-icon"></i>
                                        Title
                                    </h2>
                                    <button class="edit-btn hidden" onclick="editSection('title')">
                                        <i data-lucide="edit-2" class="icon-xs"></i>
                                    </button>
                                </div>
                                <div class="editable-content" id="title-content">
                                    <p class="title-text" maxlength="1000">
                                        <?php echo htmlspecialchars($User_Title); ?>
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
                                            <div class="skills-grid">
                                                <?php
                                                // Split the skills string by commas
                                                $skills = explode(',', $User_Skills);

                                                // Loop through each skill and output as a separate <span>
                                                foreach ($skills as $skill) {
                                                    $skill = trim($skill); // remove extra spaces
                                                    if (!empty($skill)) {
                                                        echo '<span class="skill-tag">' . htmlspecialchars($skill) . '</span>';
                                                    }
                                                }
                                                ?>
                                            </div>
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
                                    <a href="../user/user_designs" class="btn btn-outline btn-sm">
                                        <i data-lucide="external-link" class="icon-sm"></i>
                                        View All
                                    </a>
                                </div>
                                <div class="designs-preview">
                                <?php if (!empty($recentDesigns)): ?>
                                    <?php foreach ($recentDesigns as $design): ?>
                                        <div class="design-card-small">
                                            <div class="design-image">
                                                <img src="<?php echo htmlspecialchars($design['Design_Photo']); ?>" 
                                                    alt="<?php echo htmlspecialchars($design['Design_Name']); ?>" 
                                                    class="design-img">
                                            </div>
                                            <div class="design-info">
                                                <h3 class="design-title"><?php echo htmlspecialchars($design['Design_Name']); ?></h3>
                                                <p class="design-category"><?php echo htmlspecialchars($design['Design_Category']); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Placeholder if user has no designs -->
                                    <p class="no-designs-message">You haven't uploaded any designs yet.</p>
                                <?php endif; ?>
                                
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
                                        <?php echo htmlspecialchars($User_Introduction); ?>
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
                                            <div class="form-display"><?php echo htmlspecialchars($User_ContactNo); ?></div>
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
                                    <a href="<?php echo htmlspecialchars($User_Facebook); ?>" class="social-link facebook" target="_blank">
                                        <i data-lucide="facebook" class="icon-sm"></i>
                                        <span>Facebook</span>
                                        <i data-lucide="external-link" class="icon-xs external-icon"></i>
                                    </a>
                                    <a href="<?php echo htmlspecialchars($User_Instagram); ?>" class="social-link instagram" target="_blank">
                                        <i data-lucide="instagram" class="icon-sm"></i>
                                        <span>Instagram</span>
                                        <i data-lucide="external-link" class="icon-xs external-icon"></i>
                                    </a>
                                    <a href="<?php echo htmlspecialchars($User_LinkedIn); ?>" class="social-link linkedin" target="_blank">
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
                            <li><a href="../about.html" class="footer-link">About Us</a></li>
                            <li><a href="../careers" class="footer-link">Careers</a></li>
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
            } else if (sectionType === 'title') {
                editTextSection(content, 'title-text', 'Title');
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
        const phoneSpan = document.querySelector('.profile-contact .contact-item:first-child span');
        const emailSpan = document.querySelector('.profile-contact .contact-item:last-child span');

        const currentPhone = phoneSpan.textContent.trim();
        const currentEmail = emailSpan.textContent.trim();

        container.innerHTML = `
            <div class="edit-form">
                <div class="form-group">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" class="form-input" id="edit-phone" value="${currentPhone}">
                </div>
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" class="form-input" id="edit-email" value="${currentEmail}">
                    <small class="form-note">Changing your email will also update your login email.</small>
                </div>
                <div class="form-actions">
                    <button class="btn btn-gradient btn-sm" onclick="saveContactSection()">Save</button>
                    <button class="btn btn-outline btn-sm" onclick="cancelContactEdit()">Cancel</button>
                </div>
            </div>
        `;
    }

let originalSocialLinks = {};

function editSocialSection(container) {
    // Grab current links from the DOM
    const facebookEl = container.querySelector('.facebook');
    const instagramEl = container.querySelector('.instagram');
    const linkedinEl = container.querySelector('.linkedin');

    originalSocialLinks.facebook = facebookEl ? facebookEl.href : 'https://facebook.com/';
    originalSocialLinks.instagram = instagramEl ? instagramEl.href : 'https://instagram.com/';
    originalSocialLinks.linkedin = linkedinEl ? linkedinEl.href : 'https://linkedin.com/in/';

    container.innerHTML = `
        <div class="edit-form">
            <div class="form-group">
                <label class="form-label">Facebook URL</label>
                <input type="url" class="form-input" id="edit-facebook" value="${originalSocialLinks.facebook}">
            </div>
            <div class="form-group">
                <label class="form-label">Instagram URL</label>
                <input type="url" class="form-input" id="edit-instagram" value="${originalSocialLinks.instagram}">
            </div>
            <div class="form-group">
                <label class="form-label">LinkedIn URL</label>
                <input type="url" class="form-input" id="edit-linkedin" value="${originalSocialLinks.linkedin}">
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

            fetch('profile.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `${label.toLowerCase()}=${encodeURIComponent(newText)}`
            })
            .then(response => response.text())
            .then(data => {
                container.innerHTML = `<p class="${textClass}">${newText}</p>`;
            })
            .catch(error => console.error(error));
        }

        function saveSkillsSection() {
            const textarea = document.querySelector('.form-textarea');
            const skillsText = textarea.value;
            const skills = skillsText.split(',').map(skill => skill.trim()).filter(skill => skill);
            const container = document.getElementById('skills-content');
            
            fetch('profile.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `skills=${encodeURIComponent(skills.join(', '))}`
            })
            .then(response => response.text())
            .then(data => {
                const skillsHTML = skills.map(skill => `<span class="skill-tag">${skill}</span>`).join('');
                container.innerHTML = `<div class="skills-grid">${skillsHTML}</div>`;
            })
            .catch(error => console.error(error));

        }

        function saveContactSection() {
    const phone = document.getElementById('edit-phone').value;
    const email = document.getElementById('edit-email').value;

    const container = document.getElementById('contact-content');
    const phoneSpan = document.querySelector('.profile-contact .contact-item:first-child span');
    const emailSpan = document.querySelector('.profile-contact .contact-item:last-child span');

    // Update the displayed spans only
    phoneSpan.textContent = phone;
    emailSpan.textContent = email;

    // Remove the edit form
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

    // Send AJAX request
    fetch('profile.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `phone=${encodeURIComponent(phone)}&email=${encodeURIComponent(email)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            console.log(data.message);
        } else {
            console.error(data.message);
        }
    })
    .catch(err => console.error('Fetch error:', err));
}


function saveSocialSection() {
    const facebook = document.getElementById('edit-facebook').value.trim();
    const instagram = document.getElementById('edit-instagram').value.trim();
    const linkedin = document.getElementById('edit-linkedin').value.trim();
    const container = document.getElementById('social-content');

    // Update DOM
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

    // Update original values so cancel restores the latest saved values
    originalSocialLinks.facebook = facebook;
    originalSocialLinks.instagram = instagram;
    originalSocialLinks.linkedin = linkedin;

    // AJAX request
    fetch('profile.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `facebook=${encodeURIComponent(facebook)}&instagram=${encodeURIComponent(instagram)}&linkedin=${encodeURIComponent(linkedin)}`
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') console.log(data.message);
        else console.error(data.message);
    })
    .catch(err => console.error('Fetch error:', err));
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
    const phone = document.querySelector('.profile-contact .contact-item:first-child span').textContent;
    const email = document.querySelector('.profile-contact .contact-item:last-child span').textContent;

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


        function cancelSocialEdit() {
    const container = document.getElementById('social-content');

    container.innerHTML = `
        <a href="${originalSocialLinks.facebook}" class="social-link facebook" target="_blank">
            <i data-lucide="facebook" class="icon-sm"></i>
            <span>Facebook</span>
            <i data-lucide="external-link" class="icon-xs external-icon"></i>
        </a>
        <a href="${originalSocialLinks.instagram}" class="social-link instagram" target="_blank">
            <i data-lucide="instagram" class="icon-sm"></i>
            <span>Instagram</span>
            <i data-lucide="external-link" class="icon-xs external-icon"></i>
        </a>
        <a href="${originalSocialLinks.linkedin}" class="social-link linkedin" target="_blank">
            <i data-lucide="linkedin" class="icon-sm"></i>
            <span>LinkedIn</span>
            <i data-lucide="external-link" class="icon-xs external-icon"></i>
        </a>
    `;

    lucide.createIcons();
}



        function openImageUpload() {
            //alert('Profile image upload functionality would be implemented here');
        }

        function openCoverUpload() {
            //alert('Cover image upload functionality would be implemented here');
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