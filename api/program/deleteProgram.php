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
        'message' => 'Program ID is required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if program exists before attempting to delete
    $checkStmt = $conn->prepare("SELECT program_id FROM program WHERE program_id = ?");
    $checkStmt->execute([$data['id']]);

    if ($checkStmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Program not found'
        ]);
        exit;
    }

    // Delete program
    $stmt = $conn->prepare("DELETE FROM program WHERE program_id = ?");
    $success = $stmt->execute([$data['id']]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Program deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete program');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting program: ' . $e->getMessage()
    ]);
}
