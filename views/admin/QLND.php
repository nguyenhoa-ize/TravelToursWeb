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


<div class="container">
    <hr>
    <h2>Quản lý người dùng</h2>
    <p>
        <a href="?page=QLND&action=add_user" class="btn btn-them">Thêm người dùng <i class="fa-solid fa-plus"></i></a>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
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
            ?>
                    <tr>
                        <td><?= $stt++ ?></td>
                        <td><?= $d['username'] ?></td>
                        <td><?= $d['email'] ?></td>
                        <td><?= $d['phone'] ?></td>
                        <td>
                            <?php if ($d['status'] == 0): ?>
                                <span class="status-btn">Đã kích hoạt</span>
                            <?php else: ?>
                                <span class="status-btn">Chưa kích hoạt</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?page=QLND&action=edit_user&id=<?= $d['id'] ?>" class="btn btn-sua">
                            <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                        <td>
                        <a href="delete.php?id=<?= $d['id'] ?>" class="btn btn-xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa người dùng này không?');">
                            <i class="fa-solid fa-trash"></i>
                        </a>                        
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
