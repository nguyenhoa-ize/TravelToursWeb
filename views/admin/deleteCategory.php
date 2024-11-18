<?php
include '../../config.php';
include '../../includes/connect.php';
include '../../includes/database.php';
include '../../includes/functions.php';
include '../../includes/session.php';

$filterAll = filter();
if (isset($filterAll['id_tours'])) {
    $tourId = $filterAll['id_tours'];

    // Sử dụng prepared statements để tránh SQL injection
    $tourDetail = getRows("SELECT *  FROM tours WHERE id_tours = $tourId");

    // Kiểm tra nếu người dùng tồn tại
    if (!empty($tourDetail)) {
        // Thực hiện xóa người dùng
        $deleteTour = delete('tours', "id_tours = $tourId");  
    } 
} 

// Điều hướng lại trang danh sách người dùng
redirect('../admin/admin.php?page=category');
?>
