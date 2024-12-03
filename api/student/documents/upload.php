<?php
session_start();
require_once __DIR__ . '/../../../config/database.php';

$response = [
    'success' => false,
    'message' => '',
    'file_url' => ''
];

// Check if the user is authenticated
if (!isset($_SESSION['student_id'], $_SESSION['application_id'])) {
    $response['message'] = 'Unauthorized';
    http_response_code(401);
    echo json_encode($response);
    exit;
}

// Ensure the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $response['message'] = 'Method not allowed';
    http_response_code(405);
    echo json_encode($response);
    exit;
}

try {
    // Check for file upload
    if (empty($_FILES) || count($_FILES) === 0) {
        throw new Exception('No file uploaded');
    }

    // Validate uploaded file
    $fileKey = key($_FILES);
    $file = $_FILES[$fileKey];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('File upload error: ' . $file['error']);
    }

    // Allowable file types
    $allowedTypes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/bmp',
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];
    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception('Invalid file type.');
    }

    // Validate file size (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        throw new Exception('File size too large. Maximum size is 5MB');
    }

    // Student information from session
    $studentId = $_SESSION['student_id'];
    $studentName = strtolower(str_replace(' ', '-', $_SESSION['firstname'] . " " . $_SESSION['lastname'] )); // Normalize name
    $applicationId = $_SESSION['application_id']; 

    // Prepare upload directory
    $uploadDir = __DIR__ . "/../../../public/student/includes/application/documents/{$studentName}-{$applicationId}/";
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Generate unique file name
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = "{$studentName}-{$applicationId}-{$fileKey}.{$extension}";
    $filepath = "includes/application/documents/{$studentName}-{$applicationId}/"  . $filename;

    // Move uploaded file to destination
    if (!move_uploaded_file($file['tmp_name'], __DIR__ .'/../../../public/student/'.$filepath)) {
        throw new Exception('Failed to save file.');
    }

    // Database connection
    $database = new Database();
    $db = $database->getConnection();

    // Check if the record already exists
    $stmt = $db->prepare("SELECT id FROM student_files WHERE student_id = ? AND application_id = ? AND file_type = ?");
    $stmt->execute([$studentId, $applicationId, $fileKey]);
    $fileRecord = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($fileRecord) {
        // Update the existing record with the new file path
        $stmt = $db->prepare("UPDATE student_files SET file_path = ? WHERE id = ?");
        $stmt->execute([$filepath, $fileRecord['id']]);
    } else {
        // Insert a new record
        $stmt = $db->prepare("INSERT INTO student_files (student_id, application_id, file_type, file_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$studentId, $applicationId, $fileKey, $filepath]);
    }

    // Success response
    $response['success'] = true;
    $response['message'] = ucfirst($fileKey) . ' uploaded successfully.';
    $response['file_url'] = $filepath; // Relative path for frontend

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
    http_response_code(500);
}

header('Content-Type: application/json');
echo json_encode($response);
