<?php
include '../../config.php';
include '../../templates/layout/header.php';
include '../../includes/connect.php';
include '../../includes/database.php';
include '../../includes/functions.php';
include '../../includes/session.php';

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    redirect('login.php'); // Nếu chưa đăng nhập, chuyển hướng tới trang login
    exit();
}

// Thêm sản phẩm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = $quantity;
    }
    setFlashData('msg', 'Thêm vào giỏ hàng thành công!');
    setFlashData('msg_type', 'success');
    redirect('cart.php');
    exit();
}

// Xóa sản phẩm khỏi giỏ hàng
if (isset($_POST['remove_from_cart'])) {
    $product_id = (int)$_POST['product_id'];
    unset($_SESSION['cart'][$product_id]);
    setFlashData('msg', 'Xóa sản phẩm khỏi giỏ hàng thành công!');
    setFlashData('msg_type', 'success');
    redirect('cart.php');
    exit();
}

// Cập nhật số lượng sản phẩm trong giỏ hàng
if (isset($_POST['update_cart'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];
    $_SESSION['cart'][$product_id] = $quantity;
    setFlashData('msg', 'Cập nhật giỏ hàng thành công!');
    setFlashData('msg_type', 'success');
    redirect('cart.php');
    exit();
}

// Lấy thông tin sản phẩm từ cơ sở dữ liệu
function getProduct($product_id) {
    global $conn1;
    $sql = "SELECT * FROM tours WHERE id_tours = ?";
    $stmt = $conn1->prepare($sql);
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Xử lý khi người dùng nhấn nút "ĐẶT TOUR"
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fullname'])) {
    $fullname = trim($_POST['fullname']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $email = trim($_POST['email']);
    $date = trim($_POST['date']);
    $note = trim($_POST['note']);
    $paymentMethod = $_POST['payment_method'];

    if (!empty($fullname) && !empty($phone) && !empty($address) && !empty($email) && !empty($date)) {
        $bookingCode = uniqid("BOOK_");

        $totalPrice = 0;
        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            $product = getProduct($product_id);
            $totalPrice += ($product['price'] * $quantity);
        }

        $sql = "INSERT INTO bookings (booking_code, fullname, phone, address, email, date, note, payment_method, total_price) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn1->prepare($sql);
        $stmt->bind_param(
            'ssssssssd',
            $bookingCode,
            $fullname,
            $phone,
            $address,
            $email,
            $date,
            $note,
            $paymentMethod,
            $totalPrice
        );

        if ($stmt->execute()) {
            setFlashData('msg', 'Đặt tour thành công! Mã đặt tour của bạn là: ' . $bookingCode);
            setFlashData('msg_type', 'success');
            $_SESSION['cart'] = []; // Xóa giỏ hàng sau khi đặt tour thành công
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

// Hiển thị thông báo
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng</title>
    <link rel="stylesheet" href="../../templates/css/style_cart.css">
</head>
<body>

<div class="container">
    <h1>Giỏ Hàng</h1>
    <?php if ($msg): ?>
        <div class="alert <?= $msg_type ?>"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <table class="cart-table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalPrice = 0;
                foreach ($_SESSION['cart'] as $product_id => $quantity):
                    $product = getProduct($product_id);
                ?>
                <tr>
                    <td><?= $product['name'] ?></td>
                    <td>
                        <input type="number" name="quantity" value="<?= $quantity ?>" min="1">
                        <input type="hidden" name="product_id" value="<?= $product_id ?>">
                    </td>
                    <td><?= number_format($product['price'], 0, ',', '.') ?> VND</td>
                    <td>
                        <button type="submit" name="update_cart">Cập nhật</button>
                        <button type="submit" name="remove_from_cart">Xóa</button>
                    </td>
                </tr>
                <?php
                    $totalPrice += ($product['price'] * $quantity);
                endforeach;
                ?>
            </tbody>
        </table>
        <div class="total-price">
            <strong>Tổng cộng: <?= number_format($totalPrice, 0, ',', '.') ?> VND</strong>
        </div>

        <h2>Thông Tin Đặt Tour</h2>
        <label for="fullname">Họ và tên:</label>
        <input type="text" name="fullname" id="fullname" required>

        <label for="phone">Số điện thoại:</label>
        <input type="text" name="phone" id="phone" required>

        <label for="address">Địa chỉ:</label>
        <input type="text" name="address" id="address" required>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>

        <label for="date">Ngày đi:</label>
        <input type="date" name="date" id="date" required>

        <label for="note">Ghi chú:</label>
        <textarea name="note" id="note"></textarea>

        <label for="payment_method">Phương thức thanh toán:</label>
        <select name="payment_method" id="payment_method">
            <option value="cod">Thanh toán khi nhận hàng</option>
            <option value="online">Thanh toán online</option>
        </select>

        <button type="submit">Đặt Tour</button>
    </form>
</div>

</body>
</html>
