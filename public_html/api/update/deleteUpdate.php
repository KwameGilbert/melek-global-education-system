<?php

require __DIR__ . '/../../config/database.php';

$response = [
    'status' => false,
    'message' => 'Error, Something went wrong!'
];

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //Read data from request body
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (!isset($data['update_id'])) {
        $response = [
            'status' => false,
            'message' => 'Update ID is required'
        ];
        echo json_encode($response);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    $update_id = htmlspecialchars($data['update_id']);

    $sql = 'DELETE FROM `update` WHERE id = ?';

    try {
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->execute([$update_id]);

            if ($stmt->rowCount() > 0) {
                $response = [
                    'status' => true,
                    'message' => 'Update deleted successfully'
                ];
            } else {
                $response = [
                    'status' => false,
                    'message' => 'Update not found'
                ];
            }
        } else {
            $response = [
                'status' => false,
                'message' => 'Failed to delete update'
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
