<?php
/**
 * Pages API
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/database.php';
require_once '../includes/Page.php';

session_start();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$method = $_SERVER['REQUEST_METHOD'];
$db = new Database();
$page = new Page($db);

// Check if user is logged in for write operations
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
                $result = $page->getById($id);
                echo json_encode(['success' => !!$result, 'data' => $result]);
            } else {
                $limit = $_GET['limit'] ?? 10;
                $offset = $_GET['offset'] ?? 0;
                $result = $page->getAll($limit, $offset);
                echo json_encode(['success' => true, 'data' => $result]);
            }
        }
        break;
    
    case 'published':
        if ($method === 'GET') {
            $limit = $_GET['limit'] ?? 10;
            $offset = $_GET['offset'] ?? 0;
            $result = $page->getPublished($limit, $offset);
            echo json_encode(['success' => true, 'data' => $result]);
        }
        break;
    
    case 'create':
        checkAuth();
        if ($method === 'POST') {
            $data = $_POST;
            $result = $page->create(
                $data['title'] ?? '',
                $data['slug'] ?? '',
                $data['content'] ?? '',
                $data['description'] ?? '',
                $data['featured_image'] ?? '',
                $data['status'] ?? 'draft',
                $_SESSION['user']['id'],
                $data['seo_title'] ?? '',
                $data['seo_description'] ?? '',
                $data['seo_keywords'] ?? ''
            );
            echo json_encode($result);
        }
        break;
    
    case 'update':
        checkAuth();
        if ($method === 'POST' || $method === 'PUT') {
            $id = $_POST['id'] ?? $_GET['id'] ?? '';
            $data = $_POST;
            $result = $page->update(
                $id,
                $data['title'] ?? '',
                $data['slug'] ?? '',
                $data['content'] ?? '',
                $data['description'] ?? '',
                $data['featured_image'] ?? '',
                $data['status'] ?? 'draft',
                $data['seo_title'] ?? '',
                $data['seo_description'] ?? '',
                $data['seo_keywords'] ?? ''
            );
            echo json_encode(['success' => $result, 'message' => $result ? 'Page updated' : 'Failed to update']);
        }
        break;
    
    case 'delete':
        checkAuth();
        if ($method === 'POST' || $method === 'DELETE') {
            $id = $_POST['id'] ?? $_GET['id'] ?? '';
            $result = $page->delete($id);
            echo json_encode(['success' => $result, 'message' => $result ? 'Page deleted' : 'Failed to delete']);
        }
        break;
    
    default:
        echo json_encode(['error' => 'Invalid action']);
}
?>
