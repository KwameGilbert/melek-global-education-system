<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (
    !isset($data['name']) || empty(trim($data['name'])) ||
    !isset($data['city']) || empty(trim($data['city'])) ||
    !isset($data['country_id']) || empty($data['country_id'])
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'School name, city, and country are required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if school already exists in the same city
    $checkStmt = $conn->prepare("SELECT school_id FROM school WHERE school_name = ? AND school_city = ? AND country_id = ?");
    $checkStmt->execute([
        trim($data['name']),
        trim($data['city']),
        $data['country_id']
    ]);

    if ($checkStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'School already exists in this city'
        ]);
        exit;
    }

    // Verify if country exists
    $countryStmt = $conn->prepare("SELECT country_id FROM country WHERE country_id = ?");
    $countryStmt->execute([$data['country_id']]);

    if ($countryStmt->rowCount() === 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Selected country does not exist'
        ]);
        exit;
    }

    // Insert new school
    $stmt = $conn->prepare("INSERT INTO school (school_name, school_city, country_id) VALUES (?, ?, ?)");
    $success = $stmt->execute([
        trim($data['name']),
        trim($data['city']),
        $data['country_id']
    ]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'School added successfully',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        throw new Exception('Failed to add school');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error adding school: ' . $e->getMessage()
    ]);
}
