<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (empty($data['currentPassword']) || empty($data['newPassword'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields']);
    exit();
}

try {
    require_once __DIR__ . '/../../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    // First verify current password
    $sql = "SELECT password FROM student WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_SESSION['student_id']]);
    $result = $stmt->fetch();

    if (!password_verify($data['currentPassword'], $result['password'])) {
        echo json_encode(['success' => false, 'message' => 'Current password is incorrect']);
        exit();
    }

    // Update password
    $new_password_hash = password_hash($data['newPassword'], PASSWORD_DEFAULT);
    $sql = "UPDATE student SET password = ? WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$new_password_hash, $_SESSION['student_id']]);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update password']);
    }

    $stmt = null;
    $conn = null;
    
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error']);
}
