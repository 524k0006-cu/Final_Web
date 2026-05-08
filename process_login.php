<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_input = $_POST['user_input'];
    $password = $_POST['password'];

    // 1. Tìm user theo Email hoặc SĐT
    $sql = "SELECT * FROM users WHERE email = ? OR phone_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_input, $user_input]);
    $user = $stmt->fetch();

    if ($user) {
        // Kiểm tra tài khoản có bị vô hiệu hóa (disabled) không
        if ($user['status'] == 'disabled') {
            die("Tài khoản đã bị vô hiệu hóa, vui lòng liên hệ hotline 18001008.");
        }

        // 2. Kiểm tra mật khẩu
        if (password_verify($password, $user['password'])) {
            // Đăng nhập thành công
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            
            // Reset số lần đăng nhập sai về 0
            $resetSql = "UPDATE users SET abnormal_login_count = 0 WHERE id = ?";
            $conn->prepare($resetSql)->execute([$user['id']]);

            // KIỂM TRA: Đăng nhập lần đầu thì bắt đi đổi pass
            if ($user['is_first_login'] == 1) {
                header("Location: change_password_first_time.php");
            } else {
                header("Location: index.php"); // Vào trang chủ
            }
            exit();

        } else {
            // SAI MẬT KHẨU: Chỗ này Khiêm sẽ phải viết logic khóa tài khoản ở bước sau
            echo "Sai mật khẩu!";
        }
    } else {
        echo "Tài khoản không tồn tại!";
    }
}
?>