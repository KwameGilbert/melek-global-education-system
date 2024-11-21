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
        'message' => 'Country ID is required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if country has associated schools
    $checkStmt = $conn->prepare("SELECT school_id FROM school WHERE country_id = ?");
    $checkStmt->execute([$data['id']]);

    if ($checkStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Cannot delete country: It has associated schools'
        ]);
        exit;
    }

    // Delete country
    $stmt = $conn->prepare("DELETE FROM country WHERE country_id = ?");
    $success = $stmt->execute([$data['id']]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Country deleted successfully'
        ]);
    } else {
        throw new Exception('Failed to delete country');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error deleting country: ' . $e->getMessage()
    ]);
}
