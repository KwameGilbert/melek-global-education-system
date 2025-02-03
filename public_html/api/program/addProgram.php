<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../config/database.php';

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (
    !isset($data['name']) || empty(trim($data['name'])) ||
    !isset($data['degreeType']) || empty($data['degreeType']) ||
    !isset($data['school_id']) || empty($data['school_id'])
) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Program name, degree type, and school are required'
    ]);
    exit;
}

$db = new Database();
$conn = $db->getConnection();

try {
    // Check if program already exists in the same school
    $checkStmt = $conn->prepare("SELECT program_id FROM program WHERE program_name = ? AND program_degree = ? AND school_id = ?");
    $checkStmt->execute([
        trim($data['name']),
        $data['degreeType'],
        $data['school_id']
    ]);

    if ($checkStmt->rowCount() > 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Program already exists in this school'
        ]);
        exit;
    }

    // Verify if school exists
    $schoolStmt = $conn->prepare("SELECT school_id FROM school WHERE school_id = ?");
    $schoolStmt->execute([$data['school_id']]);

    if ($schoolStmt->rowCount() === 0) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Selected school does not exist'
        ]);
        exit;
    }

    // Insert new program
    $stmt = $conn->prepare("INSERT INTO program (program_name, program_degree, school_id) VALUES (?, ?, ?)");
    $success = $stmt->execute([
        trim($data['name']),
        $data['degreeType'],
        $data['school_id']
    ]);

    if ($success) {
        echo json_encode([
            'success' => true,
            'message' => 'Program added successfully',
            'id' => $conn->lastInsertId()
        ]);
    } else {
        throw new Exception('Failed to add program');
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error adding program: ' . $e->getMessage()
    ]);
}
