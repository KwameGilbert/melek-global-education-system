<?php
// login.php
require_once __DIR__ . '/../../config/database.php';

// Start PHP session
session_start();

// Response array
$response = [
    'status' => 'error',
    'message' => '',
    'data' => null
];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    $response['message'] = 'Method not allowed';
    echo json_encode($response);
    exit();
}

try {
    // Get POST data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Get and sanitize inputs
    $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
    $password = $data['password'] ?? '';
    $remember = $data['remember'] ?? '';

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Please enter a valid email address');
    }

    if (empty($password)) {
        throw new Exception('Password is required');
    }

    // Database connection
    $database = new Database();
    $db = $database->getConnection();

    // Check if student exists with all columns from the model
    $stmt = $db->prepare("SELECT
        a.application_id, 
        s.student_id, 
        s.firstname, 
        s.lastname, 
        s.gender,
        s.nationality,
        s.dob,
        s.contact,
        s.email, 
        s.password,
        s.created_at,
        s.update_at
        FROM student s
        JOIN application a ON s.student_id = a.student_id
        WHERE email = ?");
    
    $stmt->execute([$email]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        throw new Exception('Student email not found');
    }

    if (!password_verify($password, $student['password'])) {
        throw new Exception('Invalid password');
    }

    // Start session and store student info
    $_SESSION['student_id'] = $student['student_id'];
    $_SESSION['firstname'] = $student['firstname'];
    $_SESSION['lastname'] = $student['lastname'];
    $_SESSION['gender'] = $student['gender'];
    $_SESSION['nationality'] = $student['nationality'];
    $_SESSION['dob'] = $student['dob'];
    $_SESSION['contact'] = $student['contact'];
    $_SESSION['email'] = $student['email'];
    $_SESSION['logged_in'] = true;
    $_SESSION['application_id'] = $student['application_id'];

    if($remember){
        $cookieParams = session_get_cookie_params();
        setcookie(
            session_name(),
            session_id(),
            time() + (30 * 24 * 60 * 60), // 30 days
            $cookieParams["path"],
            $cookieParams["domain"],
            $cookieParams["secure"],
            $cookieParams["httponly"]
        );
    }

    // Update last login
    $updateStmt = $db->prepare("UPDATE student SET update_at = NOW() WHERE student_id = ?");
    $updateStmt->execute([$student['student_id']]);

    // Prepare success response
    $response['status'] = 'success';
    $response['message'] = 'Welcome back, ' . htmlspecialchars($student['firstname'] . ' ' . $student['lastname']) . '!';

    http_response_code(200);

} catch (Exception $e) {
    http_response_code(500);
    $response['message'] = 'Error:' . $e->getMessage();
    error_log("Login error: " . $e->getMessage());
}
// Clear sensitive data
unset($password, $student);

// Send JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
echo json_encode($response);
exit;
