<?php
session_start(); // Mở phiên làm việc để biết ai đang đăng xuất
session_unset(); // Xóa hết dữ liệu tạm thời của người đó
session_destroy(); // Hủy bỏ hoàn toàn phiên làm việc

// Sau khi xóa xong thì đá người dùng về trang đăng nhập cho an toàn
header("Location: login.php"); 
exit();
?>