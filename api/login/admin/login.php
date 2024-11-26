<?php
// login.php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/database.php';

// Start PHP session
session_start();

// Response array
$response = [
    'status' => false,
    'message' => '',
    'icon' => 'error'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get and sanitize inputs
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address');
        }

        // Database connection
        $database = new Database();
        $db = $database->getConnection();

        // Get user from database
        $stmt = $db->prepare("
            SELECT 
                admin_id,
                firstname,
                lastname,
                email,
                phone,
                address,
                gender,
                password,
                role,
                picture
            FROM admin_users 
            WHERE email = ?
        ");

        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify user exists and password is correct
        if (!$user) {
            throw new Exception('User not found');
        }else if(!password_verify($password, $user['password'])){
            throw new Exception('Wrong Password');
        }
 
        // Set user session
        $_SESSION['admin_id'] = $user['admin_id'];
        $_SESSION['firstname'] = $user['firstname'];
        $_SESSION['lastname'] = $user['lastname'];
        $_SESSION['admin_name'] = $user['firstname'] . ' ' . $user['lastname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['phone'] = $user['phone'];
        $_SESSION['address'] = $user['address'];
        $_SESSION['gender'] = $user['gender'];
        $_SESSION['picture'] = $user['picture'];
        $_SESSION['role'] = $user['role'];

        // If "Remember Me" is checked, set a persistent session
        if ($remember) {
            // Extend session expiration for "Remember Me"
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

        // Set success response
        $response['status'] = true;
        $response['message'] = 'Welcome back, ' . htmlspecialchars($user['firstname'] . ' ' . $user['lastname']) . '!';
        $response['icon'] = 'success';
        $response['redirect'] = '../dashboard/';
    } catch (Exception $e) {
        // In production, consider using a generic error message
        $response['message'] = 'Error '. $e->getMessage();
        // Log the actual error for debugging purposes
        error_log($e->getMessage());
    }
} else {
    $response['message'] = 'Invalid request method';
}

// Clear sensitive data
unset($password, $user);

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
