<?php
// Include database connection
require_once __DIR__ . '/../../config/database.php';
$db = new Database();
$conn = $db->getConnection();

// Check if applicant ID is provided
if (!isset($_GET['id'])) {
    $response = [
        'status' => 'error',
        'message' => 'Applicant ID is required'
    ];
    echo json_encode($response);
    exit;
}

$applicant_id = $_GET['id'];

try {
    // Prepare SQL statement
    $sql = "SELECT * FROM application_details JOIN application ON application_details.application_id = application.application_id JOIN payment ON appliWHERE application_details.application_id = :id";
    $stmt = $conn->prepare($sql);

    // Bind parameters
    $stmt->bindParam(':id', $applicant_id);

    // Execute query
    $stmt->execute();

    // Fetch the data as associative array
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        $data = [
            'status' => 'error',
            'message' => 'No applicant found with this ID'
        ];
    }
} catch (PDOException $e) {
    $data = [
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ];
}

// Don't echo or return anything - the including script will use $data
