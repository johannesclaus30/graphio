<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json'); // for proper JSON output

include("../connections.php");
session_start();

$User_ID = isset($_SESSION["User_ID"]) ? $_SESSION["User_ID"] : 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // --- File upload setup ---
    $targetDir = "../user/uploads/designs/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

    $photoName = basename($_FILES["Design_Photo"]["name"]);
    $targetFilePath = $targetDir . uniqid("design_") . "_" . $photoName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

    // --- Validate file type ---
    $allowedTypes = ["jpg", "jpeg", "png"];
    if (!in_array($imageFileType, $allowedTypes)) {
        echo json_encode(["status" => "error", "message" => "Invalid file type. Only JPG, PNG, JPEG allowed."]);
        exit;
    }

    // --- Move file ---
    if (!move_uploaded_file($_FILES["Design_Photo"]["tmp_name"], $targetFilePath)) {
        echo json_encode(["status" => "error", "message" => "Failed to upload image."]);
        exit;
    }

    // --- Collect form data ---
    $Design_Name = mysqli_real_escape_string($connections, $_POST["Design_Name"]);
    $Design_Description = mysqli_real_escape_string($connections, $_POST["Design_Description"]);
    $Design_Category = mysqli_real_escape_string($connections, $_POST["Design_Category_Name"]);
    $Design_Price = floatval($_POST["Design_Price"]);
    $Design_URL = mysqli_real_escape_string($connections, $_POST["Design_Url"]);
    date_default_timezone_set("Asia/Manila");
    $Design_Created_At = date("Y-m-d H:i:s");
    $Design_Status = "1"; // Active by default

    // --- Insert design record ---
    $insertDesign = "INSERT INTO design 
        (User_ID, Design_Name, Design_Description, Design_Category, Design_Price, Design_Photo, Design_URL, Design_Created_At, Design_Status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($connections, $insertDesign);
    mysqli_stmt_bind_param($stmt, "isssdssss", 
        $User_ID, $Design_Name, $Design_Description, $Design_Category, $Design_Price, $targetFilePath, $Design_URL, $Design_Created_At, $Design_Status
    );

    if (mysqli_stmt_execute($stmt)) {
        $Design_ID = mysqli_insert_id($connections); // <-- get the inserted Design_ID

        // --- Insert default rating ---
        $insertRating = "INSERT INTO rating (Design_ID, Design_Rate) VALUES (?, 0.0)";
        $stmtRating = mysqli_prepare($connections, $insertRating);
        mysqli_stmt_bind_param($stmtRating, "i", $Design_ID);
        mysqli_stmt_execute($stmtRating);
        mysqli_stmt_close($stmtRating);

        echo json_encode(["status" => "success", "message" => "Design uploaded successfully!"]);

    } else {
        echo json_encode(["status" => "error", "message" => "Database error while inserting design."]);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($connections);
}
?>
