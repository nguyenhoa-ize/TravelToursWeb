<?php
include '../../config.php';
include '../../includes/connect.php';
include '../../includes/database.php';
include '../../includes/functions.php';
include '../../includes/session.php';



$filterAll = filter();
if (!empty($filterAll['id'])) {
    $userId = $filterAll['id'];
    $userDetail = getRows("SELECT * FROM user WHERE id = $userId");
    if ($userDetail > 0) {
        // Xóa user
        $deleteUser = delete('user', "id = $userId");
        if ($deleteUser) {
            setFlashData('smg', 'Xóa người dùng thành công.');
            setFlashData('smg_type', 'success');
        } else {
            setFlashData('smg', 'Lỗi khi xóa người dùng.');
            setFlashData('smg_type', 'danger');
        }
    } else {
        setFlashData('smg', 'Người dùng không tồn tại trong hệ thống.');
        setFlashData('smg_type', 'danger');
    }
} else {
    setFlashData('smg', 'Liên kết không tồn tại.');
    setFlashData('smg_type', 'danger');
}

// Điều hướng lại trang danh sách người dùng
redirect('admin.php');

