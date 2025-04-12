<?php
// Start session with secure settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1);
session_start();

// Include database connection
require_once 'db.php';

// Regenerate session ID periodically
if (!isset($_SESSION['last_regeneration']) || time() - $_SESSION['last_regeneration'] > 1800) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}

// Function to check if user is logged in
function is_logged_in() {
    return isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && isset($_SESSION['last_activity']);
}

// Function to check if user is admin
function is_admin() {
    return is_logged_in() && $_SESSION['user_type'] === 'admin';
}

// Function to check if user is donor
function is_donor() {
    return is_logged_in() && $_SESSION['user_type'] === 'donor';
}

// Function to check if user is hospital
function is_hospital() {
    return is_logged_in() && $_SESSION['user_type'] === 'hospital';
}

// Function to get current user data
function get_user_data() {
    global $conn;
    
    if (!is_logged_in()) {
        return null;
    }
    
    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    
    $table = $user_type . 's'; // donors, hospitals, or admins
    $sql = "SELECT * FROM $table WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

// Function to require login
function require_login() {
    if (!is_logged_in()) {
        $_SESSION['error'] = "Please log in to access this page.";
        header("Location: /login.php");
        exit();
    }
    
    // Check for session timeout (30 minutes)
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
        logout_user();
        $_SESSION['error'] = "Your session has expired. Please log in again.";
        header("Location: /login.php");
        exit();
    }
    
    // Update last activity time
    $_SESSION['last_activity'] = time();
}

// Function to require admin access
function require_admin() {
    require_login();
    if (!is_admin()) {
        $_SESSION['error'] = "Access denied. Admin privileges required.";
        header("Location: /index.php");
        exit();
    }
}

// Function to require donor access
function require_donor() {
    require_login();
    if (!is_donor()) {
        $_SESSION['error'] = "Access denied. Donor account required.";
        header("Location: /index.php");
        exit();
    }
}

// Function to require hospital access
function require_hospital() {
    require_login();
    if (!is_hospital()) {
        $_SESSION['error'] = "Access denied. Hospital account required.";
        header("Location: /index.php");
        exit();
    }
}

// Function to log out user
function logout_user() {
    // Clear all session variables
    $_SESSION = array();
    
    // Destroy the session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    
    // Destroy the session
    session_destroy();
    
    // Start a new session for flash messages
    session_start();
    $_SESSION['success'] = "You have been successfully logged out.";
}

// Function to set flash message
function set_flash_message($type, $message) {
    $_SESSION['flash'][$type] = $message;
}

// Function to get and clear flash message
function get_flash_message($type) {
    if (isset($_SESSION['flash'][$type])) {
        $message = $_SESSION['flash'][$type];
        unset($_SESSION['flash'][$type]);
        return $message;
    }
    return null;
}

// Function to generate CSRF token
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

// Function to verify CSRF token
function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        set_flash_message('error', 'Invalid security token. Please try again.');
        return false;
    }
    return true;
}

// Function to check if request is POST
function is_post_request() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

// Function to redirect with message
function redirect($location, $type = 'success', $message = '') {
    if ($message) {
        set_flash_message($type, $message);
    }
    header("Location: $location");
    exit();
}

// Function to get user's role name
function get_role_name() {
    if (!is_logged_in()) {
        return 'Guest';
    }
    return ucfirst($_SESSION['user_type']);
}

// Function to get user's dashboard URL
function get_dashboard_url() {
    if (is_admin()) {
        return '/admin/dashboard.php';
    } elseif (is_donor()) {
        return '/donor/dashboard.php';
    } elseif (is_hospital()) {
        return '/hospital/dashboard.php';
    }
    return '/index.php';
}

// Initialize last activity time if not set
if (!isset($_SESSION['last_activity'])) {
    $_SESSION['last_activity'] = time();
}
?> 