<?php
require_once '../../../config/database.php';

// Start session to get student ID
session_start();

// Set headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

try {
    // Check if user is logged in
    if (!isset($_SESSION['student_id'])) {
        throw new Exception('Unauthorized access');
    }

    $studentId = $_SESSION['student_id'];

    // Get database connection
    $database = new Database();
    $db = $database->getConnection();

    // Get the student's latest application ID
    $appStmt = $db->prepare("
        SELECT application_id 
        FROM application 
        WHERE student_id = ? 
        ORDER BY created_at DESC 
        LIMIT 1
    ");
    $appStmt->execute([$studentId]);
    $applicationId = $appStmt->fetchColumn();

    if (!$applicationId) {
        echo json_encode([]);
        exit;
    }

    // Get updates for the application
    $stmt = $db->prepare("
        SELECT 
            id,
            title,
            message,
            DATE(datetime) as date,
            TIME_FORMAT(datetime, '%h:%i %p') as time
        FROM `update`
        WHERE application_id = ?
        ORDER BY datetime DESC
    ");

    $stmt->execute([$applicationId]);
    $updates = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format the updates to match the notices.json structure
    $formattedUpdates = array_map(function($update) {
        return [
            'id' => (int)$update['id'],
            'title' => $update['title'],
            'message' => $update['message'],
            'date' => $update['date'],
            'time' => $update['time']
        ];
    }, $updates);

    http_response_code(200);
    echo json_encode($formattedUpdates);

} catch (PDOException $e) {
    http_response_code(500);
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['error' => 'A database error occurred']);
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode(['error' => $e->getMessage()]);
}
exit;
