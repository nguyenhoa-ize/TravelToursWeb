<?php
include "../../config.php";
include "../../includes/connect.php";
include "../../includes/functions.php";
include '../../includes/session.php';

if (isPOST() && !empty(getSession('id_user'))) {
    // Lấy dữ liệu từ form
    $id_user = getSession('id_user');
    $tour_id = isset($_POST['ma-tour']) ? $_POST['ma-tour'] : '';
    $selected_date = isset($_POST['selected-date']) ? $_POST['selected-date'] : '';

    if (!empty($selected_date)) {
        // Chuyển đổi từ định dạng d/m/Y sang Y-m-d
        $dateObject = DateTime::createFromFormat('d/m/Y', $selected_date);
        if ($dateObject) {
            $selected_date = $dateObject->format('Y-m-d'); // Định dạng Y-m-d để lưu vào MySQL
        } else {
            $selected_date = null; // Xử lý lỗi định dạng nếu cần
        }
    } else {
        $selected_date = null; // Nếu không có ngày được chọn
    }

    $quantity = isset($_POST['so-luong']) ? intval($_POST['so-luong']) : 0;

    // Kiểm tra dữ liệu đầu vào
    if (empty($tour_id) || empty($selected_date) || $quantity <= 0) {
        echo "Vui lòng điền đầy đủ thông tin và số lượng hợp lệ!";
        exit;
    }

    // Lấy giá tour từ cơ sở dữ liệu
    $sql = "SELECT price, discount_price FROM tours WHERE id_tours = '$tour_id'";
    $kq = mysqli_query($conn1, $sql);

    if ($kq && mysqli_num_rows($kq) > 0) {
        $tour = mysqli_fetch_assoc($kq);
    } else {
        echo "Tour không tồn tại!";
        exit;
    }

    // Tính giá cuối cùng
    $price = !empty($tour['discount_price']) ? $tour['discount_price'] : $tour['price'];
    $total_price = $price * $quantity;

    // Lưu thông tin đặt tour vào cơ sở dữ liệu
    $insert_query = "INSERT INTO orders (id_tours, id_user, ngay_dat, thanh_tien, trang_thai) 
                     VALUES ('$tour_id', '$id_user', '$selected_date', $total_price, 0)";

    if (mysqli_query($conn1, $insert_query)) {
        // Thành công, chuyển hướng đến thank-you.php
        header('Location: cam-on.php');
        exit;
    } else {
        echo "Có lỗi xảy ra khi đặt tour: " ;
    }

    // Đóng kết nối
    mysqli_close($conn1);
}else {
    header('Location: ../auth/login.php');
    exit;
}
?>
