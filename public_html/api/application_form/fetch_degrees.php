<?php
// fetch_degrees.php
require_once __DIR__ . '/../../config/database.php';
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['school_id'])) {
    $school_id = intval($_GET['school_id']);
    $query = "SELECT DISTINCT d.degree_id, d.degree_name FROM program p JOIN degree d ON p.program_degree = d.degree_id WHERE p.school_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$school_id]);
    $degrees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($degrees);
}
