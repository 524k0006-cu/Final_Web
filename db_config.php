<?php
$host = "localhost";
$db_name = "e_wallet";
$username = "root";
$password = ""; // XAMPP mặc định để trống pass

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    // Thiết lập chế độ báo lỗi để dễ sửa bug
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Kết nối database thành công!"; 
} catch(PDOException $e) {
    echo "Kết nối thất bại: " . $e->getMessage();
}
?>