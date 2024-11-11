<?php
// Include database connection file
require_once __DIR__ . '/../../config/database.php';

// Initialize response array
$response = [];

// Database connection
$database = new Database();
$db = $database->getConnection();

// SQL query to fetch data from application_details, students, schools, and programs
$query = "
    SELECT 
        CONCAT(s.firstname, ' ', s.lastname) AS name,
        CONCAT('A', a.student_id) AS applicantId,
        sc.school_name AS school,
        p.program_name AS program,
        a.date_applied AS dateApplied,
        a.status
    FROM 
        application_details ad
    JOIN 
        application a ON ad.application_id = a.application_id
    JOIN 
        student s ON a.student_id = s.student_id
    JOIN 
        school sc ON ad.school_id = sc.school_id
    JOIN 
        program p ON ad.program_id = p.program_id
";


// Prepare and execute the query
$stmt = $db->prepare($query);
if($stmt->execute()){

// Fetch all results
$applications = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Format the data as needed (similar to the demo JSON format)
$response['applicants'] = [];
foreach ($applications as $application) {
    $response['applicants'][] = [
        'name' => $application['name'],
        'applicantId' => $application['applicantId'],
        'school' => $application['school'],
        'program' => $application['program'],
        'dateApplied' => $application['dateApplied'],
        'status' => $application['status']
    ];
}
$response['status'] = true;
}
// Return the response in JSON format
header('Content-Type: application/json');
echo json_encode($response);
exit;
