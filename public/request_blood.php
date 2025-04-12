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
if (!isset($data['blood_type']) || !isset($data['quantity']) || !isset($data['urgency']) || !isset($data['hospital'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'All fields are required']);
    exit;
}

// Insert blood request
$stmt = $conn->prepare("
    INSERT INTO blood_requests (
        user_id, blood_type, quantity, urgency, hospital, status, created_at
    ) VALUES (?, ?, ?, ?, ?, 'pending', NOW())
");
$stmt->bind_param("isiss", 
    $_SESSION['user_id'],
    $data['blood_type'],
    $data['quantity'],
    $data['urgency'],
    $data['hospital']
);

if ($stmt->execute()) {
    header('Content-Type: application/json');
    echo json_encode(['success' => true, 'message' => 'Blood request submitted successfully']);
} else {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Failed to submit blood request']);
}
?> 