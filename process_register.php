<?php
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // 1. Kiểm tra xem SĐT hoặc Email đã tồn tại chưa
    $checkSql = "SELECT * FROM users WHERE email = ? OR phone_number = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->execute([$email, $phone]);

    if ($checkStmt->rowCount() > 0) {
        die("<script>alert('Lỗi: Email hoặc Số điện thoại đã được đăng ký!'); window.history.back();</script>");
    }

    // 2. Sinh mật khẩu ngẫu nhiên 6 ký tự
    $raw_password = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 6);
    $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

    // 3. Xử lý Upload ảnh
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

    $id_front = $target_dir . time() . "_front_" . $_FILES["id_front"]["name"];
    $id_back = $target_dir . time() . "_back_" . $_FILES["id_back"]["name"];

    move_uploaded_file($_FILES["id_front"]["tmp_name"], $id_front);
    move_uploaded_file($_FILES["id_back"]["tmp_name"], $id_back);

    try {
        // 4. Lưu vào DB (Đầy đủ các cột)
        $sql = "INSERT INTO users (username, password, full_name, email, phone_number, date_of_birth, address, id_front_image, id_back_image, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";
        
        $stmt = $conn->prepare($sql);
        // Dùng SĐT làm username mặc định
        $stmt->execute([$phone, $hashed_password, $full_name, $email, $phone, $dob, $address, $id_front, $id_back]);

        // 5. Hiển thị thông báo (Theo yêu cầu: Hiện mật khẩu ngay trên web)
        echo "
        <div style='max-width:500px; margin:50px auto; border:1px solid #ddd; padding:20px; border-radius:10px; font-family:Arial;'>
            <h2 style='color:green;'>Đăng ký thành công!</h2>
            <hr>
            <p>Chào mừng <b>$full_name</b>, tài khoản của bạn đang chờ Admin duyệt.</p>
            <p>Tên đăng nhập: <b>$phone</b> (hoặc email)</p>
            <p>Mật khẩu tạm thời: <b style='color:red; font-size:24px;'>$raw_password</b></p>
            <p style='font-size:12px; color:gray;'>* Vui lòng ghi nhớ mật khẩu này để đăng nhập lần đầu.</p>
            <a href='login.php' style='display:inline-block; padding:10px 20px; background:blue; color:white; text-decoration:none; border-radius:5px;'>Đăng nhập ngay</a>
        </div>";

    } catch (PDOException $e) {
        echo "Lỗi hệ thống: " . $e->getMessage();
    }
}
?>