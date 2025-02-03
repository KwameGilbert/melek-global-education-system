<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';

$response = [
    'status' => 'error',
    'message' => '',
    'image_url' => ''
];

if (!isset($_SESSION['student_id'])) {
    $response['message'] = 'Unauthorized';
    http_response_code(401);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Method not allowed';
    http_response_code(405);
    echo json_encode($response);
    exit;
}

try {
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('No image uploaded or upload error');
    }

    $file = $_FILES['image'];
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Invalid file type. Only JPG, PNG, and GIF are allowed');
    }

    // Create upload directory if it doesn't exist
    $uploadDir = __DIR__ . '/../../../public/student/dashboard/images/student_profiles/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'student_' . $_SESSION['student_id'] . '_' . time() . '.' . $extension;
    $filepath = $uploadDir . $filename;

    // Move uploaded file
    if (!move_uploaded_file($file['tmp_name'], $filepath)) {
        throw new Exception('Failed to save image');
    }

    // Update database with new image path
    $database = new Database();
    $db = $database->getConnection();

    $stmt = $db->prepare("UPDATE student SET profile_image = ? WHERE student_id = ?");
    $imageUrl = './images/student_profiles/' . $filename;
    $stmt->execute([$imageUrl, $_SESSION['student_id']]);

    $_SESSION['profile_image'] = $imageUrl;
    $response['status'] = 'success';
    $response['message'] = 'Profile image updated successfully';
    $response['image_url'] = $imageUrl;
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    http_response_code(500);
}

header('Content-Type: application/json');
echo json_encode($response);
