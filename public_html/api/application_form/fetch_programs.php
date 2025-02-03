<?php
// fetch_programs.php
require_once __DIR__ . '/../../config/database.php';
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['school_id']) && isset($_GET['degree'])) {
    $school_id = intval($_GET['school_id']);
    $degree = $_GET['degree'];
    $query = "SELECT program_id, program_name, program_duration FROM program WHERE school_id = ? AND program_degree = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$school_id, $degree]);
    $programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($programs);
}
