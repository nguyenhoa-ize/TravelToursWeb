<?php
include '../../config.php';
include '../../includes/connect.php';
include '../../includes/database.php';
include '../../includes/functions.php';
include '../../includes/session.php';

$filterAll = filter();
if (isset($filterAll['id_user'])) {
    $userId = $filterAll['id_user'];

    // Sử dụng prepared statements để tránh SQL injection
    $userDetail = getRows("SELECT *  FROM user WHERE id_user = $userId");

    // Kiểm tra nếu người dùng tồn tại
    if (!empty($userDetail)) {
        // Thực hiện xóa người dùng
        $deleteUser = delete('user', "id_user = $userId");  
    }
}

// Điều hướng lại trang danh sách người dùng
redirect('../admin/admin.php?page=QLND');
?>
