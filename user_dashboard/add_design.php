<?php

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Design - Graphio</title>
    <link rel="stylesheet" href="add_design_styles.css">
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

                    <!-- Desktop Navigation -->
                    <nav class="nav-desktop">
                        <a href="../designs" class="nav-link">Designs</a>
                        <a href="../careers" class="nav-link">Careers</a>
                        <a href="../artists" class="nav-link">Artists</a>
                        <a href="../about" class="nav-link">About</a>
                    </nav>

                    <!-- Right side buttons -->
                    <div class="header-buttons">
                        <button class="btn btn-ghost btn-sm search-btn">
                            <i data-lucide="search" class="icon-sm"></i>
                            Search
                        </button>
                        <a href="../user/dashboard" class="btn btn-outline btn-sm">Dashboard</a>
                        <div class="profile-menu">
                            <button class="profile-avatar">
                                <img src="../media/default_user_photo.jpg" alt="Profile" class="avatar-img">
                            </button>
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
            <!-- Page Header -->
            <section class="page-header">
                <div class="container">
                    <div class="header-content-wrapper">
                        <div class="breadcrumb">
                            <a href="../user/dashboard" class="breadcrumb-link">Dashboard</a>
                            <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                            <a href="../user/user_designs" class="breadcrumb-link">My Designs</a>
                            <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                            <span class="breadcrumb-current">Upload Design</span>
                        </div>
                        
                        <div class="page-title-section">
                            <div class="page-info">
                                <h1 class="page-title">Upload New Design</h1>
                                <p class="page-subtitle">Share your creative work with the Graphio community</p>
                            </div>
                            <div class="page-actions">
                                <a href="../user/user_designs" class="btn btn-outline">
                                    <i data-lucide="arrow-left" class="icon-sm"></i>
                                    Back to Designs
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Upload Form -->
            <section class="upload-section">
                <div class="container">
                   <form 
                    class="upload-form" 
                    id="design-upload-form" 
                    method="POST" 
                    enctype="multipart/form-data" 
                    onsubmit="handleSubmit(event)">
                        <div class="form-layout">
                            <!-- Left Column - Main Form -->
                            <div class="form-main">
                                <!-- Design Photo Upload -->
                                <div class="form-card">
                                    <div class="form-card-header">
                                        <h2 class="form-card-title">
                                            <i data-lucide="image" class="section-icon"></i>
                                            Design Image
                                        </h2>
                                        <p class="form-card-description">Upload a high-quality preview of your design</p>
                                    </div>
                                    <div class="form-card-content">
                                        <div class="file-upload-area" id="image-upload-area">
                                            <input type="file" id="design-image" name="Design_Photo" accept="image/*" class="file-input" required>
                                            <div class="upload-placeholder" id="upload-placeholder">
                                                <div class="upload-icon">
                                                    <i data-lucide="cloud-upload" class="icon-xl"></i>
                                                </div>
                                                <div class="upload-text">
                                                    <h3 class="upload-title">Click to upload or drag and drop</h3>
                                                    <p class="upload-subtitle">PNG, JPG, JPEG up to 10MB</p>
                                                    <p class="upload-note">Recommended: 1200x900px for best quality</p>
                                                </div>
                                            </div>
                                            <div class="image-preview hidden" id="image-preview">
                                                <img id="preview-img" src="" alt="Design preview" class="preview-image">
                                                <div class="preview-overlay">
                                                    <button type="button" class="btn btn-outline btn-sm" onclick="changeImage(event)">
                                                        <i data-lucide="edit-2" class="icon-sm"></i>
                                                        Change Image
                                                    </button>
                                                    <button type="button" class="btn btn-outline btn-sm" onclick="removeImage(event)">
                                                        <i data-lucide="trash-2" class="icon-sm"></i>
                                                        Remove
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Design Details -->
                                <div class="form-card">
                                    <div class="form-card-header">
                                        <h2 class="form-card-title">
                                            <i data-lucide="info" class="section-icon"></i>
                                            Design Details
                                        </h2>
                                        <p class="form-card-description">Provide information about your design</p>
                                    </div>
                                    <div class="form-card-content">
                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="design-name" class="form-label">
                                                    Design Name *
                                                </label>
                                                <input 
                                                    type="text" 
                                                    id="design-name" 
                                                    name="Design_Name" 
                                                    class="form-input" 
                                                    placeholder="Enter your design name"
                                                    required
                                                    maxlength="100"
                                                >
                                                <div class="character-count">
                                                    <span id="name-count">0</span>/100
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-span-2">
                                                <label for="design-description" class="form-label">
                                                    Design Description *
                                                </label>
                                                <textarea 
                                                    id="design-description" 
                                                    name="Design_Description" 
                                                    class="form-textarea" 
                                                    rows="5"
                                                    placeholder="Describe your design, its features, and what makes it unique..."
                                                    required
                                                    maxlength="1000"
                                                ></textarea>
                                                <div class="character-count">
                                                    <span id="description-count">0</span>/1000
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="Design_Category_Name" id="Design_Category_Name">

                                        <div class="form-row">
                                            <div class="form-group">
                                                <label for="design-category" class="form-label">
                                                    Category *
                                                </label>
                                                <div class="select-wrapper">
                                                    <select id="design-category" name="Design_Category" class="form-select" required>
                                                        <option value="">Select a category</option>
                                                        <option value="logo-design">Logo Design</option>
                                                        <option value="brand-identity">Brand Identity</option>
                                                        <option value="web-design">Web Design</option>
                                                        <option value="ui-ux">UI/UX Design</option>
                                                        <option value="print-design">Print Design</option>
                                                        <option value="digital-art">Digital Art</option>
                                                        <option value="illustration">Illustration</option>
                                                        <option value="typography">Typography</option>
                                                        <option value="packaging">Packaging Design</option>
                                                        <option value="social-media">Social Media Graphics</option>
                                                        <option value="business-cards">Business Cards</option>
                                                        <option value="flyers-posters">Flyers & Posters</option>
                                                        <option value="infographics">Infographics</option>
                                                        <option value="presentations">Presentations</option>
                                                        <option value="mobile-app">Mobile App Design</option>
                                                        <option value="other">Other</option>
                                                    </select>
                                                    <i data-lucide="chevron-down" class="select-icon"></i>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="design-price" class="form-label">
                                                    Price (USD) *
                                                </label>
                                                <div class="price-input-wrapper">
                                                    <span class="price-prefix">$</span>
                                                    <input 
                                                        type="number" 
                                                        id="design-price" 
                                                        name="Design_Price" 
                                                        class="form-input price-input" 
                                                        placeholder="0.00"
                                                        min="1"
                                                        max="10000"
                                                        step="0.01"
                                                        required
                                                    >
                                                </div>
                                                <p class="field-help">Minimum price: $1.00</p>
                                            </div>
                                        </div>

                                        <div class="form-row">
                                            <div class="form-group col-span-2">
                                                <label for="design-url" class="form-label">
                                                    Design Template URL *
                                                </label>
                                                <input 
                                                    type="url" 
                                                    id="design-url" 
                                                    name="Design_Url" 
                                                    class="form-input" 
                                                    placeholder="https://example.com/your-template-link"
                                                    required
                                                >
                                                <p class="field-help">Provide a link to your design template (Figma, Adobe Creative Cloud, Canva, etc.)</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column - Sidebar -->
                            <div class="form-sidebar">
                                <!-- Upload Guidelines -->
                                <div class="sidebar-card">
                                    <div class="sidebar-card-header">
                                        <h3 class="sidebar-card-title">
                                            <i data-lucide="info" class="icon-sm"></i>
                                            Upload Guidelines
                                        </h3>
                                    </div>
                                    <div class="sidebar-card-content">
                                        <ul class="guidelines-list">
                                            <li class="guideline-item">
                                                <i data-lucide="check" class="icon-xs guideline-icon"></i>
                                                Original work only
                                            </li>
                                            <li class="guideline-item">
                                                <i data-lucide="check" class="icon-xs guideline-icon"></i>
                                                High-quality images (min 1200px width)
                                            </li>
                                            <li class="guideline-item">
                                                <i data-lucide="check" class="icon-xs guideline-icon"></i>
                                                Clear, descriptive titles
                                            </li>
                                            <li class="guideline-item">
                                                <i data-lucide="check" class="icon-xs guideline-icon"></i>
                                                Appropriate pricing
                                            </li>
                                            <li class="guideline-item">
                                                <i data-lucide="check" class="icon-xs guideline-icon"></i>
                                                Electronic files only
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- File Formats -->
                                <div class="sidebar-card">
                                    <div class="sidebar-card-header">
                                        <h3 class="sidebar-card-title">
                                            <i data-lucide="file-type" class="icon-sm"></i>
                                            Supported Formats
                                        </h3>
                                    </div>
                                    <div class="sidebar-card-content">
                                        <div class="format-grid">
                                            <div class="format-item">
                                                <span class="format-type">Preview Images</span>
                                                <span class="format-list">JPG, PNG, JPEG</span>
                                            </div>
                                            <div class="format-item">
                                                <span class="format-type">Template URL</span>
                                                <span class="format-list">Any valid link</span>
                                            </div>
                                            <div class="format-item">
                                                <span class="format-type">Image Size</span>
                                                <span class="format-list">Max 10MB</span>
                                            </div>
                                            <div class="format-item">
                                                <span class="format-type">Dimensions</span>
                                                <span class="format-list">Min 1200px width</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pricing Suggestions -->
                                <div class="sidebar-card">
                                    <div class="sidebar-card-header">
                                        <h3 class="sidebar-card-title">
                                            <i data-lucide="dollar-sign" class="icon-sm"></i>
                                            Pricing Guide
                                        </h3>
                                    </div>
                                    <div class="sidebar-card-content">
                                        <div class="pricing-suggestions">
                                            <div class="price-range">
                                                <span class="price-category">Logo Design</span>
                                                <span class="price-value">$25 - $150</span>
                                            </div>
                                            <div class="price-range">
                                                <span class="price-category">Brand Identity</span>
                                                <span class="price-value">$50 - $300</span>
                                            </div>
                                            <div class="price-range">
                                                <span class="price-category">UI/UX Kit</span>
                                                <span class="price-value">$30 - $200</span>
                                            </div>
                                            <div class="price-range">
                                                <span class="price-category">Print Design</span>
                                                <span class="price-value">$15 - $100</span>
                                            </div>
                                        </div>
                                        <p class="pricing-note">
                                            Prices vary based on complexity and uniqueness
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="form-actions">
                            <div class="actions-center">
                                <button type="submit" class="btn btn-gradient btn-lg">
                                    <i data-lucide="upload" class="icon-sm"></i>
                                    Upload Design
                                </button>
                            </div>
                        </div>
                    </form>
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
document.addEventListener('DOMContentLoaded', function() {
    lucide.createIcons();
    initializeForm();
});

function initializeForm() {
    const nameInput = document.getElementById('design-name');
    const descriptionInput = document.getElementById('design-description');
    nameInput.addEventListener('input', () => updateCharacterCount('design-name', 'name-count', 100));
    descriptionInput.addEventListener('input', () => updateCharacterCount('design-description', 'description-count', 1000));

    const fileInput = document.getElementById('design-image');
    const uploadArea = document.getElementById('image-upload-area');
    fileInput.addEventListener('change', handleFileSelect);
    uploadArea.addEventListener('dragover', handleDragOver);
    uploadArea.addEventListener('dragleave', handleDragLeave);
    uploadArea.addEventListener('drop', handleDrop);

    uploadArea.addEventListener('click', (event) => {
        if (event.target.id === 'image-upload-area' || event.target.id === 'upload-placeholder') {
            fileInput.value = '';
            fileInput.click();
        }
    });
    window.addEventListener('dragover', e => e.preventDefault());
    window.addEventListener('drop', e => e.preventDefault());
}

function updateCharacterCount(inputId, countId, maxLength) {
    const input = document.getElementById(inputId);
    const counter = document.getElementById(countId);
    const currentLength = input.value.length;
    counter.textContent = currentLength;
    counter.style.color = currentLength > maxLength * 0.9 ? '#ef4444' : '#6b7280';
}

function handleFileSelect(event) {
    const file = event.target.files[0];
    if (file) validateAndPreviewImage(file);
}
function handleDragOver(e) { e.preventDefault(); e.currentTarget.classList.add('drag-over'); }
function handleDragLeave(e) { e.preventDefault(); e.currentTarget.classList.remove('drag-over'); }
function handleDrop(e) {
    e.preventDefault();
    e.currentTarget.classList.remove('drag-over');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('design-image').files = files;
        validateAndPreviewImage(files[0]);
    }
}

function validateAndPreviewImage(file) {
    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
    if (!allowedTypes.includes(file.type)) {
        alert('Please upload a valid image (PNG or JPG).');
        return;
    }
    if (file.size > 10 * 1024 * 1024) {
        alert('File size must be less than 10MB.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const placeholder = document.getElementById('upload-placeholder');
        const preview = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        previewImg.src = e.target.result;
        placeholder.classList.add('hidden');
        preview.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
}

function changeImage(e) {
    e.stopPropagation();
    const fileInput = document.getElementById('design-image');
    fileInput.value = '';
    fileInput.click();
}

function removeImage(e) {
    e.stopPropagation();
    const fileInput = document.getElementById('design-image');
    const placeholder = document.getElementById('upload-placeholder');
    const preview = document.getElementById('image-preview');
    fileInput.value = '';
    placeholder.classList.remove('hidden');
    preview.classList.add('hidden');
}

// ✅ FINAL FIXED UPLOAD FUNCTION
async function handleSubmit(event) {
    event.preventDefault();
    const form = document.getElementById("design-upload-form");
    const formData = new FormData(form);

    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.innerHTML = '<i data-lucide="loader-2" class="icon-sm animate-spin"></i> Uploading...';
    submitBtn.disabled = true;

    try {
        const response = await fetch("upload_design.php", { method: "POST", body: formData });
        const data = await response.json();

        if (data.status === "success") {
            alert("✅ " + data.message);
            window.location.href = "../user/user_designs.php";
        } else {
            alert("⚠️ " + data.message);
        }
    } catch (error) {
        alert("🚨 Upload failed: " + error);
    } finally {
        submitBtn.innerHTML = '<i data-lucide="upload" class="icon-sm"></i> Upload Design';
        submitBtn.disabled = false;
    }
}
</script>

<script>
    function setText(nameSel, hiddenId){
        const opt = document.querySelector(nameSel + " option:checked");
        document.getElementById(hiddenId).value = opt ? opt.text : "";
    }
    ["#design-category"].forEach((sel, i) => {
        const ids = ["Design_Category_Name"];
        document.querySelector(sel)?.addEventListener("change", () => setText(sel, ids[i]));
        // initialize on load too
        setText(sel, ids[i]);
    });
    </script>



</body>
</html>