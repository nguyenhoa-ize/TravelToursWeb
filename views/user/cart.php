<?php
include '../../config.php';
include '../../includes/connect.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start(); 
}

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../../views/user/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tours = $_POST['id_tours'];
    $name_tour = $_POST['name_tour'];
    $ten_nguoi_dat = $_SESSION['fullname'];
    $thanh_tien = isset($_POST['discount_price']) && $_POST['discount_price'] !== NULL ? $_POST['discount_price'] : $_POST['price'];
    $ngay_dat = date('Y-m-d H:i:s');
    $phuong_thuc_tt = "Online";
    $trang_thai = 0;

    if (empty($id_tours) || empty($name_tour) || empty($thanh_tien)) {
        echo "Tất cả các trường là bắt buộc!";
        exit;
    }

    // Insert order with dynamic name_tour fetched from the database
    $sql_insert = "INSERT INTO orders (id_tours, name_tour, ten_nguoi_dat, thanh_tien, ngay_dat, phuong_thuc_tt, trang_thai, id_user) 
                   SELECT '$id_tours', name, '$ten_nguoi_dat', '$thanh_tien', '$ngay_dat', '$phuong_thuc_tt', '$trang_thai', '{$_SESSION['id_user']}'
                   FROM tours WHERE id_tours = '$id_tours'";
    
    if (mysqli_query($conn1, $sql_insert)) {
        echo "Đặt hàng thành công!";
    } else {
        echo "Lỗi: " . mysqli_error($conn1);
    }
}

$id_user = $_SESSION['id_user'];
$sql = "SELECT orders.*, tours.departure_point, tours.destination_point
        FROM orders
        JOIN tours ON orders.id_tours = tours.id_tours
        WHERE orders.id_user = '$id_user'";
$kq = mysqli_query($conn1, $sql);
if (mysqli_num_rows($kq) === 0) {
    echo "<p>Không có đơn hàng nào được tìm thấy.</p>";
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Đơn Hàng</title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="../../templates/css/style_cart.css">

</head>
<body>
    <?php include "../../templates/layout/header.php"; ?>
    <div class="content">
        <div class="danhsach-donhang">
            <div class="donhang-container">
                <?php if ($kq) {
                    while ($order = mysqli_fetch_assoc($kq)) {
                ?>
                    <div class="the-donhang">
                        <div class="cot-thong-tin">
                            <div class="thong-tin-donhang">
                                <span class="ma-donhang">Mã đơn hàng: <?php echo $order['id_order']; ?></span>
                                <h3 class="tieu-de-donhang">
                                    <a href="<?php echo SITE_URL . 'views/user/tour-detail.php?id=' . $order['id_order']; ?>"><?php echo $order['name_tour']; ?></a>
                                </h3>
                                <div class="thoi-gian-donhang">
                                    <svg width="24px" height="24px" viewBox="0 0 20 20"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-7.59V4h2v5.59l3.95 3.95-1.41 1.41L9 10.41z"/></svg> Ngày đặt: <?php echo $order['ngay_dat']; ?>
                                </div>
                            </div>
                            <div class="meta-donhang">
                                <p>Khách hàng: <span><?php echo $order['ten_nguoi_dat']; ?></span></p>
                                <p>Điểm đi: <span><?php echo $order['departure_point']; ?></span></p>
                                <p>Điểm đến: <span><?php echo $order['destination_point']; ?></span></p>
                                <div class="gia-donhang">
                                    <?php echo number_format($order['thanh_tien'], 0, ',', '.') . ' VND'; ?>
                                </div>
                                <p>Trạng thái: <span><?php echo $order['trang_thai'] == 0 ? 'Chưa thanh toán' : 'Đã thanh toán'; ?></span></p>
                                
                                <!-- Button "Thanh toán" -->
                                <?php if ($order['trang_thai'] == 0) { ?>
                                    <a href="payment.php?id_order=<?php echo $order['id_order']; ?>" class="btn btn-thanh-toan">
                                        Thanh toán
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php
                    }
                } else {
                    echo "Error: " . mysqli_error($conn1);
                } ?>
            </div>
        </div>
    </div>

    <?php include "../../templates/layout/footer.php"; ?>
</body>
</html>