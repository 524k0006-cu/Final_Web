<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_pass = $_POST['new_pass'];
    $confirm_pass = $_POST['confirm_pass'];
    $user_id = $_SESSION['user_id'];

    if ($new_pass !== $confirm_pass) {
        die("<script>alert('Mật khẩu xác nhận không khớp!'); window.history.back();</script>");
    }

    // Mã hóa mật khẩu mới
    $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

    try {
        // Cập nhật pass và set is_first_login về 0
        $sql = "UPDATE users SET password = ?, is_first_login = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$hashed_password, $user_id]);

        echo "<script>alert('Đổi mật khẩu thành công!'); window.location.href='index.php';</script>";
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
}
?>