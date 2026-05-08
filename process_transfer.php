<?php
session_start();
require_once 'db_config.php';
require_once 'send_mail.php';

// Kiểm tra nếu người dùng chưa đăng nhập thì không cho vào
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Lưu tạm thông tin giao dịch vào Session
    $_SESSION['pending_transfer'] = [
        'receiver_phone' => $_POST['receiver_phone'],
        'amount' => $_POST['amount'],
        'fee_payer' => $_POST['fee_payer'],
        'note' => $_POST['note']
    ];

    // 2. Lấy Email của người gửi (người đang đăng nhập) từ Database
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT email, full_name FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $sender = $stmt->fetch();

    if ($sender) {
        $recipient_email = $sender['email']; // Email của chính khách hàng đang thực hiện lệnh
        $recipient_name = $sender['full_name'];

        // 3. Tạo mã OTP 6 số
        $otp = rand(100000, 999999);
        $_SESSION['otp_code'] = $otp;
        $_SESSION['otp_time'] = time(); // Lưu thời gian tạo để check hạn 1 phút

        // 4. Chuẩn bị nội dung Email
        $subject = "Ma xac thuc giao dich - Vi Dien Tu";
        $content = "
            <h3>Xác nhận giao dịch chuyển tiền</h3>
            <p>Chào <b>$recipient_name</b>,</p>
            <p>Mã OTP để xác nhận chuyển tiền của bạn là: <b style='font-size: 20px; color: red;'>$otp</b></p>
            <p>Mã này có hiệu lực trong vòng <b>1 phút</b>. Vui lòng không chia sẻ mã này cho bất kỳ ai.</p>
        ";

        // 5. Gửi đến email của khách hàng vừa lấy được từ DB
        if (sendEmail($recipient_email, $subject, $content)) {
            // Gửi thành công thì sang trang nhập OTP
            header("Location: verify_otp.php");
            exit();
        } else {
            // Nếu lỗi gửi mail (do SMTP) thì báo lỗi
            echo "<script>alert('Không thể gửi mã OTP về email của bạn. Vui lòng kiểm tra lại cấu hình SMTP!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Không tìm thấy thông tin người dùng!'); window.location.href='login.php';</script>";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Lấy ID của người ĐANG ĐĂNG NHẬP
    $current_user_id = $_SESSION['user_id']; 

    // 2. Truy vấn Database để lấy Email của chính người đó
    $stmt = $conn->prepare("SELECT email, full_name FROM users WHERE id = ?");
    $stmt->execute([$current_user_id]);
    $currentUser = $stmt->fetch();

    if ($currentUser) {
        $email_nguoi_nhan_otp = $currentUser['email']; // Hệ thống tự hiểu là giakhiem090206@gmail.com
        $ten_nguoi_gui = $currentUser['full_name'];

        // 3. Tạo mã OTP
        $otp = rand(100000, 999999);
        $_SESSION['otp_code'] = $otp;

        // 4. Gửi mail (Hàm này sẽ dùng email Server của Khiêm để phát thư đi)
        $subject = "Ma OTP chuyen tien";
        $body = "Chao $ten_nguoi_gui, ma OTP cua ban la $otp";

        // Gửi đến email vừa lấy được từ DB
        if (sendEmail($email_nguoi_nhan_otp, $subject, $body)) {
            header("Location: verify_otp.php");
            exit();
        }
    }
}
?>