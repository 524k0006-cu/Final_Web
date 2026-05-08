<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bổ sung hồ sơ | Ví Điện Tử</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow mx-auto" style="max-width: 500px; border-radius: 15px;">
        <div class="card-body p-4">
            <h4 class="fw-bold text-center mb-4 text-danger">Gửi lại ảnh CCCD</h4>
            <form action="process_reupload.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label fw-bold small">Mặt trước mới</label>
                    <input type="file" name="id_front" class="form-control" accept="image/*" required>
                </div>
                <div class="mb-4">
                    <label class="form-label fw-bold small">Mặt sau mới</label>
                    <input type="file" name="id_back" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Cập nhật hồ sơ</button>
                <div class="text-center mt-3">
                    <a href="index.php" class="text-secondary text-decoration-none small">Quay lại</a>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>