<?php
include '../../config.php';
include '../../includes/connect.php';
include '../../includes/database.php';
include '../../includes/functions.php';
include '../../includes/session.php';

$filterAll = filter();
if (!empty($filterAll['id'])) {
    $tourId = $filterAll['id'];

    // Sử dụng prepared statements để tránh SQL injection
    $tourDetail = getRows("SELECT *  FROM tours WHERE id = $tourId");

    // Kiểm tra nếu người dùng tồn tại
    if (!empty($tourDetail)) {
        // Thực hiện xóa người dùng
        $deleteTour = delete('tours', "id = $tourId");  
        if ($deleteTour) {
            setFlashData('smg', 'Xóa tour thành công.');
            setFlashData('smg_type', 'success');
        } else {
            setFlashData('smg', 'Lỗi khi xóa tour.');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'tour không tồn tại trong hệ thống.');
        setFlashData('smg_type', 'danger');
    }
} else {
    setFlashData('smg', 'Liên kết không tồn tại.');
    setFlashData('smg_type', 'danger');
}

// Điều hướng lại trang danh sách người dùng
redirect('../admin/admin.php?page=category');
?>
