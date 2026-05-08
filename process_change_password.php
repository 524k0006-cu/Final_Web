<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];

    // 1. Kiểm tra mật khẩu mới và xác nhận mật khẩu có khớp không
    if ($new_pass !== $confirm_pass) {
        die("<script>alert('Mật khẩu mới không khớp!'); window.history.back();</script>");
    }

    // 2. Lấy mật khẩu cũ từ DB để so sánh
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user && password_verify($old_pass, $user['password'])) {
        // 3. Nếu pass cũ đúng -> Mã hóa pass mới và UPDATE
        $hashed_new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
        
        $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $update->execute([$hashed_new_pass, $user_id]);

        echo "<script>alert('Đổi mật khẩu thành công!'); window.location.href='index.php';</script>";
    } else {
        // 4. Nếu pass cũ sai
        echo "<script>alert('Mật khẩu hiện tại không chính xác!'); window.history.back();</script>";
    }
}
?>