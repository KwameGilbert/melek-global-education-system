<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['id']) || !isset($data['name']) || empty(trim($data['name']))) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Country ID and name are required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if the new name already exists for another country
    $checkStmt = $conn->prepare("SELECT country_id FROM country WHERE country_name = ? AND country_id != ?");
    $checkStmt->execute([trim($data['name']), $data['id']]);

    if ($checkStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'A country with this name already exists'
        ]);
        exit;
    }

    // Update country
    $stmt = $conn->prepare("UPDATE country SET country_name = ? WHERE country_id = ?");
    $success = $stmt->execute([trim($data['name']), $data['id']]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Country updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update country');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error updating country: ' . $e->getMessage()
    ]);
}
