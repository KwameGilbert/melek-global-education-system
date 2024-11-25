<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit();
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
    exit();
}

$email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
$password = $data['password'];

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname",
        $username,
        $password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );

    // Check if student exists with all columns from the model
    $stmt = $db->prepare("SELECT 
        student_id, 
        firstname, 
        lastname, 
        gender,
        nationality,
        dob,
        contact,
        email, 
        password,
        created_at,
        update_at
        FROM student 
        WHERE email = ?");
    $stmt->execute([$email]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Student email not found']);
        exit();
    } elseif (!password_verify($password, $student['password'])) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        exit();
    }

    // Start session and store student info
    session_start();
    $_SESSION['student_id'] = $student['student_id'];
    $_SESSION['firstname'] = $student['firstname'];
    $_SESSION['lastname'] = $student['lastname'];
    $_SESSION['gender'] = $student['gender'];
    $_SESSION['nationality'] = $student['nationality'];
    $_SESSION['dob'] = $student['dob'];
    $_SESSION['contact'] = $student['contact'];
    $_SESSION['email'] = $student['email'];
    $_SESSION['logged_in'] = true;

    // Update last login by modifying update_at
    $updateStmt = $db->prepare("UPDATE student SET update_at = NOW() WHERE student_id = ?");
    $updateStmt->execute([$student['student_id']]);

    // Return success response with student data (excluding sensitive info)
    http_response_code(200);
    echo json_encode([
        'status' => 'success',
        'message' => 'Login successful',
        'data' => [
            'student_id' => $student['student_id'],
            'firstname' => $student['firstname'],
            'lastname' => $student['lastname'],
            'gender' => $student['gender'],
            'nationality' => $student['nationality'],
            'dob' => $student['dob'],
            'contact' => $student['contact'],
            'email' => $student['email'],
            'created_at' => $student['created_at'],
            'update_at' => $student['update_at']
        ]
    ]);

} catch (PDOException $e) {
    error_log("Login error: " . $e->getMessage());
 //   http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit();
}
