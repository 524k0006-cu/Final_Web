<?php
session_start();
require_once 'db_config.php';

// KIỂM TRA 1: OTP có đúng và còn hạn không?
$otp_input = $_POST['otp_input'];
$current_time = time();

if ($otp_input != $_SESSION['otp_code'] || ($current_time - $_SESSION['otp_time']) > 60) {
    die("<script>alert('Mã OTP sai hoặc đã hết hạn!'); window.location.href='transfer.php';</script>");
}

// KIỂM TRA 2: Có lấy được dữ liệu giao dịch từ Session không?
if (!isset($_SESSION['pending_transfer'])) {
    die("<script>alert('Không tìm thấy thông tin giao dịch. Vui lòng thử lại!'); window.location.href='transfer.php';</script>");
}

$data = $_SESSION['pending_transfer'];
$sender_id = $_SESSION['user_id'];
$receiver_phone = $data['receiver_phone'];
$amount = $data['amount'];
$fee_payer = $data['fee_payer'];
$note = $data['note'];
$fee = $amount * 0.05;

try {
    $conn->beginTransaction();

    // 1. Tìm ID người nhận từ SĐT
    $stmt = $conn->prepare("SELECT id FROM users WHERE phone_number = ?");
    $stmt->execute([$receiver_phone]);
    $receiver = $stmt->fetch();

    if (!$receiver) { throw new Exception("Không tìm thấy người nhận."); }

    // 2. Tính toán tiền trừ/nhận
    if ($fee_payer == 'sender') {
        $total_deduct = $amount + $fee;
        $total_receive = $amount;
    } else {
        $total_deduct = $amount;
        $total_receive = $amount - $fee;
    }

    // 3. XÁC ĐỊNH TRẠNG THÁI (Nếu > 5tr thì 'pending', ngược lại 'success')
    $status = ($amount > 5000000) ? 'pending' : 'success';

    // 4. CHỈ CẬP NHẬT TIỀN NẾU TRẠNG THÁI LÀ SUCCESS
    if ($status == 'success') {
        // Trừ tiền người gửi
        $upSender = $conn->prepare("UPDATE users SET balance = balance - ? WHERE id = ?");
        $upSender->execute([$total_deduct, $sender_id]);

        // Cộng tiền người nhận
        $upReceiver = $conn->prepare("UPDATE users SET balance = balance + ? WHERE id = ?");
        $upReceiver->execute([$total_receive, $receiver['id']]);
    }

    // 5. Lưu vào lịch sử giao dịch (Dòng này cực kỳ quan trọng để Admin duyệt sau này)
    $insLog = $conn->prepare("INSERT INTO transactions (sender_id, receiver_id, type, amount, fee, total_amount, status, note) 
                             VALUES (?, ?, 'transfer', ?, ?, ?, ?, ?)");
    $insLog->execute([$sender_id, $receiver['id'], $amount, $fee, $total_deduct, $status, $note]);

    $conn->commit();

    // Xóa session OTP sau khi xong
    unset($_SESSION['otp_code']);
    unset($_SESSION['otp_time']);
    unset($_SESSION['pending_transfer']);

    $msg = ($status == 'success') ? "Chuyển tiền thành công!" : "Giao dịch > 5tr đang chờ Admin duyệt!";
    echo "<script>alert('$msg'); window.location.href='index.php';</script>";

} catch (Exception $e) {
    $conn->rollBack();
    echo "Lỗi: " . $e->getMessage();
}
?>