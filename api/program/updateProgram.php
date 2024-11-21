<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (
    !isset($data['id']) ||
    !isset($data['name']) || empty(trim($data['name'])) ||
    !isset($data['degreeType']) || empty(trim($data['degreeType']))
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Program ID, name, and degree type are required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if program exists
    $checkStmt = $conn->prepare("SELECT school_id FROM program WHERE program_id = ?");
    $checkStmt->execute([$data['id']]);

    if ($checkStmt->rowCount() === 0) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Program not found'
        ]);
        exit;
    }

    // Check if another program with same name exists in the same school
    $duplicateStmt = $conn->prepare(
        "SELECT program_id FROM program 
        WHERE program_name = ? AND program_degree = ? 
        AND school_id = (SELECT school_id FROM program WHERE program_id = ?)
        AND program_id != ?"
    );
    $duplicateStmt->execute([
        trim($data['name']),
        trim($data['degreeType']),
        $data['id'],
        $data['id']
    ]);

    if ($duplicateStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Another program with this name already exists in this school'
        ]);
        exit;
    }

    // Update program
    $stmt = $conn->prepare(
        "UPDATE program 
        SET program_name = ?, program_degree = ?
        WHERE program_id = ?"
    );
    $success = $stmt->execute([
        trim($data['name']),
        trim($data['degreeType']),
        $data['id']
    ]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Program updated successfully'
        ]);
    } else {
        throw new Exception('Failed to update program');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error updating program: ' . $e->getMessage()
    ]);
}
