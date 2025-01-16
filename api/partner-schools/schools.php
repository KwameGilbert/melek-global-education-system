<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$db = new Database();
$conn = $db->getConnection();

try {
    // Prepare and execute the query
    $query = "
        SELECT 
            c.country_id AS country_id,
            c.country_name AS country_name,
            s.school_id AS school_id,
            s.school_name AS school_name,
            s.application_cost AS application_cost,
            s.school_city AS school_city,
            p.program_id AS program_id,
            p.program_name AS program_name,
            p.program_degree AS program_degree,
            d.degree_id AS degree_id,
            d.degree_name AS degree_name
        FROM country c
        LEFT JOIN school s ON c.country_id = s.country_id
        LEFT JOIN program p ON s.school_id = p.school_id
        LEFT JOIN degree d ON p.program_degree = d.degree_id
        ORDER BY c.country_name, s.school_name, p.program_name, d.degree_name
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch all results
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output data as JSON
    echo json_encode($results, JSON_PRETTY_PRINT);
} catch (PDOException $e) {
    echo json_encode([
        "error" => true,
        "message" => "Database query failed: " . $e->getMessage()
    ]);
}
