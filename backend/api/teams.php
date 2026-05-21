<?php
/**
 * Teams API
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';
require_once '../includes/Team.php';

session_start();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$db = new Database();
$team = new Team($db);

function checkAuth() {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['success' => false, 'message' => 'Unauthorized']);
        exit;
    }
}

switch ($action) {
    case 'get':
        if ($method === 'GET') {
            $id = $_GET['id'] ?? '';
            if ($id) {
                $result = $team->getById($id);
                echo json_encode(['success' => !!$result, 'data' => $result]);
            } else {
                $result = $team->getAll();
                echo json_encode(['success' => true, 'data' => $result]);
            }
        }
        break;
    
    case 'create':
        checkAuth();
        if ($method === 'POST') {
            $data = $_POST;
            $result = $team->create(
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['logo'] ?? '',
                $data['coach_name'] ?? '',
                $data['status'] ?? 'active'
            );
            echo json_encode($result);
        }
        break;
    
    case 'update':
        checkAuth();
        if ($method === 'POST' || $method === 'PUT') {
            $id = $_POST['id'] ?? $_GET['id'] ?? '';
            $data = $_POST;
            $result = $team->update(
                $id,
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['logo'] ?? '',
                $data['coach_name'] ?? '',
                $data['status'] ?? 'active'
            );
            echo json_encode(['success' => $result, 'message' => $result ? 'Team updated' : 'Failed to update']);
        }
        break;
    
    case 'delete':
        checkAuth();
        if ($method === 'POST' || $method === 'DELETE') {
            $id = $_POST['id'] ?? $_GET['id'] ?? '';
            $result = $team->delete($id);
            echo json_encode(['success' => $result, 'message' => $result ? 'Team deleted' : 'Failed to delete']);
        }
        break;
    
    default:
        echo json_encode(['error' => 'Invalid action']);
}
?>
