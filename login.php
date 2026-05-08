<!DOCTYPE html>
<html lang="vi">
    
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4 bg-white p-4 shadow-sm rounded">
            <h3 class="text-center">Đăng nhập Ví</h3>
            <form action="process_login.php" method="POST">
                <div class="mb-3">
                    <label>SĐT hoặc Email:</label>
                    <input type="text" name="user_input" class="form-control" required>
                </div>
                
                <div class="mb-3">
                    <label>Mật khẩu:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>

<div class="text-center mt-3">
    <a href="forgot_password.php" class="text-decoration-none text-danger small">Quên mật khẩu?</a>
</div>

<div class="text-center mt-2">
    <a href="register.php" class="text-decoration-none small">Chưa có tài khoản? Đăng ký ngay</a>
</div>
        </div>
    </div>
</div>
</body>
</html>