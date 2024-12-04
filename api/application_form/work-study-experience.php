<?php
// work-study-experience.php

require_once __DIR__ . '/../../config/database.php';

session_start();

if (!isset($_SESSION['student_id']) || !isset($_SESSION['application_id'])) {
    throw new Exception('Unauthorized access, student must be logged in');
}

$applicationId = $_SESSION['application_id'];

// Decode the incoming JSON data
$studyExperience = json_decode($_POST['study_experience'], true);
$workHistory = json_decode($_POST['work_history'], true);

$db = new Database();
$conn = $db->getConnection();

try {
    // Begin a transaction
    $conn->beginTransaction();

    // Delete existing study and work history for the application
    $studyStmt = $conn->prepare('DELETE FROM study_experience WHERE application_id = ?');
    $studyDelete = $studyStmt->execute([$applicationId]);
    $workStmt = $conn->prepare('DELETE FROM work_history WHERE application_id = ?');
    $workDelete = $workStmt->execute([$applicationId]);
    if (!$studyDelete || !$workDelete) {
        throw new Exception('Unable to delete old history');
    }

    // Insert Study Experience Data
    if (!empty($studyExperience)) {
        foreach ($studyExperience as $experience) {
            $query = "INSERT INTO study_experience (application_id, school_name, degree, attendance_period, contact_person)
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                $applicationId,
                $experience['school_name'],
                $experience['degree'],
                $experience['attendance_period'],
                $experience['contact_person']
            ]);
        }
    }

    // Insert Work History Data
    if (!empty($workHistory)) {
        foreach ($workHistory as $work) {
            $query = "INSERT INTO work_history (application_id, position, company, company_phone, company_email,start_date, end_date)
                      VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->execute([
                $applicationId,
                $work['position'],
                $work['company'],
                $work['company_phone'],
                $work['company_email'],
                $work['start_date'],
                $work['end_date']
            ]);
        }
    }

    // Commit the transaction
    $conn->commit();

    // Respond back to the frontend
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    // Rollback the transaction in case of an error
    $conn->rollBack();
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
