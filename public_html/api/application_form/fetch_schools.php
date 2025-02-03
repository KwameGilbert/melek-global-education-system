<?php
// fetch_schools.php
require_once __DIR__ . '/../../config/database.php';
$db = new Database();
$conn = $db->getConnection();

if (isset($_GET['country_id'])) {
    $country_id = intval($_GET['country_id']);
    $query = "SELECT school_id, school_name FROM school WHERE country_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$country_id]);
    $schools = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($schools);
}
