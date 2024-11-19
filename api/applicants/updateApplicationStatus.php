<?php

require __DIR__ . '/../../config/database.php';

$response = [
    'status' => 'false',
    'message' => 'Error, Something went wrong!'
];

$db = new Database();
$conn = $db->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the raw input
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['application_id']) || !isset($data['application_status'])) {
        $response = [
            'status' => 'false',
            'message' => 'Both application_id and application_status are required'
        ];
        echo json_encode($response);
        exit;
    }

    $applicationId = $data['application_id'];
    $applicationStatus = $data['application_status'];

    $sql = 'UPDATE application SET status = :status WHERE application_id = :id';

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':status', $applicationStatus, PDO::PARAM_STR);
        $stmt->bindParam(':id', $applicationId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $response = [
                'status' => true,
                'message' => 'Application status updated successfully'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to update application status'
            ];
        }
    } catch (PDOException $e) {
        error_log('Database error: ' . $e->getMessage());
        $response = [
            'status' => false,
            'message' => $e->getMessage()
        ];
    }
}

echo json_encode($response);
return $response;
