<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlentities($_POST['name'], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $message = htmlentities($_POST['message'], ENT_QUOTES, 'UTF-8');

    if (!$email || empty($name) || empty($message)) {
        echo json_encode(["status" => "error", "message" => "Invalid input."]);
        exit;
    }

    $recipientEmail = "melekglobalconsult@gmail.com"; // Change to your recipient email
    $subject = "New Consultation Request from $name";

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = "kwamegilbert1114@gmail.com"; // Use environment variable
        $mail->Password = "sluziiqpymxnvoqx"; // Use environment variable
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        // Email Content
        $mail->setFrom('kwamegilbert1114@gmail.com', 'Melek Global Consult');
        $mail->addReplyTo($email, $name);
        $mail->addAddress($recipientEmail);
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = "<p><strong>Name:</strong> $name</p>
                       <p><strong>Email:</strong> $email</p>
                       <p><strong>Message:</strong></p>
                       <p>$message</p>";

        $mail->send();
        echo json_encode(["status" => "success", "message" => "Your message has been sent successfully."]);
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Email sending failed: " . $mail->ErrorInfo]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
