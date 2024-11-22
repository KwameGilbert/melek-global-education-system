<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

try {
    // Get admin ID from session
    session_start();
    $adminId = $_SESSION['admin_id'] ?? null;

    if (!$adminId) {
        throw new Exception('Admin not logged in');
    }

    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);

    if (!$data) {
        throw new Exception('No data provided');
    }

    // Prepare update query
    $query = "
        UPDATE admin_users SET
            firstname = :firstName,
            lastname = :lastName,
            email = :email,
            phone = :contact,
            address = :address,
            gender = :gender,
            role = :role
        WHERE admin_id = :admin_id
    ";

    $stmt = $conn->prepare($query);
    
    // Bind parameters
    $stmt->bindParam(':firstName', $data['firstName']);
    $stmt->bindParam(':lastName', $data['lastName']);
    $stmt->bindParam(':email', $data['email']);
    $stmt->bindParam(':contact', $data['contact']);
    $stmt->bindParam(':address', $data['address']);
    $stmt->bindParam(':gender', $data['gender']);
    $stmt->bindParam(':role', $data['role']);
    $stmt->bindParam(':admin_id', $adminId);

    if ($stmt->execute()) {
        $response = [
            'status' => true,
            'message' => 'Admin data updated successfully',
            'data' => $data
        ];
    } else {
        throw new Exception('Failed to update admin data');
    }

} catch (Exception $e) {
    $response = [
        'status' => false,
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
