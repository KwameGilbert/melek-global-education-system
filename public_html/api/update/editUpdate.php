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

    if (!isset($data['update_id']) || !isset($data['title'])) {
        $response = [
            'status' => false,
            'message' => 'Update ID and Title are required'
        ];
        echo json_encode($response);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    $update_id = htmlspecialchars($data['update_id']);
    $title = htmlspecialchars($data['title']);
    $dateTime = htmlspecialchars($data['date_time']);
    $message = htmlspecialchars($data['message']);

    $sql = 'UPDATE `update` SET title = ?, datetime = ?, message = ? WHERE id = ?';

    try {
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->execute([$title, $dateTime, $message, $update_id]);

            if ($stmt->rowCount() > 0) {
                $response = [
                    'status' => true,
                    'message' => 'Update modified successfully'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Update not found or no changes made'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to modify update'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => false,
            'message' => 'Error: ' . $e->getMessage()
        ];
    }

    echo json_encode($response);
}
