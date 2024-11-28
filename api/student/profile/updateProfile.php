<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo json_encode(['success' => false, 'message' => 'Not authenticated']);
    exit();
}

// Get JSON data
$data = json_decode(file_get_contents('php://input'), true);

// Validate required fields
$required_fields = ['name', 'email', 'contact', 'gender', 'dob', 'nationality'];
foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        echo json_encode(['success' => false, 'message' => "Missing required field: $field"]);
        exit();
    }
}

try {
    require_once __DIR__ .'/../../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();
    
    // Split name into first and last name
    $name_parts = explode(' ', $data['name'], 2);
    $firstname = $name_parts[0];
    $lastname = isset($name_parts[1]) ? $name_parts[1] : '';

    $sql = "UPDATE student SET 
            firstname = ?, 
            lastname = ?, 
            email = ?, 
            contact = ?, 
            gender = ?, 
            dob = ?, 
            nationality = ? 
            WHERE student_id = ?";
            
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(1, $firstname, PDO::PARAM_STR);
    $stmt->bindValue(2, $lastname, PDO::PARAM_STR); 
    $stmt->bindValue(3, $data['email'], PDO::PARAM_STR);
    $stmt->bindValue(4, $data['contact'], PDO::PARAM_STR);
    $stmt->bindValue(5, $data['gender'], PDO::PARAM_STR);
    $stmt->bindValue(6, $data['dob'], PDO::PARAM_STR);
    $stmt->bindValue(7, $data['nationality'], PDO::PARAM_STR);
    $stmt->bindValue(8, $_SESSION['student_id'], PDO::PARAM_INT);
    
    
    if ($stmt->execute()) {
        // Update session variables
        $_SESSION['firstname'] = $firstname;
        $_SESSION['lastname'] = $lastname;
        $_SESSION['email'] = $data['email'];
        $_SESSION['contact'] = $data['contact'];
        $_SESSION['gender'] = $data['gender'];
        $_SESSION['dob'] = $data['dob'];
        $_SESSION['nationality'] = $data['nationality'];

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update profile']);
    }

    $stmt = null;
    $conn = null;

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}