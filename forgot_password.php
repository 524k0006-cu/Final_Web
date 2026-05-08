<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu | Ví Điện Tử</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .forgot-card {
            max-width: 400px;
            margin: 100px auto;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .btn-primary { background-color: #007bff; border: none; border-radius: 8px; padding: 12px; }
        .form-control { border-radius: 8px; padding: 12px; }
    </style>
</head>
<body>

<div class="container">
    <div class="card forgot-card p-4 bg-white">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-primary">Quên mật khẩu?</h3>
            <p class="text-muted">Nhập thông tin để nhận mã OTP xác thực</p>
        </div>

        <form action="process_forgot_password.php" method="POST">
            <div class="mb-3">
                <label class="form-label fw-semibold">Email đăng ký</label>
                <input type="email" name="email" class="form-control" placeholder="example@gmail.com" required>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-semibold">Số điện thoại</label>
                <input type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">Gửi mã xác nhận</button>
            
            <div class="text-center mt-4">
                <a href="login.php" class="text-decoration-none small text-secondary">← Quay lại đăng nhập</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>