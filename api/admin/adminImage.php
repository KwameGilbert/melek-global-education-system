<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../config/database.php';

try {
    // Check if file was uploaded
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('No image file uploaded or upload error');
    }

    // Get admin ID from session
    session_start();
    $adminId = $_SESSION['admin_id'] ?? null;
    if (!$adminId) {
        throw new Exception('Admin not logged in');
    }

    // Validate file
    $file = $_FILES['image'];
    $fileInfo = pathinfo($file['name']);
    $extension = strtolower($fileInfo['extension']);
    
    // Validate extension
    $allowedExtensions = ['jpg', 'jpeg', 'png'];
    if (!in_array($extension, $allowedExtensions)) {
        throw new Exception('Invalid file type. Allowed types: ' . implode(', ', $allowedExtensions));
    }

    // Validate file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('File size too large. Maximum size is 5MB');
    }

    // Create upload directory if it doesn't exist
    $uploadDir = __DIR__ . '/../../public/admin/dashboard/images/admin/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generate filename using admin ID
    $filename = 'admin_' . $adminId . '.' . $extension;
    $targetPath = $uploadDir . $filename;

    // Remove old image if exists
    if (file_exists($targetPath)) {
        unlink($targetPath);
    }

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception('Failed to move uploaded file');
    }

    // Update database with new image path
    $db = new Database();
    $conn = $db->getConnection();
    
    $imagePath = './images/admin/' . $filename;
    $query = "UPDATE admin_users SET picture = ? WHERE admin_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt->execute([$imagePath, $adminId])) {
        throw new Exception('Failed to update database with new image path');
    }

    echo json_encode([
        'status' => true,
        'message' => 'Image uploaded successfully',
        'data' => ['profilePhoto' => $imagePath]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
