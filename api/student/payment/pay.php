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

    //Verify payment with paystack verifcation then record payment
    $url = 'https://api.paystack.co/transaction/verify/' . $reference;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer sk_test_ae5ab09697628564aec4e64c64d20e96ec385ab0",
            "Content-Type: application/json",
            "Cache-Control: no-cache",
        ),
    ));

    $response = curl_exec($curl);
    $error = curl_errno($curl);
    curl_close($curl);

    if ($error) {
        echo json_encode(['message' => 'Curl Error: ' . $error]);
        exit();
    }else{
        $result = json_decode($response);
        if (!$result->status) {
            echo json_encode(['message' => 'Payment verification failed']);
            exit();
        }
    }

    $query = "
        INSERT INTO 
            payment (payment_status, payment_amount, reference, application_id, payment_email, ip_address, payment_date)
        VALUES 
            (:status, :amount, :reference, :application_id, :email, :ip_address, :payment_date)
    ";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        'reference' => $reference,
        'amount' => $amount,
        'email' => $email,
        'status' => 'Completed',
        'application_id' => $application_id,
        'payment_date' => $result->data->paid_at,
        'ip_address' => $result->data->ip_address
    ]);

    $applicationStatusUpdate = $conn->prepare('UPDATE `application` SET `status` = :status')->execute([ 'status' => 'processing']);

  
    if (($stmt->rowCount() > 0) && ($applicationStatutUpdate)) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Payment recorded successfully']);
    } else {
        echo json_encode(['message' => 'Payment recording failed']);
    }
}

?>