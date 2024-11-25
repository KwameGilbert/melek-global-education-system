<?php
require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/database.php';

// Response array
$response = [
    'status' => false,
    'message' => '',
    'icon' => 'error'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get and sanitize inputs
        $firstname = filter_var($_POST['firstname'] ?? '', FILTER_SANITIZE_STRING);
        $lastname = filter_var($_POST['lastname'] ?? '', FILTER_SANITIZE_STRING);
        $gender = filter_var($_POST['gender'] ?? '', FILTER_SANITIZE_STRING);
        $nationality = filter_var($_POST['nationality'] ?? '', FILTER_SANITIZE_STRING);
        $dob = filter_var($_POST['dob'] ?? '', FILTER_SANITIZE_STRING);
        $contact = filter_var($_POST['contact'] ?? '', FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'] ?? '';

        // Validate required fields
        if (empty($firstname) || empty($lastname) || empty($gender) || 
            empty($nationality) || empty($dob) || empty($contact) || 
            empty($email) || empty($password)) {
            throw new Exception('All fields are required');
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Please enter a valid email address');
        }

        // Validate password length
        if (strlen($password) < 8) {
            throw new Exception('Password must be at least 8 characters long');
        }

        // Validate date format
        $date = DateTime::createFromFormat('Y-m-d', $dob);
        if (!$date || $date->format('Y-m-d') !== $dob) {
            throw new Exception('Invalid date format');
        }

        // Database connection
        $database = new Database();
        $db = $database->getConnection();

        // Check if email already exists
        $stmt = $db->prepare("SELECT student_id FROM student WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->fetch()) {
            throw new Exception('Email already registered');
        }

        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new student
        $stmt = $db->prepare("
            INSERT INTO student (
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
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
        ");

        $stmt->execute([
            $firstname,
            $lastname,
            $gender,
            $nationality,
            $dob,
            $contact,
            $email,
            $hashedPassword
        ]);

        // Set success response
        $response['status'] = true;
        $response['message'] = 'Account created successfully! Please login to continue.';
        $response['icon'] = 'success';

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
        // Log the actual error for debugging purposes
        error_log("Student Registration Error: " . $e->getMessage());
    }
} else {
    $response['message'] = 'Invalid request method';
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
