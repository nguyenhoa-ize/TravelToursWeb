<?php
include '../../config.php';
include '../../templates/layout/header.php';
include '../../includes/connect.php';
include '../../includes/database.php';
include '../../includes/functions.php';
include '../../includes/session.php';

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    redirect('login.php'); // Nếu chưa đăng nhập, chuyển hướng tới trang login
    exit();
}

// Xử lý khi người dùng nhấn nút "ĐẶT TOUR"
if (isPost()) {
    $filterAll = filter();

    // Lấy thông tin từ form
    $fullname = trim($filterAll['fullname']);
    $phone = trim($filterAll['phone']);
    $address = trim($filterAll['address']);
    $email = trim($filterAll['email']);
    $date = trim($filterAll['date']);
    $note = trim($filterAll['note']);
    $paymentMethod = $filterAll['payment_method'];

    // Kiểm tra các trường bắt buộc
    if (!empty($fullname) && !empty($phone) && !empty($address) && !empty($email) && !empty($date)) {
        // Tạo mã đặt tour ngẫu nhiên
        $bookingCode = uniqid("BOOK_");
        
        // Lưu thông tin đặt tour vào cơ sở dữ liệu
        $query = "INSERT INTO bookings (booking_code, fullname, phone, address, email, date, note, payment_method, total_price) 
                  VALUES ('$bookingCode', '$fullname', '$phone', '$address', '$email', '$date', '$note', '$paymentMethod', 1600000)";
        
        if (execute($query)) {
            setFlashData('msg', 'Đặt tour thành công! Mã đặt tour của bạn là: ' . $bookingCode);
            setFlashData('msg_type', 'success');
        } else {
            setFlashData('msg', 'Đã xảy ra lỗi khi đặt tour. Vui lòng thử lại.');
            setFlashData('msg_type', 'danger');
        }
        redirect('cart.php');
        exit();
    } else {
        setFlashData('msg', 'Vui lòng nhập đầy đủ thông tin.');
        setFlashData('msg_type', 'danger');
        redirect('cart.php');
        exit();
    }
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đặt Tour Du Lịch</title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../templates/css/style_cart.css">
</head>
<body>
<div class="cart-container">
    <form action="" method="post">
        <h2>Thông tin đặt tour</h2>
        <?php if (!empty($msg)) { getSmg($msg, $msg_type); } ?>
        
        <table>
            <tr>
                <td><label for="fullname">Họ tên *</label></td>
                <td><input type="text" name="fullname" id="fullname" required placeholder="Nhập họ tên"></td>
            </tr>
            <tr>
                <td><label for="phone">Số điện thoại *</label></td>
                <td><input type="text" name="phone" id="phone" required placeholder="Nhập số điện thoại"></td>
            </tr>
            <tr>
                <td><label for="address">Địa chỉ *</label></td>
                <td><input type="text" name="address" id="address" required placeholder="Nhập địa chỉ"></td>
            </tr>
            <tr>
                <td><label for="email">Email</label></td>
                <td><input type="email" name="email" id="email" placeholder="Nhập email"></td>
            </tr>
            <tr>
                <td><label for="date">Chọn ngày khởi hành *</label></td>
                <td><input type="date" name="date" id="date" required></td>
            </tr>
            <tr>
                <td><label for="note">Ghi chú</label></td>
                <td><textarea name="note" id="note" placeholder="Ghi chú thêm"></textarea></td>
            </tr>
            <tr>
                <td><label for="payment_method">Phương thức thanh toán *</label></td>
                <td>
                    <div>
                        <input type="radio" name="payment_method" id="bank_transfer" value="Chuyển khoản ngân hàng" required>
                        <label for="bank_transfer">Chuyển khoản ngân hàng</label>
                    </div>
                    <div>
                        <input type="radio" name="payment_method" id="office_payment" value="Thanh toán tại văn phòng">
                        <label for="office_payment">Thanh toán tại văn phòng</label>
                    </div>
                    <div>
                        <input type="radio" name="payment_method" id="credit_card" value="Thanh toán bằng thẻ">
                        <label for="credit_card">Thanh toán bằng thẻ</label>
                    </div>
                </td>
            </tr>
        </table>

        <p><strong>Tổng cộng: 1,600,000 VND</strong></p>
        <button type="submit">ĐẶT TOUR</button>
    </form>
</div>
<?php include '../../templates/layout/footer.php'; ?>
</body>
</html>
