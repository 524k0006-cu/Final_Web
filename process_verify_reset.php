<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otp_input = $_POST['otp_input'];

    // Kiểm tra mã nhập vào có khớp với mã trong Session không
    if ($otp_input == $_SESSION['reset_otp']) {
        // Đúng mã -> Cho phép qua trang đặt lại mật khẩu mới
        header("Location: reset_password.php");
    } else {
        // Sai mã
        echo "<script>alert('Mã OTP không chính xác!'); window.history.back();</script>";
    }
}
?>