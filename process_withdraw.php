<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $amount = $_POST['amount'];
    $fee = $amount * 0.05; // Phí 5%
    $total_deduct = $amount + $fee; // Tổng tiền sẽ bị trừ khỏi ví

    // 1. Kiểm tra bội số 50.000
    if ($amount % 50000 != 0) {
        die("<script>alert('Số tiền rút phải là bội số của 50.000 VND'); window.history.back();</script>");
    }

    // 2. Lấy thông tin user để check số dư
    $stmt = $conn->prepare("SELECT balance FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($total_deduct > $user['balance']) {
        die("<script>alert('Số dư không đủ để thực hiện giao dịch (bao gồm phí 5%)'); window.history.back();</script>");
    }

    // 3. Kiểm tra ngưỡng 5 triệu để set trạng thái
    $status = ($amount > 5000000) ? 'pending' : 'success';
    $message = ($status == 'pending') ? 'Yêu cầu rút tiền đã được gửi, vui lòng đợi Admin duyệt!' : 'Rút tiền thành công!';

    try {
        $conn->beginTransaction();

        // Nếu rút <= 5 triệu thì trừ tiền ngay
        if ($status == 'success') {
            $updateSql = "UPDATE users SET balance = balance - ? WHERE id = ?";
            $conn->prepare($updateSql)->execute([$total_deduct, $user_id]);
        }

        // Lưu lịch sử giao dịch
        $logSql = "INSERT INTO transactions (sender_id, type, amount, fee, total_amount, status) VALUES (?, 'withdraw', ?, ?, ?, ?)";
        $conn->prepare($logSql)->execute([$user_id, $amount, $fee, $total_deduct, $status]);

        $conn->commit();
        echo "<script>alert('$message'); window.location.href='index.php';</script>";

    } catch (Exception $e) {
        $conn->rollBack();
        echo "Lỗi: " . $e->getMessage();
    }
}
?>