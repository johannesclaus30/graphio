<?php
session_start();
include("../connections.php");

if (!isset($_SESSION["User_ID"])) {
    die("User not logged in.");
}
$User_ID = (int) $_SESSION["User_ID"];

// Validate and load design id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    die("Design not specified.");
}
$designId = (int) $_GET['id'];

// Fetch design and ensure current user is the owner
$designStmt = $connections->prepare("
    SELECT 
        Design_ID,
        User_ID,
        Design_Name,
        Design_Description,
        Design_Category,
        Design_Price,
        Design_Photo,
        Design_Url,
        Design_Created_At
    FROM design
    WHERE Design_ID = ?
    LIMIT 1
");
$designStmt->bind_param("i", $designId);
$designStmt->execute();
$designRes = $designStmt->get_result();
if ($designRes->num_rows === 0) {
    http_response_code(404);
    die("Design not found.");
}
$design = $designRes->fetch_assoc();
$designStmt->close();

if ((int)$design['User_ID'] !== $User_ID) {
    http_response_code(403);
    die("You are not allowed to edit this design.");
}

// Fetch user info (for header/avatar)
$userStmt = $connections->prepare("SELECT User_FirstName, User_LastName FROM user WHERE User_ID = ?");
$userStmt->bind_param("i", $User_ID);
$userStmt->execute();
$userResult = $userStmt->get_result();
$user = $userResult->fetch_assoc();
$userStmt->close();

$User_Initials = strtoupper(substr($user['User_FirstName'] ?? '', 0, 1) . substr($user['User_LastName'] ?? '', 0, 1));

// CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrfToken = $_SESSION['csrf_token'];

$errors = [];
$success = false;

// Handle POST (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // CSRF check
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $errors[] = "Invalid request token. Please try again.";
    } else {
        // Sanitize inputs
        $name = trim($_POST['design_name'] ?? '');
        $description = trim($_POST['design_description'] ?? '');
        $category = trim($_POST['design_category'] ?? '');
        $categoryName = trim($_POST['design_category_name'] ?? '');
        $price = trim($_POST['design_price'] ?? '');
        $url = trim($_POST['design_url'] ?? '');

        // Validate
        if ($name === '') {
            $errors[] = "Design name is required.";
        } elseif (mb_strlen($name) > 150) {
            $errors[] = "Design name must be at most 150 characters.";
        }

        if ($description === '') {
            $errors[] = "Description is required.";
        } elseif (mb_strlen($description) > 1000) {
            $errors[] = "Description must be at most 1000 characters.";
        }

        if ($category === '') {
            $errors[] = "Category is required.";
        } elseif (mb_strlen($category) > 100) {
            $errors[] = "Category must be at most 100 characters.";
        }

        if ($price === '') {
            $errors[] = "Price is required.";
        } elseif (!is_numeric($price) || (float)$price < 1) {
            $errors[] = "Price must be a number greater than or equal to 1.00.";
        }

        if ($url === '') {
            $errors[] = "Template URL is required.";
        } elseif (!filter_var($url, FILTER_VALIDATE_URL)) {
            $errors[] = "Template URL must be a valid URL.";
        }

        // Handle optional image upload
        $newPhotoPath = null;
        if (isset($_FILES['design_photo']) && $_FILES['design_photo']['error'] !== UPLOAD_ERR_NO_FILE) {
            $file = $_FILES['design_photo'];

            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errors[] = "Image upload failed. Error code: " . (int)$file['error'];
            } else {
                // Validate file type and size
                $maxSize = 10 * 1024 * 1024; // 10MB
                if ($file['size'] > $maxSize) {
                    $errors[] = "Image must be 10MB or smaller.";
                } else {
                    $finfo = new finfo(FILEINFO_MIME_TYPE);
                    $mime = $finfo->file($file['tmp_name']);
                    $allowed = [
                        'image/jpeg' => 'jpg',
                        'image/png'  => 'png',
                        'image/webp' => 'webp',
                        'image/gif'  => 'gif'
                    ];
                    if (!isset($allowed[$mime])) {
                        $errors[] = "Unsupported image type. Allowed: JPG, PNG, WEBP, GIF.";
                    } else {
                        $ext = $allowed[$mime];
                        $uploadDir = realpath(__DIR__ . '/../uploads') ?: (__DIR__ . '/../uploads');
                        $designsDir = $uploadDir . '/designs';

                        if (!is_dir($designsDir)) {
                            @mkdir($designsDir, 0755, true);
                        }

                        // Build a relative path for storing in DB
                        $basename = uniqid('design_', true) . '.' . $ext;
                        $targetFsPath = $designsDir . '/' . $basename;
                        $relativePath = '../uploads/designs/' . $basename;

                        if (!move_uploaded_file($file['tmp_name'], $targetFsPath)) {
                            $errors[] = "Failed to save uploaded image.";
                        } else {
                            $newPhotoPath = $relativePath;
                        }
                    }
                }
            }
        }

        // If valid, update DB
        if (empty($errors)) {
            if ($newPhotoPath !== null) {
                // Include Design_Photo
                $updateStmt = $connections->prepare("
                    UPDATE design
                    SET 
                        Design_Name = ?,
                        Design_Description = ?,
                        Design_Category = ?,
                        Design_Category_Name = ?,
                        Design_Price = ?,
                        Design_Url = ?,
                        Design_Photo = ?
                    WHERE Design_ID = ? AND User_ID = ?
                    LIMIT 1
                ");
                $updateStmt->bind_param(
                    "sssssssii",
                    $name,
                    $description,
                    $category,
                    $categoryName,
                    $price,
                    $url,
                    $newPhotoPath,
                    $designId,
                    $User_ID
                );
            } else {
                // Without changing image
                $updateStmt = $connections->prepare("
                    UPDATE design
                    SET 
                        Design_Name = ?,
                        Design_Description = ?,
                        Design_Category = ?,
                        Design_Category = ?,
                        Design_Price = ?,
                        Design_Url = ?
                    WHERE Design_ID = ? AND User_ID = ?
                    LIMIT 1
                ");
                $updateStmt->bind_param(
                    "ssssssii",
                    $name,
                    $description,
                    $category,
                    $categoryName,
                    $price,
                    $url,
                    $designId,
                    $User_ID
                );
            }

            if (!$updateStmt->execute()) {
                $errors[] = "Database update failed. Please try again.";
            } else {
                $success = true;
                // Refresh $design data for re-render (or redirect)
                $design['Design_Name'] = $name;
                $design['Design_Description'] = $description;
                $design['Design_Category'] = $category;
                $design['Design_Category_Name'] = $categoryName;
                $design['Design_Price'] = $price;
                $design['Design_Url'] = $url;
                if ($newPhotoPath !== null) {
                    $design['Design_Photo'] = $newPhotoPath;
                }

                // Redirect to view page with success flag
                header("Location: ../view/view_design.php?id=" . $designId . "&updated=1");
                exit;
            }
            $updateStmt->close();
        }
    }
}

// Safe vars for display
$designName = htmlspecialchars($design['Design_Name'] ?? '');
$designDescription = htmlspecialchars($design['Design_Description'] ?? '');
$designCategory = htmlspecialchars($design['Design_Category'] ?? '');
$designCategoryName = htmlspecialchars($design['Design_Category_Name'] ?? '');
$designPrice = htmlspecialchars($design['Design_Price'] ?? '0.00');
$designPhoto = htmlspecialchars($design['Design_Photo'] ?? '../media/placeholder.png');
$designUrl = htmlspecialchars($design['Design_Url'] ?? '');
$designCreatedAt = htmlspecialchars(date("M d, Y", strtotime($design['Design_Created_At'] ?? 'now')));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit: <?php echo $designName; ?> - Graphio</title>
    <link rel="stylesheet" href="view_design.css"><!-- reuse styling -->
    <style>
        .form-section { background:#fff; border-radius:12px; padding:24px; margin-bottom:24px; box-shadow: 0 2px 10px rgba(0,0,0,.05); }
        .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
        .form-field { display:flex; flex-direction:column; gap:8px; }
        .form-label { font-weight:600; font-size:14px; }
        .form-input, .form-select, .form-textarea { padding:10px 12px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { outline:none; border-color:#3b82f6; box-shadow:0 0 0 3px rgba(59,130,246,.15); }
        .actions { display:flex; gap:12px; margin-top:16px; }
        .btn { border:none; border-radius:10px; padding:10px 16px; font-weight:600; cursor:pointer; display:inline-flex; align-items:center; gap:8px; }
        .btn-gradient { background:linear-gradient(135deg,#6366f1,#3b82f6); color:#fff; }
        .btn-outline { background:#fff; color:#111827; border:1px solid #e5e7eb; }
        .image-preview { max-width:100%; border-radius:12px; border:1px solid #e5e7eb; }
        .error { background:#fef2f2; color:#991b1b; border:1px solid #fecaca; padding:12px; border-radius:10px; margin-bottom:16px; }
        .success { background:#ecfdf5; color:#065f46; border:1px solid #a7f3d0; padding:12px; border-radius:10px; margin-bottom:16px; }
        .header { background:#fff; border-bottom:1px solid #e5e7eb; }
        .breadcrumb-section { background:#f9fafb; border-bottom:1px solid #e5e7eb; }
        .page-title { margin:0 0 4px 0; }
        .note { font-size:12px; color:#6b7280; }
        .select-wrapper { position:relative; }
        .select-icon { position:absolute; right:12px; top:50%; transform:translateY(-50%); pointer-events:none; color:#9ca3af; }
        .price-input-wrapper { display:flex; align-items:center; }
        .price-prefix { background:#f9fafb; border:1px solid #e5e7eb; border-right:none; border-radius:8px 0 0 8px; padding:10px 12px; color:#6b7280; }
        .price-input { border-radius:0 8px 8px 0; }
        .character-count { font-size:12px; color:#6b7280; text-align:right; }
    </style>

    <!-- Lucide (pinned + defer) -->
    <script
        defer
        src="https://unpkg.com/lucide@0.469.0/dist/umd/lucide.min.js"
        onload="window.lucide && lucide.createIcons()"
    ></script>
</head>
<body>
<div class="page-wrapper">
    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="header-content">
                <div class="header-left">
                    <a href="../index" class="logo">
                        <span class="logo-text">Graphio</span>
                    </a>
                </div>
                <div class="header-right">
                    <div class="user-avatar">
                        <a href="../user/profile" class="logo-link-white">
                            <span class="avatar-text"><?php echo htmlspecialchars($User_Initials); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Breadcrumb -->
    <div class="breadcrumb-section">
        <div class="container">
            <nav class="breadcrumb">
                <a href="../index" class="breadcrumb-link">
                    <i data-lucide="home" class="icon-sm"></i> Home
                </a>
                <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                <a href="user_designs.php" class="breadcrumb-link">My Designs</a>
                <i data-lucide="chevron-right" class="breadcrumb-separator"></i>
                <span class="breadcrumb-current">Edit: <?php echo $designName; ?></span>
            </nav>
        </div>
    </div>

    <main class="main-content">
        <div class="container">
            <section class="form-section">
                <h1 class="page-title">Edit Design</h1>
                <p class="note">Created on <?php echo $designCreatedAt; ?>. Update the fields below and click Save.</p>

                <?php if (!empty($errors)): ?>
                    <div class="error">
                        <ul style="margin:0; padding-left:16px;">
                            <?php foreach ($errors as $e): ?>
                                <li><?php echo htmlspecialchars($e); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="post" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrfToken); ?>">
                    <input type="hidden" id="design_category_name" name="design_category_name" value="<?php echo $designCategoryName; ?>">

                    <div class="form-grid">
                        <div class="form-field" style="grid-column:1 / -1;">
                            <label class="form-label" for="design_name">Design Name *</label>
                            <input class="form-input" type="text" id="design_name" name="design_name" maxlength="150" required value="<?php echo $designName; ?>">
                            <div class="character-count"><span id="name-count"><?php echo mb_strlen($designName); ?></span>/150</div>
                        </div>

                        <div class="form-field" style="grid-column:1 / -1;">
                            <label class="form-label" for="design_description">Design Description *</label>
                            <textarea class="form-textarea" id="design_description" name="design_description" rows="5" maxlength="1000" required><?php echo $designDescription; ?></textarea>
                            <div class="character-count"><span id="description-count"><?php echo mb_strlen($designDescription); ?></span>/1000</div>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="design_category">Category *</label>
                            <div class="select-wrapper">
                                <select id="design_category" name="design_category" class="form-select" required>
                                    <option value="">Select a category</option>
                                    <option value="logo-design" <?php echo $designCategory==='logo-design'?'selected':''; ?>>Logo Design</option>
                                    <option value="brand-identity" <?php echo $designCategory==='brand-identity'?'selected':''; ?>>Brand Identity</option>
                                    <option value="web-design" <?php echo $designCategory==='web-design'?'selected':''; ?>>Web Design</option>
                                    <option value="ui-ux" <?php echo $designCategory==='ui-ux'?'selected':''; ?>>UI/UX Design</option>
                                    <option value="print-design" <?php echo $designCategory==='print-design'?'selected':''; ?>>Print Design</option>
                                    <option value="digital-art" <?php echo $designCategory==='digital-art'?'selected':''; ?>>Digital Art</option>
                                    <option value="illustration" <?php echo $designCategory==='illustration'?'selected':''; ?>>Illustration</option>
                                    <option value="typography" <?php echo $designCategory==='typography'?'selected':''; ?>>Typography</option>
                                    <option value="packaging" <?php echo $designCategory==='packaging'?'selected':''; ?>>Packaging Design</option>
                                    <option value="social-media" <?php echo $designCategory==='social-media'?'selected':''; ?>>Social Media Graphics</option>
                                    <option value="business-cards" <?php echo $designCategory==='business-cards'?'selected':''; ?>>Business Cards</option>
                                    <option value="flyers-posters" <?php echo $designCategory==='flyers-posters'?'selected':''; ?>>Flyers & Posters</option>
                                    <option value="infographics" <?php echo $designCategory==='infographics'?'selected':''; ?>>Infographics</option>
                                    <option value="presentations" <?php echo $designCategory==='presentations'?'selected':''; ?>>Presentations</option>
                                    <option value="mobile-app" <?php echo $designCategory==='mobile-app'?'selected':''; ?>>Mobile App Design</option>
                                    <option value="other" <?php echo $designCategory==='other'?'selected':''; ?>>Other</option>
                                </select>
                                <i data-lucide="chevron-down" class="select-icon"></i>
                            </div>
                        </div>

                        <div class="form-field">
                            <label class="form-label" for="design_price">Price (USD) *</label>
                            <div class="price-input-wrapper">
                                <span class="price-prefix">$</span>
                                <input class="form-input price-input" type="number" id="design_price" name="design_price" min="1" max="10000" step="0.01" required value="<?php echo $designPrice; ?>">
                            </div>
                            <p class="note">Minimum price: $1.00</p>
                        </div>

                        <div class="form-field" style="grid-column:1 / -1;">
                            <label class="form-label" for="design_url">Design Template URL *</label>
                            <input class="form-input" type="url" id="design_url" name="design_url" placeholder="https://example.com/your-template-link" required value="<?php echo $designUrl; ?>">
                            <p class="note">Provide a link to your design template (Figma, Adobe Creative Cloud, Canva, etc.)</p>
                        </div>

                        <div class="form-field" style="grid-column:1 / -1;">
                            <label class="form-label" for="design_photo">Replace Image (optional)</label>
                            <input class="form-input" type="file" id="design_photo" name="design_photo" accept="image/png,image/jpeg,image/webp,image/gif">
                            <span class="note">Allowed: JPG, PNG, WEBP, GIF. Max size 10MB.</span>
                        </div>
                    </div>

                    <div style="margin-top:16px;">
                        <label class="form-label">Current Image</label>
                        <div style="max-width:480px;">
                            <img id="previewImage" src="<?php echo $designPhoto; ?>" alt="Current Image" class="image-preview">
                        </div>
                    </div>

                    <div class="actions">
                        <button type="submit" class="btn btn-gradient">
                            <i data-lucide="save"></i> Save Changes
                        </button>
                        <a href="../view/view_design.php?id=<?php echo (int)$designId; ?>" class="btn btn-outline">
                            <i data-lucide="x"></i> Cancel
                        </a>
                    </div>
                </form>
            </section>
        </div>
    </main>

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
    if (window.lucide && typeof lucide.createIcons === 'function') {
        lucide.createIcons();
    }

    // Live counts
    const nameInput = document.getElementById('design_name');
    const descInput = document.getElementById('design_description');
    const nameCount = document.getElementById('name-count');
    const descCount = document.getElementById('description-count');
    const updateCount = (input, el) => el && (el.textContent = (input.value || '').length);
    nameInput && nameInput.addEventListener('input', () => updateCount(nameInput, nameCount));
    descInput && descInput.addEventListener('input', () => updateCount(descInput, descCount));

    // Preview new image on file select
    const fileInput = document.getElementById('design_photo');
    const preview = document.getElementById('previewImage');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files && this.files[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => { preview.src = e.target.result; };
            reader.readAsDataURL(file);
        });
    }

    // Keep a readable category name in sync with selected option text
    const categorySelect = document.getElementById('design_category');
    const hiddenCatName = document.getElementById('design_category_name');
    function setCategoryName() {
        const opt = categorySelect.options[categorySelect.selectedIndex];
        hiddenCatName.value = opt ? opt.text : '';
    }
    if (categorySelect && hiddenCatName) {
        categorySelect.addEventListener('change', setCategoryName);
        setCategoryName(); // init on load
    }
});
</script>
</body>
</html>