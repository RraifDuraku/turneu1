<?php
/**
 * Authentication API
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';
require_once '../includes/User.php';

session_start();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$db = new Database();
$user = new User($db);

switch ($action) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            
            $result = $user->login($username, $password);
            
            if ($result['success']) {
                $_SESSION['user'] = $result['user'];
                echo json_encode(['success' => true, 'message' => 'Login successful', 'user' => $result['user']]);
            } else {
                echo json_encode(['success' => false, 'message' => $result['message']]);
            }
        }
        break;
    
    case 'logout':
        session_destroy();
        echo json_encode(['success' => true, 'message' => 'Logout successful']);
        break;
    
    case 'register':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $fullname = $_POST['fullname'] ?? '';
            
            $result = $user->register($username, $email, $password, $fullname);
            echo json_encode($result);
        }
        break;
    
    case 'check':
        if (isset($_SESSION['user'])) {
            echo json_encode(['loggedIn' => true, 'user' => $_SESSION['user']]);
        } else {
            echo json_encode(['loggedIn' => false]);
        }
        break;
    
    default:
        echo json_encode(['error' => 'Invalid action']);
}
?>
