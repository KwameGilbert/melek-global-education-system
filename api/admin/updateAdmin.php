<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../config/database.php';

try {
    // Get admin ID from session
    session_start();
    $adminId = $_SESSION['admin_id'] ?? null;
    if (!$adminId) {
        throw new Exception('Admin not logged in');
    }

    // Get JSON data
    $data = json_decode(file_get_contents("php://input"), true);
    if (empty($data)) {
        throw new Exception('No data provided');
    }

    // Validate required fields
    $requiredFields = ['firstName', 'lastName', 'email', 'contact', 'gender', 'role'];
    foreach ($requiredFields as $field) {
        if (!isset($data[$field]) || trim($data[$field]) === '') {
            throw new Exception("$field is required");
        }
    }

    // Validate email format
    if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email format');
    }

    // Validate phone number format (international)
    if (!preg_match('/^\+\d{1,4}\s?\d{6,14}$/', $data['contact'])) {
        throw new Exception('Invalid phone number format');
    }

    // Connect to database
    $db = new Database();
    $conn = $db->getConnection();
    $conn->beginTransaction();

    // Update admin information
    $query = "UPDATE admin_users SET 
        firstname = ?,
        lastname = ?,
        email = ?,
        phone = ?,
        gender = ?,
        role = ?,
        address = ?
        WHERE admin_id = ?";

    $stmt = $conn->prepare($query);
    $params = [
        $data['firstName'],
        $data['lastName'],
        $data['email'],
        $data['contact'],
        $data['gender'],
        $data['role'],
        $data['address'] ?? '',
        $adminId
    ];

    if (!$stmt->execute($params)) {
        throw new Exception('Failed to update admin information');
    }

    // Commit transaction
    $conn->commit();

    // Fetch updated user data
    $selectQuery = "SELECT * FROM admin_users WHERE admin_id = ?";
    $stmt = $conn->prepare($selectQuery);
    $stmt->execute([$adminId]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    // Format response data
    $responseData = [
        'firstName' => $userData['firstname'],
        'lastName' => $userData['lastname'],
        'email' => $userData['email'],
        'contact' => $userData['phone'],
        'gender' => $userData['gender'],
        'role' => $userData['role'],
        'address' => $userData['address'],
        'profilePhoto' => $userData['picture']
    ];

    echo json_encode([
        'status' => true,
        'message' => 'Admin information updated successfully',
        'data' => $responseData
    ]);

} catch (Exception $e) {
    if (isset($conn) && $conn->inTransaction()) {
        $conn->rollBack();
    }

    http_response_code(400);
    echo json_encode([
        'status' => false,
        'message' => $e->getMessage()
    ]);
}
