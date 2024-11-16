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
    $errors = []; // Mảng chứa lỗi

    // Validate tên sản phẩm
    if (empty($filterAll['name'])) {
        $errors['name']['required'] = 'Tên sản phẩm là bắt buộc.';
    }

    // Validate mô tả
    if (empty($filterAll['description'])) {
        $errors['description']['required'] = 'Mô tả là bắt buộc.';
    }

    // Validate giá
    if (empty($filterAll['price'])) {
        $errors['price']['required'] = 'Giá sản phẩm là bắt buộc.';
    } else if (!is_numeric($filterAll['price']) || $filterAll['price'] <= 0) {
        $errors['price']['valid'] = 'Giá phải là số và lớn hơn 0.';
    }
    // Validate giảm giá
    if (!is_numeric($filterAll['discount_price']) || $filterAll['discount_price'] <= 0) {
        $errors['discount_price']['valid'] = 'Giá phải là số và lớn hơn 0.';
    }

    // Validate ảnh (tùy chọn)
    if (empty($_FILES['image']['name'])) {
        $errors['image']['required'] = 'Bạn cần chọn một hình ảnh.';
    } else {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            $errors['image']['valid'] = 'Ảnh không đúng định dạng (jpg, jpeg, png, gif).';
        }
    }

    if (empty($errors)) {
        $dataInsert = [
            'name' => $filterAll['name'],
            'description' => $filterAll['description'],
            'price' => $filterAll['price'],
            'discount_price' => $filterAll['discount_price'],
            'image' => $_FILES['image']['name'],
            'is_popular' => $filterAll['is_popular'],
        ];

        $insertStatus = insert('tours', $dataInsert);
        if ($insertStatus) {
            setFlashData('msg', 'Thêm sản phẩm thành công!');
            setFlashData('msg_type', 'success');
            redirect('?page=category');
        } else {
            setFlashData('msg', 'Không thêm được sản phẩm.');
            setFlashData('msg_type', 'danger');
            redirect('?page=category&action=add_category');
        }
    } else {
        setFlashData('msg', 'Vui lòng kiểm tra lại dữ liệu.');
        setFlashData('msg_type', 'danger');
        setFlashData('errors', $errors);
        setFlashData('old', $filterAll);
        redirect('?page=category&action=add_category');
    }
}

// Lấy dữ liệu flash
$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../templates/css/styleAdd.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
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
                <?php echo form_error('name', '<span class="error">', '</span>', $errors); ?>
            </div>
            
            <div class="form-item">
                <label for="price">Giá</label>
                <input type="number" name="price" id="price" placeholder="Giá sản phẩm" required
                       value="<?php echo old('price', $old); ?>">
                <?php echo form_error('price', '<span class="error">', '</span>', $errors); ?>
            </div>
        </div>

       
        
        <div class="form-group">
            <div class="form-item">
                <label for="is_popular">Loại tours</label>
                <select name="is_popular" id="is_popular" >
                    <option value="0" <?php echo (old('is_popular', $old) == '0') ? 'selected' : ''; ?>>Bình thường</option>
                    <option value="1" <?php echo (old('is_popular', $old) == '1') ? 'selected' : ''; ?>>phổ biến</option>
                </select>
                <?php echo form_error('is_popular', '<span class="error">', '</span>', $errors); ?>
            </div>
            <div class="form-item">
                <label for="discount_price">Giảm giá</label>
                <input type="number" name="discount_price" id="discount_price" placeholder="Giảm giá" required
                       value="<?php echo old('discount_price', $old); ?>">
                <?php echo form_error('discount_price', '<span class="error">', '</span>', $errors); ?>
            </div>
        </div>
        <div class="form-item">
                <label for="image">Hình Ảnh</label>
                <input type="file" name="image" id="image" required>
                <?php echo form_error('image', '<span class="error">', '</span>', $errors); ?>
            </div>
        <div class="form-item">
                <label for="description">Mô Tả</label>
                <textarea style="width: 800px;height: 176px;" name="description" id="description" placeholder="Mô tả sản phẩm" required><?php echo old('description', $old); ?></textarea>
                <?php echo form_error('description', '<span class="error">', '</span>', $errors); ?>
            </div>
        
        <div class="form-buttons">
            <button type="submit" class="btn-primary">Thêm Sản Phẩm</button>
            <button type="button" class="btn-secondary" onclick="window.location.href='?page=category'">Quay lại</button>
        </div>
    </form>
</div>

</body>
</html>