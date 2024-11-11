<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/database.php';

// Initialize response array
$response = [
    'status' => false,
    'metric' => [],
    'message' => ''
];

try {
    // Database connection
    $database = new Database();
    $db = $database->getConnection();

    // Query to fetch data
    $query = "
        SELECT 
            (SELECT COUNT(*) FROM application) AS totalApplicants,
            (SELECT COUNT(*) FROM application WHERE status = 'admitted') AS totalAdmitted,
            (SELECT COUNT(*) FROM application WHERE status = 'processing') AS totalProcessing,
            (SELECT COUNT(*) FROM application WHERE status = 'rejected') AS totalRejected,
            (SELECT COUNT(*) FROM application WHERE status = 'pending payment') AS pendingPayment,
            (SELECT COUNT(*) FROM application WHERE status = 'pending processing') AS pendingProcessing
    ";

    $stmt = $db->prepare($query);
    $stmt->execute();

    // Fetch data
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set success response
    $response['status'] = true;
    $response['metric'] = $data;
} catch (Exception $e) {
    // Set error response
    $response['message'] = 'An error occurred while fetching data.';
    // Log the actual error for debugging purposes
    error_log($e->getMessage());
}

// Send JSON response
echo json_encode($response);