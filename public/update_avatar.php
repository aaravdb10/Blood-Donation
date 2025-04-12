<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

// Check if file was uploaded
if (!isset($_FILES['avatar'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit;
}

$file = $_FILES['avatar'];

// Validate file
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
if (!in_array($file['type'], $allowed_types)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG and GIF are allowed']);
    exit;
}

if ($file['size'] > 5000000) { // 5MB max
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'File size too large. Maximum size is 5MB']);
    exit;
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $extension;
$upload_path = '../uploads/avatars/' . $filename;

// Create directory if it doesn't exist
if (!file_exists('../uploads/avatars')) {
    mkdir('../uploads/avatars', 0777, true);
}

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $upload_path)) {
    // Update database
    $avatar_path = 'uploads/avatars/' . $filename;
    $stmt = $conn->prepare("UPDATE users SET avatar = ? WHERE id = ?");
    $stmt->bind_param("si", $avatar_path, $_SESSION['user_id']);

    if ($stmt->execute()) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'message' => 'Avatar updated successfully', 'avatar' => $avatar_path]);
    } else {
        // Delete uploaded file if database update fails
        unlink($upload_path);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Failed to update avatar']);
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
}
?> 