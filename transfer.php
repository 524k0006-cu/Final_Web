<?php
session_start();
require_once 'db_config.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
// Lấy số dư hiện tại để hiển thị
$stmt = $conn->prepare("SELECT balance FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chuyển tiền | E-Wallet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7fe; font-family: 'Segoe UI', sans-serif; }
        .transfer-card { 
            max-width: 500px; margin: 50px auto; border: none; 
            border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        }
        .btn-transfer { background: linear-gradient(135deg, #1a73e8, #0d47a1); border: none; border-radius: 10px; padding: 12px; }
    </style>
</head>
<body>

<div class="container">
    <div class="card transfer-card p-4">
        <h4 class="fw-bold text-center mb-4 text-primary">Chuyển tiền qua SĐT</h4>
        
        <div class="alert alert-info py-2 small border-0 mb-4" style="border-radius: 12px;">
            <i class="bi bi-wallet2 me-2"></i> Số dư hiện tại: <strong><?php echo number_format($user['balance']); ?> VND</strong>
        </div>

        <form action="process_transfer.php" method="POST">
            <div class="mb-3">
                <label class="form-label small fw-bold">Số điện thoại người nhận</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-phone"></i></span>
                    <input type="text" name="receiver_phone" class="form-control bg-light border-start-0" placeholder="Nhập SĐT người nhận..." required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Số tiền chuyển (VND)</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-currency-dollar"></i></span>
                    <input type="number" name="amount" class="form-control bg-light border-start-0" placeholder="Tối thiểu 10,000đ" min="10000" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Ghi chú</label>
                <textarea name="note" class="form-control bg-light" rows="2" placeholder="Nội dung chuyển tiền..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100 btn-transfer fw-bold shadow-sm">
                Tiếp tục giao dịch
            </button>
            
            <div class="text-center mt-3">
                <a href="index.php" class="text-muted text-decoration-none small">Quay lại trang chủ</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>