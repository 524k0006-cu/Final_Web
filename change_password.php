<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi mật khẩu | Ví Điện Tử</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .change-pass-card { max-width: 450px; margin: 80px auto; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <div class="card change-pass-card p-4 bg-white">
        <h3 class="text-center fw-bold mb-4">Đổi mật khẩu</h3>
        
        <form action="process_change_password.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Mật khẩu hiện tại</label>
                <input type="password" name="old_password" class="form-control" placeholder="Nhập mật khẩu cũ" required>
            </div>
            
            <hr>
            
            <div class="mb-3">
                <label class="form-label">Mật khẩu mới</label>
                <input type="password" name="new_password" class="form-control" placeholder="Tối thiểu 6 ký tự" minlength="6" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Xác nhận mật khẩu mới</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Nhập lại mật khẩu mới" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold">Cập nhật mật khẩu</button>
            <a href="index.php" class="btn btn-link w-100 text-secondary mt-2">Hủy bỏ</a>
        </form>
    </div>
</div>

</body>
</html>