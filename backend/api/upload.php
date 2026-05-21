<?php
/**
 * File Upload API
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

session_start();

// Check authentication
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$uploadDir = '../uploads/';

if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileName = basename($file['name']);
    $fileTmp = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    
    // Allowed extensions
    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx'];
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    if (!in_array($fileExt, $allowed)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        exit;
    }
    
    if ($fileSize > 5000000) { // 5MB limit
        echo json_encode(['success' => false, 'message' => 'File too large']);
        exit;
    }
    
    if ($fileError !== UPLOAD_ERR_OK) {
        echo json_encode(['success' => false, 'message' => 'Upload error']);
        exit;
    }
    
    // Generate unique filename
    $newFileName = time() . '_' . uniqid() . '.' . $fileExt;
    $filePath = $uploadDir . $newFileName;
    
    if (move_uploaded_file($fileTmp, $filePath)) {
        echo json_encode([
            'success' => true,
            'message' => 'File uploaded successfully',
            'filename' => $newFileName,
            'url' => '/backend/uploads/' . $newFileName
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No file provided']);
}
?>
