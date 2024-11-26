<?php
require_once __DIR__. '/../../../config/database.php';

// Start session to get student ID
session_start();

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Response array
$response = [
    'applicantID' => null,
    'applicationStatus' => null,
    'paymentStatus' => null,
    'profileComplete' => false
];

try {
    // Check if user is logged in
    if (!isset($_SESSION['student_id'])) {
        throw new Exception('Unauthorized access');
    }

    $studentId = $_SESSION['student_id'];

    // Get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Get application details with joins
    $stmt = $db->prepare("SELECT 
        a.application_id,
        a.status as application_status,
        p.payment_status,
        s.*
        FROM application a
        LEFT JOIN payment p ON p.application_id = a.application_id
        LEFT JOIN student s ON s.student_id = a.student_id
        WHERE a.student_id = ?
        ORDER BY a.created_at DESC 
        LIMIT 1");

    $stmt->execute([$studentId]);
    $application = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($application) {
        $profileComplete = true;
        foreach ($application as $key => $value) {
            if ($value === null) {
                $profileComplete = false;
                break;
            }
        }

        $response = [
            'applicantID' => $application['application_id'],
            'applicationStatus' => $application['application_status'],
            'paymentStatus' => $application['payment_status'] ?? 'Pending',
            'profileComplete' => $profileComplete
        ];
    }

    http_response_code(200);

} catch (PDOException $e) {
    http_response_code(500);
    error_log("Database error: " . $e->getMessage());
    $response = ['error' => 'A database error occurred'];
} catch (Exception $e) {
    http_response_code(401);
    $response = ['error' => $e->getMessage()];
}

// Send response
echo json_encode($response);
exit;
