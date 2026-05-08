<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 bg-white p-4 shadow-sm rounded">
            <h3 class="text-center mb-4">Đăng ký Ví Điện Tử</h3>
            <form action="process_register.php" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Họ và tên:</label>
                        <input type="text" name="full_name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ngày sinh:</label>
                        <input type="date" name="dob" class="form-control" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Số điện thoại:</label>
                        <input type="text" name="phone" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Địa chỉ:</label>
                    <textarea name="address" class="form-control" rows="2" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mặt trước CCCD:</label>
                        <input type="file" name="id_front" class="form-control" accept="image/*" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mặt sau CCCD:</label>
                        <input type="file" name="id_back" class="form-control" accept="image/*" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100 mt-3">Đăng ký ngay</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>