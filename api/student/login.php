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

    // Check if student exists
    $stmt = $db->prepare("SELECT student_id, firstname, lastname, email, password FROM student WHERE email = ?");
    $stmt->execute([$email]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student || !password_verify($password, $student['password'])) {
        http_response_code(401);
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
        exit();
    }

    // Start session and store student info
    session_start();
    $_SESSION['student_id'] = $student['student_id'];
    $_SESSION['firstname'] = $student['firstname'];
    $_SESSION['lastname'] = $student['lastname'];
    $_SESSION['email'] = $student['email'];
    $_SESSION['logged_in'] = true;

    // Update last login timestamp
    $updateStmt = $db->prepare("UPDATE student SET last_login = NOW() WHERE student_id = ?");
    $updateStmt->execute([$student['student_id']]);

    // Return success response with student data (excluding sensitive info)
    echo json_encode([
        'status' => 'success',
        'message' => 'Login successful',
        'data' => [
            'student_id' => $student['student_id'],
            'firstname' => $student['firstname'],
            'lastname' => $student['lastname'],
            'email' => $student['email']
        ]
    ]);

} catch (PDOException $e) {
    error_log("Login error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'An error occurred during login']);
    exit();
}
