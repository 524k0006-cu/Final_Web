<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu lần đầu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 bg-white p-4 shadow-sm rounded">
            <h3 class="text-center">Đổi mật khẩu lần đầu</h3>
            <p class="text-muted text-center">Bạn phải đổi mật khẩu để bắt đầu sử dụng dịch vụ.</p>
            <form action="process_change_pass_first.php" method="POST">
                <div class="mb-3">
                    <label>Mật khẩu mới:</label>
                    <input type="password" name="new_pass" class="form-control" required minlength="6">
                </div>
                <div class="mb-3">
                    <label>Xác nhận mật khẩu mới:</label>
                    <input type="password" name="confirm_pass" class="form-control" required minlength="6">
                </div>
                <button type="submit" class="btn btn-warning w-100">Cập nhật mật khẩu</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>