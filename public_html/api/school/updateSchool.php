<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (
    !isset($data['id']) ||
    !isset($data['name']) || empty(trim($data['name'])) ||
    !isset($data['applicationCost']) || empty(($data['applicationCost'])) ||
    !isset($data['city']) || empty(trim($data['city']))
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'School ID, name, application cost and city are required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if school exists
    $checkStmt = $conn->prepare("SELECT country_id FROM school WHERE school_id = ?");
    $checkStmt->execute([$data['id']]);

    if ($checkStmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'School not found'
        ]);
        exit;
    }

    // Check if another school with same name exists in the same city
    $duplicateStmt = $conn->prepare(
        "SELECT school_id FROM school 
        WHERE school_name = ? AND school_city = ? 
        AND school_id != ?"
    );
    $duplicateStmt->execute([
        trim($data['name']),
        trim($data['city']),
        $data['id']
    ]);

    if ($duplicateStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Another school with this name already exists in this city'
        ]);
        exit;
    }

    // Update school
    $stmt = $conn->prepare(
        "UPDATE school 
        SET school_name = ?, school_city = ?, application_cost = ?
        WHERE school_id = ?"
    );
    $success = $stmt->execute([
        trim($data['name']),
        trim($data['city']),
        $data['applicationCost'],
        $data['id']
    ]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'School updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update school');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error updating school: ' . $e->getMessage()
    ]);
}
