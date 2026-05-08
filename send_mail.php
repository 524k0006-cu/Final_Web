<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendEmail($to, $subject, $content) {
    $mail = new PHPMailer(true);
    try {
        // Cấu hình Server
        $mail->isSMTP();
        $mail->CharSet   = 'UTF-8'; // Viết đúng chuẩn như này
        $mail->Host      = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'khiemthan01@gmail.com'; 
        $mail->Password   = 'ozym voto spjv tbql';    
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Cấu hình SSL (Đưa lên trước khi gửi)
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        // Người gửi & Người nhận
        $mail->setFrom('khiemthan01@gmail.com', 'Ví Điện Tử'); // Tên này sẽ hiện đúng tiếng Việt
        $mail->addAddress($to);

        // Nội dung
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $content;

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mail Error: " . $mail->ErrorInfo);
        return false;
    }
}