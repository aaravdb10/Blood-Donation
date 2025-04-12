<?php
// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'blood_donation';

// Create connection
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set charset to utf8mb4
mysqli_set_charset($conn, "utf8mb4");

// Function to sanitize input
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}

// Function to validate email
function is_valid_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate phone number
function is_valid_phone($phone) {
    return preg_match('/^[0-9]{10}$/', $phone);
}

// Function to validate date
function is_valid_date($date) {
    $d = DateTime::createFromFormat('Y-m-d', $date);
    return $d && $d->format('Y-m-d') === $date;
}

// Function to check if user is eligible to donate
function is_eligible_to_donate($last_donation_date) {
    if (!$last_donation_date) {
        return true;
    }
    
    $last = new DateTime($last_donation_date);
    $now = new DateTime();
    $interval = $last->diff($now);
    
    // Must wait at least 56 days between donations
    return $interval->days >= 56;
}

// Function to get next eligible donation date
function get_next_eligible_date($donation_date) {
    $date = new DateTime($donation_date);
    $date->add(new DateInterval('P56D')); // Add 56 days
    return $date->format('Y-m-d');
}

// Function to format date for display
function format_date($date) {
    return date('F j, Y', strtotime($date));
}

// Function to get blood group compatibility
function get_compatible_blood_groups($blood_group) {
    $compatibility = [
        'A+' => ['A+', 'A-', 'O+', 'O-'],
        'A-' => ['A-', 'O-'],
        'B+' => ['B+', 'B-', 'O+', 'O-'],
        'B-' => ['B-', 'O-'],
        'AB+' => ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'],
        'AB-' => ['A-', 'B-', 'AB-', 'O-'],
        'O+' => ['O+', 'O-'],
        'O-' => ['O-']
    ];
    
    return $compatibility[$blood_group] ?? [];
}

// Function to create notification
function create_notification($user_type, $user_id, $title, $message, $type = 'info') {
    global $conn;
    
    $sql = "INSERT INTO notifications (user_type, user_id, title, message, type) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sisss", $user_type, $user_id, $title, $message, $type);
    
    return mysqli_stmt_execute($stmt);
}

// Function to get unread notifications count
function get_unread_notifications_count($user_type, $user_id) {
    global $conn;
    
    $sql = "SELECT COUNT(*) as count FROM notifications WHERE user_type = ? AND user_id = ? AND is_read = 0";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $user_type, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    return $row['count'];
}

// Function to mark notification as read
function mark_notification_as_read($notification_id) {
    global $conn;
    
    $sql = "UPDATE notifications SET is_read = 1 WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $notification_id);
    
    return mysqli_stmt_execute($stmt);
}
?>