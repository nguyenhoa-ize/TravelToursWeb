
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
                <th>Điểm đi</th>
                <th>Điểm đến</th>
                <th>Ảnh</th>
                <th>Tours</th>
                <th>Loại tours</th>
                <th width="5%">Sửa</th>
                <th width="5%">Xóa</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $kq = $conn1->query("SELECT * FROM tours");
            $stt = 1;
            // Kiểm tra nếu có dữ liệu
            if ($kq && $kq->num_rows > 0) {
                while ($d = $kq->fetch_assoc()) {
                    // Tách chuỗi ảnh thành mảng
                    $images = explode(",", $d['image']);
            ?>
                    <tr>
                        <td><?= $stt++ ?></td>
                        <td><?= $d['name'] ?></td>
                        <td><?= $d['description'] ?></td>
                        <td><?= $d['price'] ?></td>
                        <td><?= $d['discount_price'] ?></td>
                        <td><?= $d['departure_point'] ?></td>
                        <td><?= $d['destination_point'] ?></td>
                        
                        <td>
                            <?php
                            // Lặp qua mảng ảnh và hiển thị từng ảnh
                            foreach ($images as $image) {
                                echo '<img src="http://localhost/TravelToursWeb/templates/image/tours/' . trim($image) . '" alt="Tour Image" style="width: 100px; margin-right: 5px;">';
                            }
                            ?>
                        </td>
                        <td>
                            <?php if ($d['is_domestic'] == 0): ?>
                                <span class="status-btn">Ngoài nước</span>
                            <?php else: ?>
                                <span class="status-btn">Trong nước</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($d['is_popular'] == 0): ?>
                                <span class="status-btn">Bình thường</span>
                            <?php else: ?>
                                <span class="status-btn">Phổ biến</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="?page=category&action=edit_category&id_tours=<?= $d['id_tours'] ?>" class="btn btn-sua">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </td>
                        <td>
                            <a href="deleteCategory.php?id_tours=<?= $d['id_tours'] ?>" class="btn btn-xoa" onclick="return confirm('Bạn có chắc chắn muốn xóa tours này không?');">
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
