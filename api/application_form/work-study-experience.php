<?php
// save_history.php
require_once __DIR__ . '/../../config/database.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studyExperience = json_decode($_POST['study_experience'], true);
    $workHistory = json_decode($_POST['work_history'], true);
}

if (!isset($_SESSION['student_id'], $_SESSION['application_id'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit;
}

$applicationId = $_SESSION['application_id'];
try {
    $db = new Database();
    $conn = $db->getConnection();
    $conn->beginTransaction();

    // Clear existing records
    $conn->prepare('DELETE FROM study_experience WHERE application_id = ?')->execute([$applicationId]);
    $conn->prepare('DELETE FROM work_history WHERE application_id = ?')->execute([$applicationId]);

    // Insert Study Experience
    $studyStmt = $conn->prepare(
        'INSERT INTO study_experience (application_id, school_name, degree, attendance_period, contact_person) ' .
            'VALUES (?, ?, ?, ?, ?)'
    );
    foreach ($studyExperience as $experience) {
        $studyStmt->execute([
            $applicationId,
            $experience['school_name'],
            $experience['degree'],
            $experience['attendance_period'],
            $experience['contact_person']
        ]);
    }

    // Insert Work History
    $workStmt = $conn->prepare(
        'INSERT INTO work_history (application_id, company, position, start_date, end_date, company_phone, company_email) ' .
            'VALUES (?, ?, ?, ?, ?, ?, ?)'
    );

    foreach ($workHistory as $work) {
        $workStmt->execute([
            $applicationId,
            $work['company'],
            $work['position'],
            $work['start_date'],
            $work['end_date'],
            $work['company_phone'],
            $work['company_email']
        ]);
    }

    if($conn->commit()){    
        echo json_encode(['success' => true]);
    }
} catch (Exception $e) {
    $conn->rollBack();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
