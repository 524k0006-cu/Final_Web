<?php
session_start();
// Bảo vệ trang: Nếu chưa qua bước xác thực OTP thì không cho vào đây
if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="col-md-5 mx-auto bg-white p-4 shadow rounded">
        <h4 class="text-center">Đặt lại mật khẩu mới</h4>
        <form action="process_reset_password.php" method="POST">
            <div class="mb-3">
                <label>Mật khẩu mới:</label>
                <input type="password" name="password" class="form-control" required minlength="6">
            </div>
            <div class="mb-3">
                <label>Xác nhận mật khẩu mới:</label>
                <input type="password" name="confirm_password" class="form-control" required minlength="6">
            </div>
            <button type="submit" class="btn btn-primary w-100">Cập nhật mật khẩu</button>
        </form>
    </div>
</div>
</body>
</html>