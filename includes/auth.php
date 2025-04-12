<?php
require_once 'config.php';

class Auth {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function register($email, $password, $role) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $stmt = $this->pdo->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
            $stmt->execute([$email, $hashedPassword, $role]);
            
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Registration failed: " . $e->getMessage());
        }
    }

    public function login($email, $password) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['email'] = $user['email'];
                
                return true;
            }
            
            return false;
        } catch (PDOException $e) {
            throw new Exception("Login failed: " . $e->getMessage());
        }
    }

    public function logout() {
        session_destroy();
        session_start();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getUserRole() {
        return $_SESSION['role'] ?? null;
    }

    public function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public function requireAuth() {
        if (!$this->isLoggedIn()) {
            header('Location: /login.php');
            exit();
        }
    }

    public function requireRole($role) {
        $this->requireAuth();
        if ($this->getUserRole() !== $role) {
            header('Location: /unauthorized.php');
            exit();
        }
    }

    public function resetPassword($email) {
        try {
            $token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $stmt = $this->pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
            $stmt->execute([$token, $expires, $email]);
            
            // Send reset email
            $resetLink = "https://yourdomain.com/reset-password.php?token=" . $token;
            // Implement email sending logic here
            
            return true;
        } catch (PDOException $e) {
            throw new Exception("Password reset failed: " . $e->getMessage());
        }
    }

    public function validateResetToken($token) {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_expires > NOW()");
            $stmt->execute([$token]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception("Token validation failed: " . $e->getMessage());
        }
    }

    public function updatePassword($userId, $newPassword) {
        try {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            $stmt = $this->pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
            $stmt->execute([$hashedPassword, $userId]);
            
            return true;
        } catch (PDOException $e) {
            throw new Exception("Password update failed: " . $e->getMessage());
        }
    }
}

// Initialize auth
$auth = new Auth($pdo);

function is_donor_logged_in() {
    return isset($_SESSION['donor_id']);
}

<<<<<<< HEAD

function is_admin_logged_in() {
    return isset($_SESSION['admin_id']);
}


=======
/**
 * Redirect to login if user is not logged in as donor
 */
>>>>>>> d568b944ac84451f268c25872e79ef0a9230ac2f
function require_donor_login() {
    if (!is_donor_logged_in()) {
        $_SESSION['error'] = "You must be logged in to view that page.";
        header("Location: /login.php");
        exit;
    }
}

<<<<<<< HEAD

function require_admin_login() {
    if (!is_admin_logged_in()) {
        $_SESSION['error'] = "You must be logged in as an admin to view that page.";
        header("Location: /admin_login.php");
        exit;
    }
}


=======
/**
 * Generate CSRF token for forms
 * @return string
 */
>>>>>>> d568b944ac84451f268c25872e79ef0a9230ac2f
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}


function verify_csrf_token($token) {
    if (!isset($_SESSION['csrf_token']) || $token !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}


function display_alerts() {
    $html = '';
    
    
    if (isset($_SESSION['success'])) {
        $html .= '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">';
        $html .= '<span class="block sm:inline">' . htmlspecialchars($_SESSION['success']) . '</span>';
        $html .= '</div>';
        unset($_SESSION['success']);
    }
    
    
    if (isset($_SESSION['error'])) {
        $html .= '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">';
        $html .= '<span class="block sm:inline">' . htmlspecialchars($_SESSION['error']) . '</span>';
        $html .= '</div>';
        unset($_SESSION['error']);
    }
    
    return $html;
}
