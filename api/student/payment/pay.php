<?php
header('Content-Type: application/json');
// Verify Paystack payment and record payment
require_once __DIR__ . '/../../../config/database.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['message' => 'Invalid request method']);
    exit();
}else{

    $db = new Database();
    $conn = $db->getConnection();

    $data = json_decode(file_get_contents('php://input'));
    $reference = $data->reference;
    $amount = $data->applicationCost;
    $email = $data->studentEmail;
    $status = $data->paymentStatus;
    $application_id = $data->applicationId;
    $payment_date = date('Y-m-d H:i:s');

    $query = "
        INSERT INTO 
            payments (reference, amount, email, status, application_id, payment_date)
        VALUES 
            (:reference, :amount, :email, :status, :application_id, :payment_date)
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        'reference' => $reference,
        'amount' => $amount,
        'email' => $email,
        'status' => $status,
        'application_id' => $application_id,
        'payment_date' => $payment_date
    ]);

    if ($stmt->rowCount() > 0) {
        echo json_encode(['message' => 'Payment recorded successfully']);
    } else {
        echo json_encode(['message' => 'Payment recording failed']);
    }
}

}
?>