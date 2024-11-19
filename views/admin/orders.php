<?php


$message = ""; // Biến lưu thông báo

// Cập nhật trạng thái đơn hàng nếu có form gửi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_status'])) {
    $order_id = $_POST['id_order']; 
    $new_status = $_POST['status']; 

    // Câu lệnh UPDATE với 'id_order'
    $update_query = "UPDATE orders SET trang_thai = '$new_status' WHERE id_order = '$order_id'"; 
    
    if ($conn1->query($update_query) === TRUE) {
        $message = "Cập nhật trạng thái đơn hàng thành công!"; // Thông báo thành công
    } else {
        $message = "Lỗi cập nhật: " . $conn1->error; // Thông báo lỗi nếu có
    }
}

// Thực hiện truy vấn lấy danh sách đơn hàng
$kq = $conn1->query("SELECT * FROM orders");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../templates/css/stylesAdmin.css">
    <link rel="stylesheet" href="../../templates/css/style.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="container">
<?php if ($message): ?>
        <div class="alert">
            <?php echo $message; ?> 
        </div>
    <?php endif; ?>
    <hr>
    <h2>Quản lý đơn hàng</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID tours</th>
                <th>ID người dùng</th>
                <th>Tên người đặt</th>
                <th>Thành tiền</th>
                <th>Ngày đặt</th>
                <th>Phương thức thanh toán</th>
                <th>Trạng thái</th>
                <th>Thông tin đơn hàng</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Kiểm tra nếu có dữ liệu
                if ($kq && $kq->num_rows > 0) {
                    while ($d = $kq->fetch_assoc()) {
            ?>
                        <tr>
                            <td><?php echo $d['id_tours'] ?></td>
                            <td><?php echo $d['id_user'] ?></td>
                            <td><?php echo $d['ten_nguoi_dat'] ?></td>
                            <td><?php echo $d['thanh_tien'] ?></td>
                            <td><?php echo $d['ngay_dat'] ?></td>
                            <td><?php echo $d['phuong_thuc_tt'] ?></td>
                            <td>
                                <form method="POST" action="">
                                    <input type="hidden" name="id_order" value="<?php echo $d['id_order'] ?>"> <!-- Sử dụng 'id_order' -->
                                    <select name="status">
                                        <option value="0" <?php echo ($d['trang_thai'] == 0) ? 'selected' : ''; ?>>Chưa thanh toán</option>
                                        <option value="1" <?php echo ($d['trang_thai'] == 1) ? 'selected' : ''; ?>>Đã thanh toán</option>
                                        <option value="2" <?php echo ($d['trang_thai'] == 2) ? 'selected' : ''; ?>>Đang xử lý</option>
                                        <option value="3" <?php echo ($d['trang_thai'] == 3) ? 'selected' : ''; ?>>Đã hoàn thành</option>
                                    </select>
                                    <button type="submit" name="update_status">Cập nhật</button>
                                </form>
                            </td>
                            <td><?php echo $d['thong_tin_don_hang'] ?></td>
                        </tr>
            <?php
                    }
                } else {
            ?>
                    <tr><td colspan="9">Không có dữ liệu</td></tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
