<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "traveltoursweb";

// Tạo kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Thực hiện truy vấn lấy danh sách người dùng
$kq = $conn->query("SELECT * FROM user");
$stt = 1;
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
<?php include '../../templates/layout/header.php'; ?>
<div class="container">
    <hr>
    <h2>Quản lý người dùng</h2>
    <p>
        <a href="#" class="btn btn-them">Thêm người dùng <i class="fa-solid fa-plus"></i></a>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Password</th>
                <th>Trạng thái</th>
                <th width="5%">Sửa</th>
                <th width="5%">Xóa</th>
            </tr>
        </thead>
        <tbody>
        <?php
            // Kiểm tra nếu có dữ liệu
            if ($kq && $kq->num_rows > 0) {
                while ($d = $kq->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $stt++ . "</td>";
                    echo "<td>" . $d['username'] . "</td>";
                    echo "<td>" . $d['email'] . "</td>";
                    echo "<td>" . $d['phone'] . "</td>"; 
                    echo "<td>" . $d['password'] . "</td>";
                    if ($d['status'] == 0) {
                        echo "<td><span class='status-btn'>Đã kích hoạt</span></td>";
                    } else {
                        echo "<td><span class='status-btn'>Chưa kích hoạt</span></td>";
                    }
                    echo "<td><a href='#' class='btn btn-sua'><i class='fa-solid fa-pen-to-square'></i></a></td>";
                    echo "<td><a href='#' class='btn btn-xoa'><i class='fa-solid fa-trash'></i></a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>Không có dữ liệu</td></tr>";
            }
        ?>
        </tbody>
    </table>
</div>
<?php   include '../../templates/layout/footer.php';?>
</body>
</html>
