<?php
    include '../../config.php';
    include '../../includes/connect.php';
    include '../../includes/database.php';
    include '../../includes/functions.php';
    include '../../includes/session.php';
?>
<?php 
if (isPost()) {
    $filterAll = filter(); // Giả sử filter() là hàm xử lý dữ liệu input
    $_SESSION['messenger'] = []; // Chứa thông báo lỗi nếu có

    // Validate giá
    if (!is_numeric($filterAll['price']) || $filterAll['price'] <= 0) {
        $_SESSION['messenger']['price']['valid'] = 'Giá phải là số và lớn hơn 0.';
    }

    // Validate giảm giá
    if (!is_numeric($filterAll['discount_price']) || $filterAll['discount_price'] <= 0) {
        $_SESSION['messenger']['discount_price']['valid'] = 'Giảm giá phải là số và lớn hơn 0.';
    }

    // Validate ảnh (nhiều ảnh)
    if (empty($_FILES['images']['name'][0])) {
        $_SESSION['messenger']['images']['required'] = 'Bạn cần chọn ít nhất một hình ảnh.';
    } else {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $uploadedImages = $_FILES['images'];

        foreach ($uploadedImages['name'] as $index => $fileName) {
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
                $_SESSION['messenger']['images']['valid'] = 'Một hoặc nhiều ảnh không đúng định dạng (jpg, jpeg, png, gif).';
                break;
            }
        }
    }

    if (empty($_SESSION['messenger'])) {
        // Xử lý upload các ảnh
        $uploadedFiles = [];
        $uploadDir = '../../templates/image/tours/'; // Thư mục lưu ảnh

        foreach ($_FILES['images']['name'] as $index => $fileName) {
            $targetFile = $uploadDir . basename($fileName);
            if (move_uploaded_file($_FILES['images']['tmp_name'][$index], $targetFile)) {
                $uploadedFiles[] = $fileName;
            }
        }

        // Chuyển danh sách ảnh thành chuỗi
        $images = implode(',', $uploadedFiles);

        // Dữ liệu để insert vào database
        $dataInsert = [
            'name' => $filterAll['name'],
            'description' => $filterAll['description'],
            'price' => $filterAll['price'],
            'discount_price' => $filterAll['discount_price'],
            'image' => $images, // Lưu chuỗi ảnh
            'is_popular' => $filterAll['is_popular'],
        ];

        $insertStatus = insert('tours', $dataInsert);
        header('Location: ?page=category');
        exit();
    } else {
        $_SESSION['old'] = $filterAll;
        header('Location: ?page=category&action=add_category');
        exit();
    }
}

$messenger = isset($_SESSION['messenger']) ? $_SESSION['messenger'] : [];
$old = isset($_SESSION['old']) ? $_SESSION['old'] : [];

// Xóa session sau khi hiển thị thông báo
unset($_SESSION['messenger']);
unset($_SESSION['old']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../templates/css/styleAdd.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Thêm Sản Phẩm</title>
</head>
<body>
<div class="register-container">
    <form action="" method="post" enctype="multipart/form-data">
        <h2>Thêm Sản Phẩm</h2>
        
        <div class="form-group">
            <div class="form-item">
                <label for="name">Tên Sản Phẩm</label>
                <input type="text" name="name" id="name" placeholder="Tên sản phẩm" required
                       value="<?php echo old('name', $old); ?>">
                <?php echo form_error('name', '<span class="error">', '</span>', $messenger); ?>
            </div>
            
            <div class="form-item">
                <label for="price">Giá</label>
                <input type="number" name="price" id="price" placeholder="Giá sản phẩm" required
                       value="<?php echo old('price', $old); ?>">
                <?php echo form_error('price', '<span class="error">', '</span>', $messenger); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="form-item">
                <label for="is_popular">Loại tours</label>
                <select name="is_popular" id="is_popular" >
                    <option value="0" <?php echo (old('is_popular', $old) == '0') ? 'selected' : ''; ?>>Bình thường</option>
                    <option value="1" <?php echo (old('is_popular', $old) == '1') ? 'selected' : ''; ?>>phổ biến</option>
                </select>
                <?php echo form_error('is_popular', '<span class="error">', '</span>', $messenger); ?>
            </div>
            <div class="form-item">
                <label for="discount_price">Giảm giá</label>
                <input type="number" name="discount_price" id="discount_price" placeholder="Giảm giá" required
                       value="<?php echo old('discount_price', $old); ?>">
                <?php echo form_error('discount_price', '<span class="error">', '</span>', $messenger); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="form-item">
                <label for="is_domestic">Tours</label>
                <select name="is_domestic" id="is_domestic" >
                    <option value="0" <?php echo (old('is_domestic', $old) == '0') ? 'selected' : ''; ?>>Trong nước</option>
                    <option value="1" <?php echo (old('is_domestic', $old) == '1') ? 'selected' : ''; ?>>Ngoài nước</option>
                </select>
                <?php echo form_error('is_domestic', '<span class="error">', '</span>', $messenger); ?>
            </div>
            <div class="form-item">
                <label for="images">Hình Ảnh</label>
                <input type="file" name="images[]" id="images" multiple required>
                <?php echo form_error('images', '<span class="error">', '</span>', $messenger); ?>
            </div>
        </div>

        <div class="form-item">
            <label for="description">Mô Tả</label>
            <textarea style="width: 800px;height: 176px;" name="description" id="description" placeholder="Mô tả sản phẩm" required><?php echo old('description', $old); ?></textarea>
            <?php echo form_error('description', '<span class="error">', '</span>', $messenger); ?>
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-1">Thêm Sản Phẩm</button>
            <button type="button" class="btn-2" onclick="window.location.href='?page=category'">Quay lại</button>
        </div>
    </form>
</div>

</body>
</html>
