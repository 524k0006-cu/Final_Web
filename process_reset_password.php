<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    $user_id = $_SESSION['reset_user_id'];

    // 1. Kiểm tra 2 mật khẩu có khớp nhau không
    if ($pass !== $confirm_pass) {
        die("<script>alert('Mật khẩu xác nhận không khớp!'); window.history.back();</script>");
    }

    // 2. Mã hóa mật khẩu mới
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    try {
        // 3. Cập nhật vào Database
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->execute([$hashed_password, $user_id]);

        // 4. Xóa các session tạm sau khi đổi xong
        unset($_SESSION['reset_otp']);
        unset($_SESSION['reset_user_id']);
        unset($_SESSION['otp_time']);

        echo "<script>alert('Đổi mật khẩu thành công! Vui lòng đăng nhập lại.'); window.location.href='login.php';</script>";
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}