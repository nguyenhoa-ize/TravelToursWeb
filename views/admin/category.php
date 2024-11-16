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
    <h2>Quản lý Tours du lịch</h2>
    <p>
        <a href="?page=category&action=add_category" class="btn btn-them">Thêm Tours <i class="fa-solid fa-plus"></i></a>
    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>STT</th>
                <th>Tours</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Giảm giá</th>
                <th>Ảnh</th>
                <th>Loại tours</th>
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
                        <td><?= $d['name'] ?></td>
                        <td><?= $d['description'] ?></td>
                        <td><?= $d['price'] ?></td>
                        <td><?= $d['discount_price'] ?></td>
                        <td> <img src="http://localhost/TravelToursWeb/templates/image/tours/<?php echo $d['image']; ?>" alt="Tour Image" style="width: 100px;" ></td>
                        <td>
                            <?php if ($d['is_popular'] == 0): ?>
                                <span class="status-btn">Bình thường</span>
                            <?php else: ?>
                                <span class="status-btn">Phổ biến</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?page=category&action=edit_category&id=<?= $d['id'] ?>" class="btn btn-sua">
                            <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                        <td>
                            <a href="deleteCategory.php?id=<?= $d['id'] ?>" class="btn btn-xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa tours này không?');">
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
