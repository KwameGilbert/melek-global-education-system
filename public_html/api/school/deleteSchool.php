<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['id'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'School ID is required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if school has associated programs
    $checkStmt = $conn->prepare("SELECT program_id FROM program WHERE school_id = ?");
    $checkStmt->execute([$data['id']]);

    if ($checkStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Cannot delete school: It has associated programs'
        ]);
        exit;
    }

    // Delete school
    $stmt = $conn->prepare("DELETE FROM school WHERE school_id = ?");
    $success = $stmt->execute([$data['id']]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'School deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete school');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting school: ' . $e->getMessage()
    ]);
}
