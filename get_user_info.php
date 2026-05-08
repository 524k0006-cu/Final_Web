<?php
session_start();
require_once 'db_config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id']; // Lấy ID từ session
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hồ sơ cá nhân | E-Wallet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7fe; font-family: 'Segoe UI', sans-serif; }
        .profile-card { border-radius: 20px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .info-label { font-size: 0.8rem; color: #6c757d; font-weight: bold; text-transform: uppercase; }
        .info-value { font-size: 1rem; color: #333; font-weight: 500; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card profile-card p-4">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-fill fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-0"><?php echo $user['full_name']; ?></h4>
                    <span class="badge bg-success-subtle text-success rounded-pill mt-2">Tài khoản <?php echo $user['status']; ?></span>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <p class="info-label mb-1">Số điện thoại</p>
                        <p class="info-value"><?php echo $user['phone_number']; ?></p>
                    </div>
                    <div class="col-6">
                        <p class="info-label mb-1">Email</p>
                        <p class="info-value"><?php echo $user['email']; ?></p>
                    </div>
                    <div class="col-12"><hr class="my-2 opacity-50"></div>
                    <div class="col-12">
                        <p class="info-label mb-2">Ảnh CCCD đã cung cấp</p>
                        <div class="row g-2 text-center">
                            <div class="col-6">
                                <img src="uploads/<?php echo $user['id_front_image']; ?>" class="img-fluid rounded-3 border" alt="Mặt trước">
                                <span class="small text-muted mt-1 d-block">Mặt trước</span>
                            </div>
                            <div class="col-6">
                                <img src="uploads/<?php echo $user['id_back_image']; ?>" class="img-fluid rounded-3 border" alt="Mặt sau">
                                <span class="small text-muted mt-1 d-block">Mặt sau</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top text-center">
                    <a href="index.php" class="btn btn-outline-secondary rounded-pill px-4 me-2">Quay lại</a>
                    <a href="change_password.php" class="btn btn-primary rounded-pill px-4">Đổi mật khẩu</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>