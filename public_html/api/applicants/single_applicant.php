<?php

if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
    if ($id === false) {
        $response = [
            'status' => 'error',
            'message' => 'Invalid application ID'
        ];
        echo json_encode($response);
        exit;
    }

    require_once __DIR__ . '/../../config/database.php';
    $db = new Database();
    $conn = $db->getConnection();

    // Combine queries into a single JOIN for better performance
    $sql = 'SELECT ad.*, p.payment_status, a.status 
            FROM application_details ad 
            LEFT JOIN payment p ON ad.application_id = p.application_id 
            LEFT JOIN school s ON ad.major_school = s.school_id
            LEFT JOIN country c ON ad.major_country = c.country_id
            LEFT JOIN program pr ON ad.major_program = pr.program_id
            LEFT JOIN application a ON ad.application_id = a.application_id 
            WHERE ad.application_id = :id';
    $studyQuery = 'SELECT * FROM `study_experience` WHERE application_id = :id';
    $workQuery = 'SELECT * FROM `work_history` WHERE application_id = :id';
    $updateQuery = 'SELECT * FROM `update` WHERE application_id = :id';
    $documentQuery = 'SELECT * FROM `student_files` WHERE application_id = :id';

    try {
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $applicant = $stmt->fetch(PDO::FETCH_ASSOC);

        $studyStmt = $conn->prepare($studyQuery);
        $studyStmt->execute(['id' => $id]);
        $study_experience = $studyStmt->fetchAll(PDO::FETCH_ASSOC);

        $workStmt = $conn->prepare($workQuery);
        $workStmt->execute(['id' => $id]);
        $work_history = $workStmt->fetchAll(PDO::FETCH_ASSOC);

        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->execute(['id' => $id]);
        $updates = $updateStmt->fetchAll(PDO::FETCH_ASSOC);

        $documentStmt = $conn->prepare($documentQuery);
        $documentStmt->execute(['id' => $id]);
        $documents = $documentStmt->fetchAll(PDO::FETCH_ASSOC); 

        if (!$applicant) {
            $response = [
                'status' => 'error',
                'message' => 'Applicant not found'
            ];
            echo json_encode($response);
            exit;
        }
        // Set payment_status to 'Not Found' if null
        $applicant['payment_status'] = $applicant['payment_status'] ?? 'Not Found';
    } catch (PDOException $e) {
        error_log('Database error: ' . $e->getMessage());
        $response = [
            'status' => 'error',
            'message' => $e
        ];
        echo json_encode($response);
        exit;
    }
}
