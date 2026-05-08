<?php
session_start();
require_once 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Lấy thông tin user
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch();

// CHẶN 1: Nếu chưa đổi pass lần đầu thì bắt đi đổi
if ($user['is_first_login'] == 1) {
    header("Location: change_password_first_time.php");
    exit();
}

// CHẶN 2: Nếu chưa verified thì không cho rút tiền (Mục 1.3)
if ($user['status'] !== 'verified') {
    die("<script>alert('Tài khoản của bạn chưa được xác minh. Vui lòng đợi Admin duyệt!'); window.location.href='index.php';</script>");
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Rút tiền</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="col-md-6 mx-auto bg-white p-4 shadow rounded">
        <h3 class="text-center">Rút tiền về thẻ</h3>
        <p>Số dư: <strong><?php echo number_format($user['balance'], 0, ',', '.'); ?> VND</strong></p>
        <hr>
        <form action="process_withdraw.php" method="POST">
            <div class="mb-3">
                <label>Số thẻ:</label>
                <input type="text" name="card_number" class="form-control" placeholder="" required>
            </div>
            <div class="mb-3">
                <label>Ngày hết hạn:</label>
                <input type="date" name="expiry_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Mã CVV:</label>
                <input type="text" name="cvv" class="form-control" placeholder="" required>
            </div>
            <div class="mb-3">
                <label>Số tiền muốn rút:</label>
                <input type="number" name="amount" class="form-control" step="50000" required>
                <small class="text-danger">* Phí rút tiền là 5%</small>
            </div>
            <button type="submit" class="btn btn-primary w-100">Xác nhận rút tiền</button>
        </form>
    </div>
</div>
</body>
</html>