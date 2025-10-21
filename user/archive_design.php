<?php
session_start();
include("../connections.php");

// Require login
if (!isset($_SESSION["User_ID"])) {
    header("Location: ../login.php");
    exit();
}

$User_ID = (int) $_SESSION["User_ID"];

// Require POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit("Method Not Allowed");
}

// Validate CSRF
if (empty($_POST['csrf_token']) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    header("Location: user_designs.php?error=invalid_csrf");
    exit();
}

// Validate design id
if (!isset($_POST['design_id']) || !is_numeric($_POST['design_id'])) {
    header("Location: user_designs.php?error=invalid_id");
    exit();
}

$designId = (int) $_POST['design_id'];

// Soft delete (archive) only if owned by this user
$updateStmt = $connections->prepare("
    UPDATE design
    SET Design_Status = 2
    WHERE Design_ID = ? AND User_ID = ?
    LIMIT 1
");
$updateStmt->bind_param("ii", $designId, $User_ID);

if (!$updateStmt->execute()) {
    // DB error
    $updateStmt->close();
    header("Location: user_designs.php?error=db");
    exit();
}

if ($updateStmt->affected_rows === 0) {
    // Not found or not owned
    $updateStmt->close();
    header("Location: user_designs.php?error=not_allowed");
    exit();
}

$updateStmt->close();

// Success
header("Location: user_designs.php?archived=1");
exit();