<?php
session_start();
require_once 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $target_dir = "uploads/";
    
    // Tạo tên file mới dựa trên thời gian để tránh bị trùng
    $front_name = time() . "_front_" . basename($_FILES["id_front"]["name"]);
    $back_name = time() . "_back_" . basename($_FILES["id_back"]["name"]);

    if (move_uploaded_file($_FILES["id_front"]["tmp_name"], $target_dir . $front_name) &&
        move_uploaded_file($_FILES["id_back"]["tmp_name"], $target_dir . $back_name)) {
        
        // Cập nhật DB: Lưu tên ảnh mới và reset trạng thái về 'pending'
        $stmt = $conn->prepare("UPDATE users SET id_front_image = ?, id_back_image = ?, status = 'pending' WHERE id = ?");
        $stmt->execute([$front_name, $back_name, $user_id]);

        echo "<script>alert('Đã cập nhật hồ sơ! Đợi Admin duyệt lại nhé.'); window.location.href='index.php';</script>";
    } else {
        echo "Lỗi upload ảnh, Khiêm kiểm tra lại thư mục uploads nhé!";
    }
}