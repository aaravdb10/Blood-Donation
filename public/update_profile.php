<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['name']) || !isset($data['email']) || !isset($data['phone']) || !isset($data['blood_group'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Update user profile
$stmt = $conn->prepare("
    UPDATE users 
    SET name = ?, email = ?, phone = ?, blood_group = ?, updated_at = NOW()
    WHERE id = ?
");
$stmt->bind_param("ssssi", 
    $data['name'],
    $data['email'],
    $data['phone'],
    $data['blood_group'],
    $_SESSION['user_id']
);

if ($stmt->execute()) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Profile updated successfully']);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
}
?> 