<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

try {
    // Prepare and execute a single JOIN query instead of multiple queries
    $query = "
        SELECT 
            c.country_id AS country_id,
            c.country_name AS country_name,
            s.school_id AS school_id,
            s.school_name AS school_name,
            s.school_city AS school_city,
            p.program_id AS program_id,
            p.program_name AS program_name,
            p.program_degree AS program_degree
        FROM country c
        LEFT JOIN school s ON c.country_id = s.country_id
        LEFT JOIN program p ON s.school_id = p.school_id
        ORDER BY c.country_name, s.school_name, p.program_name
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Initialize arrays
    $countries = [];
    $schools = [];
    $programs = [];

    // Process results
    foreach ($results as $row) {
        // Add country if not exists
        if (!isset($countries[$row['country_id']])) {
            $countries[$row['country_id']] = [
                'id' => $row['country_id'],
                'name' => $row['country_name']
            ];
        }

        // Add school if not exists and if school data exists
        if ($row['school_id'] && !isset($schools[$row['school_id']])) {
            $schools[$row['school_id']] = [
                'id' => $row['school_id'],
                'name' => $row['school_name'],
                'city' => $row['school_city'],
                'country_id' => $row['country_id']
            ];
        }

        // Add program if not exists and if program data exists
        if ($row['program_id'] && !isset($programs[$row['program_id']])) {
            $programs[$row['program_id']] = [
                'id' => $row['program_id'],
                'name' => $row['program_name'],
                'degree' => $row['program_degree'],
                'school_id' => $row['school_id']
            ];
        }
    }

    // Convert associative arrays to indexed arrays
    $response = [
        'success' => true,
        'countries' => array_values($countries),
        'schools' => array_values($schools),
        'programs' => array_values($programs)
    ];

    echo json_encode($response, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
