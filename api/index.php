<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

header('Content-Type: application/json');

// Get request method and path
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$path = str_replace('/api/', '', $path);

// Handle CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

if ($method === 'OPTIONS') {
    exit(0);
}

// API Routes
switch ($path) {
    case 'auth/login':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            if ($auth->login($data['email'], $data['password'])) {
                echo json_encode(['success' => true, 'message' => 'Login successful']);
            } else {
                http_response_code(401);
                echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
            }
        }
        break;

    case 'auth/register':
        if ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            try {
                $userId = $auth->register($data['email'], $data['password'], $data['role']);
                echo json_encode(['success' => true, 'message' => 'Registration successful', 'userId' => $userId]);
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        break;

    case 'donors':
        $auth->requireAuth();
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM donors");
            echo json_encode($stmt->fetchAll());
        }
        break;

    case 'hospitals':
        $auth->requireAuth();
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM hospitals");
            echo json_encode($stmt->fetchAll());
        }
        break;

    case 'blood-inventory':
        $auth->requireAuth();
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM blood_inventory");
            echo json_encode($stmt->fetchAll());
        }
        break;

    case 'donations':
        $auth->requireAuth();
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM donations");
            echo json_encode($stmt->fetchAll());
        } elseif ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO donations (donor_id, hospital_id, donation_date, blood_type, quantity, status) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['donor_id'],
                $data['hospital_id'],
                $data['donation_date'],
                $data['blood_type'],
                $data['quantity'],
                $data['status']
            ]);
            echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        }
        break;

    case 'blood-requests':
        $auth->requireAuth();
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM blood_requests");
            echo json_encode($stmt->fetchAll());
        } elseif ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO blood_requests (hospital_id, blood_type, quantity, urgency, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['hospital_id'],
                $data['blood_type'],
                $data['quantity'],
                $data['urgency'],
                $data['status']
            ]);
            echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        }
        break;

    case 'blood-drives':
        $auth->requireAuth();
        if ($method === 'GET') {
            $stmt = $pdo->query("SELECT * FROM blood_drives");
            echo json_encode($stmt->fetchAll());
        } elseif ($method === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO blood_drives (hospital_id, title, description, location, start_date, end_date, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['hospital_id'],
                $data['title'],
                $data['description'],
                $data['location'],
                $data['start_date'],
                $data['end_date'],
                $data['status']
            ]);
            echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
        }
        break;

    default:
        http_response_code(404);
        echo json_encode(['success' => false, 'message' => 'Endpoint not found']);
        break;
}
?> 