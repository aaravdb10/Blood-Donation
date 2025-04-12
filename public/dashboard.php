<?php
session_start();
require_once '../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit;
}

// Get user's blood type
$stmt = $conn->prepare("SELECT blood_type FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$user_blood_type = $user['blood_type'];

// Get blood requests
$stmt = $conn->prepare("
    SELECT r.*, u.name as requester_name, u.blood_type as requester_blood_type
    FROM blood_requests r
    JOIN users u ON r.user_id = u.id
    WHERE r.status = 'pending'
    ORDER BY r.created_at DESC
");
$stmt->execute();
$requests = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get blood donations
$stmt = $conn->prepare("
    SELECT d.*, u.name as donor_name, u.blood_type as donor_blood_type
    FROM blood_donations d
    JOIN users u ON d.user_id = u.id
    WHERE d.status = 'pending'
    ORDER BY d.created_at DESC
");
$stmt->execute();
$donations = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get blood camps
$stmt = $conn->prepare("
    SELECT c.*, COUNT(b.id) as total_donations
    FROM blood_camps c
    LEFT JOIN blood_donations b ON c.id = b.camp_id
    WHERE c.status = 'active'
    GROUP BY c.id
    ORDER BY c.date DESC
");
$stmt->execute();
$camps = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get user's donation history
$stmt = $conn->prepare("
    SELECT d.*, c.name as camp_name
    FROM blood_donations d
    LEFT JOIN blood_camps c ON d.camp_id = c.id
    WHERE d.user_id = ?
    ORDER BY d.created_at DESC
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$donation_history = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get user's request history
$stmt = $conn->prepare("
    SELECT r.*
    FROM blood_requests r
    WHERE r.user_id = ?
    ORDER BY r.created_at DESC
");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$request_history = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get blood inventory
$stmt = $conn->prepare("
    SELECT blood_type, SUM(quantity) as total_quantity
    FROM blood_donations
    WHERE status = 'completed'
    GROUP BY blood_type
");
$stmt->execute();
$inventory = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Return data as JSON
header('Content-Type: application/json');
echo json_encode([
    'user_blood_type' => $user_blood_type,
    'requests' => $requests,
    'donations' => $donations,
    'camps' => $camps,
    'donation_history' => $donation_history,
    'request_history' => $request_history,
    'inventory' => $inventory
]);
?> 