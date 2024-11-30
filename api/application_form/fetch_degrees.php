<?php
// fetch_degrees.php
require_once __DIR__ . '/../../config/database.php';
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['school_id'])) {
    $school_id = intval($_GET['school_id']);
    $query = "SELECT DISTINCT program_degree FROM program WHERE school_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$school_id]);
    $degrees = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($degrees);
}
