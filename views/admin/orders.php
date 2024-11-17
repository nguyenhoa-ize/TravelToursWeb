<?php
$servername = "localhost:3307";
$username = "root";
$password = ""; 
$dbname = "traveltoursweb";

// Tạo kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Thực hiện truy vấn lấy danh sách người dùng
$kq = $conn->query("SELECT * FROM tours");
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
                <th>Giảm giá</th>
                <th>Trạng thái</th>
                <th >Thông tin đơn hàng</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Kiểm tra nếu có dữ liệu
            if ($kq && $kq->num_rows > 0) {
                while ($d = $kq->fetch_assoc()) {
            ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>
                            <a href=""></a>
                        </td>
                        <td>
                            <a href="" ></a>                        
                        </td>
                    </tr>
            <?php
                }
            } else {
            ?>
                <tr><td colspan="8">Không có dữ liệu</td></tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
