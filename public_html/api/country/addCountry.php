<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['name']) || empty(trim($data['name']))) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Country name is required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if country already exists
    $checkStmt = $conn->prepare("SELECT country_id FROM country WHERE country_name = ?");
    $checkStmt->execute([$data['name']]);

    if ($checkStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Country already exists'
        ]);
        exit;
    }

    // Insert new country
    $stmt = $conn->prepare("INSERT INTO country (country_name) VALUES (?)");
    $success = $stmt->execute([trim($data['name'])]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Country added successfully',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        throw new Exception('Failed to add country');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error adding country: ' . $e->getMessage()
    ]);
}
