<?php

require __DIR__ . '/../../config/database.php';

$response = [
    'status' => false,
    'message' => 'Error, Something went wrong!'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //Read data from request body
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['application_id']) || !isset($data['title'])) {
        $response = [
            'status' => false,
            'message' => 'Application ID and Title is required'
        ];
        echo json_encode($response);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    $application_id = htmlspecialchars($data['application_id']);
    $title = htmlspecialchars($data['title']);
    $dateTime = htmlspecialchars($data['date_time']);
    $message = htmlspecialchars($data['message']);

    $sql = 'INSERT INTO `update` (application_id, title, datetime, message) VALUES (?, ?, ?, ?)';

    try {
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->execute([$application_id, $title, $dateTime, $message]);

            $response = [
                'status' => true,
                'message' => 'Update added successfully'
            ];
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to add update'
            ];
        }

        //  $stmt->close();
    } catch (Exception $e) {
        $response = [
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}
