<?php
session_start();
require_once 'db_config.php';

// Kiểm tra: Nếu chưa đăng nhập thì không cho xem trang này
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin user để hiển thị số dư hiện tại
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// CHẶN: Nếu chưa đổi pass lần đầu (mục 1.2) thì bắt quay lại đổi pass
if ($user['is_first_login'] == 1) {
    header("Location: change_password_first_time.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nạp tiền vào ví</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="col-md-6 mx-auto bg-white p-4 shadow rounded">
        <h3 class="text-center">Nạp tiền</h3>
        <p>Số dư hiện tại: <strong><?php echo number_format($user['balance'], 0, ',', '.'); ?> VND</strong></p>
        <hr>
        
        <form action="process_deposit.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Số thẻ (6 chữ số):</label>
                <input type="text" name="card_number" class="form-control" placeholder="Ví dụ: 111111" maxlength="6" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ngày hết hạn:</label>
                <input type="date" name="expiry_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Mã CVV (3 số):</label>
                <input type="text" name="cvv" class="form-control" placeholder="123" maxlength="3" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Số tiền cần nạp:</label>
                <input type="number" name="amount" class="form-control" placeholder="Nhập số tiền" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Xác nhận nạp tiền</button>
            <a href="index.php" class="btn btn-link w-100">Quay lại trang chủ</a>
        </form>
    </div>
</div>
</body>
</html>