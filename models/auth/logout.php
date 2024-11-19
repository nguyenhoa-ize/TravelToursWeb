<?php
session_start();

// Xóa tất cả các biến phiên làm việc
session_unset();

// Hủy bỏ phiên làm việc hiện tại
session_destroy();

// Chuyển hướng về trang trước đó hoặc `index.php` nếu không có trang trước đó
header("Location: login.php");
exit();
