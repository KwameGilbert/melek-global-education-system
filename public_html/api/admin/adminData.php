<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

try {
    // Get admin ID from session or request
    session_start();
    $adminId = $_SESSION['admin_id'] ?? null;

    if (!$adminId) {
        throw new Exception('Admin not logged in');
    }

    // Fetch admin data from database
    $query = "
        SELECT 
            a.admin_id,
            a.firstname,
            a.lastname,
            a.email,
            a.phone,
            a.address,
            a.gender,
            a.role,
            a.picture
        FROM admin_users a
        WHERE a.admin_id = :admin_id
    ";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':admin_id', $adminId);
    $stmt->execute();
    $adminData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($adminData) {
        // Format the response
        $response = [
            'status' => true,
            'message' => 'Admin data retrieved successfully',
            'data' => [
                'firstName' => $adminData['firstname'],
                'lastName' => $adminData['lastname'],
                'email' => $adminData['email'],
                'contact' => $adminData['phone'],
                'address' => $adminData['address'],
                'gender' => $adminData['gender'],
                'role' => $adminData['role'],
                'profilePhoto' => $adminData['picture']
            ]
        ];
    } else {
        throw new Exception('Admin not found');
    }

} catch (Exception $e) {
    $response = [
        'status' => false,
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);