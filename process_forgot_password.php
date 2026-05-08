<?php
session_start();
require_once 'db_config.php';
require_once 'send_mail.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // 1. Kiểm tra tài khoản có tồn tại không
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND phone_number = ?");
    $stmt->execute([$email, $phone]);
    $user = $stmt->fetch();

    if ($user) {
        // 2. Tạo OTP ngẫu nhiên
        $otp = rand(100000, 999999);
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['reset_user_id'] = $user['id'];
        $_SESSION['otp_time'] = time(); // Để check hết hạn 1 phút

        // 3. Gửi mail
        $subject = "Ma OTP khoi phuc mat khau";
        $body = "Ma OTP cua ban la: $otp. Ma co hieu luc trong 1 phut.";
        
        if (sendEmail($email, $subject, $body)) {
            header("Location: verify_reset_otp.php"); // Qua trang nhập mã
        } else {
            echo "Lỗi gửi mail. Check lại SMTP!";
        }
    } else {
        echo "Thông tin không chính xác!";
    }
}