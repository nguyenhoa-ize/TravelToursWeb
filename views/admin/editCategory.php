<?php
    include '../../config.php';
    include '../../includes/connect.php';
    include '../../includes/database.php';
    include '../../includes/functions.php';
    include '../../includes/session.php';
?>

<?php 

// Khởi tạo biến thông báo
$messenger = [];  // Mảng chứa thông báo lỗi hoặc thành công

// Lấy dữ liệu đầu vào
$filterAll = filter();
if (!empty($filterAll['id_tours'])) {
    $tourID = $filterAll['id_tours'];
    $tourDetail = oneRaw("SELECT * FROM tours WHERE id_tours='$tourID'");
    if (!empty($tourDetail)) {
        $old = $tourDetail;
    } else {
        redirect("?page=edit_category");
    }
}

if (isPost()) {
    $filterAll = filter();
    // Validate giá
    if (empty($filterAll['price'])) {
        $messenger['price']['required'] = 'Giá tours là bắt buộc.';
    } else if (!is_numeric($filterAll['price']) || $filterAll['price'] <= 0) {
        $messenger['price']['valid'] = 'Giá phải là số và lớn hơn 0.';
    }

    // Validate giảm giá
    if (!empty($filterAll['discount_price']) && (!is_numeric($filterAll['discount_price']) || $filterAll['discount_price'] < 0)) {
        $messenger['discount_price']['valid'] = 'Giá giảm phải là số không âm.';
    }

    // Kiểm tra ảnh (tùy chọn)
    if (!empty($_FILES['image']['name'])) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (!in_array(strtolower($fileExtension), $allowedExtensions)) {
            $messenger['image']['valid'] = 'Ảnh không đúng định dạng (jpg, jpeg, png, gif).';
        }
    } else {
        if (empty($old['image'])) {
            $messenger['image']['required'] = 'Hãy chọn ảnh nếu muốn thay đổi ảnh.';
        }
    }

    if (empty($messenger)) {
        $image = !empty($_FILES['image']['name']) ? $_FILES['image']['name'] : $old['image'];
        $discountPrice = !empty($filterAll['discount_price']) ? $filterAll['discount_price'] : null;

        $dataUpdate = [
            'name' => $filterAll['name'],
            'description' => $filterAll['description'],
            'price' => $filterAll['price'],
            'discount_price' => $discountPrice,
            'image' => $image,
            'is_popular' => $filterAll['is_popular'],
        ];

        if (isset($tourID) && !empty($tourID)) {
            $updateStatus = update('tours', $dataUpdate, "id_tours = '$tourID'");
            if ($updateStatus) {
                $_SESSION['messenger'] = ['success' => 'Cập nhật tours thành công!'];
            } else {
                $_SESSION['messenger'] = ['danger' => 'Không thể cập nhật sản phẩm.'];
            }
        } else {
            $_SESSION['messenger'] = ['danger' => 'Không xác định được sản phẩm để cập nhật.'];
        }
    } else {
        $_SESSION['messenger'] = $messenger;
        $_SESSION['general_error'] = 'Vui lòng kiểm tra lại dữ liệu.';
    }

    redirect('?page=category&action=edit_category&id_tours='.$tourID);
}
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
    <div class="alert-container">
        <!-- Hiển thị thông báo chung -->
        <?php if (isset($_SESSION['general_error'])): ?>
            <div class="alert danger">
                <?php echo $_SESSION['general_error']; unset($_SESSION['general_error']); ?>
            </div>
        <?php endif; ?>

        <!-- Hiển thị thông báo thành công -->
        <?php if (isset($_SESSION['messenger']['success'])): ?>
            <div class="alert success">
                <?php echo $_SESSION['messenger']['success']; unset($_SESSION['messenger']['success']); ?>
            </div>
        <?php endif; ?>

        <!-- Hiển thị thông báo lỗi -->
        <?php if (isset($_SESSION['messenger']['danger'])): ?>
            <div class="alert danger">
                <?php echo $_SESSION['messenger']['danger']; unset($_SESSION['messenger']['danger']); ?>
            </div>
        <?php endif; ?>
    </div>

    <?php 
    $messenger = isset($_SESSION['messenger']) ? $_SESSION['messenger'] : [];
    unset($_SESSION['messenger']); 
    ?>

    <form action="" method="post" enctype="multipart/form-data">
        <h2>Sửa tours</h2>

        <div class="form-group">
            <div class="form-item">
                <label for="name">Tên tours</label>
                <input type="text" name="name" id="name" placeholder="Tên tours" required
                       value="<?php echo old('name', $old); ?>">
                <?php if (isset($messenger['name'])): ?>
                    <span class="error"><?php echo implode(', ', $messenger['name']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-item">
                <label for="price">Giá</label>
                <input type="number" name="price" id="price" placeholder="Giá tours" required
                       value="<?php echo old('price', $old); ?>">
                <?php if (isset($messenger['price'])): ?>
                    <span class="error"><?php echo implode(', ', $messenger['price']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="form-item">
                <label for="is_popular">Loại tours</label>
                <select name="is_popular" id="is_popular">
                    <option value="0" <?php echo (old('is_popular', $old) == '0') ? 'selected' : ''; ?>>Bình thường</option>
                    <option value="1" <?php echo (old('is_popular', $old) == '1') ? 'selected' : ''; ?>>Phổ biến</option>
                </select>
            </div>

            <div class="form-item">
                <label for="discount_price">Giá giảm</label>
                <input type="number" name="discount_price" id="discount_price" placeholder="Giá giảm" 
                       value="<?php echo old('discount_price', $old); ?>">
                <?php if (isset($messenger['discount_price'])): ?>
                    <span class="error"><?php echo implode(', ', $messenger['discount_price']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <div class="form-item">
                <label for="is_domestic">Tours</label>
                <select name="is_domestic" id="is_domestic">
                    <option value="0" <?php echo (old('is_domestic', $old) == '0') ? 'selected' : ''; ?>>Trong nước</option>
                    <option value="1" <?php echo (old('is_domestic', $old) == '1') ? 'selected' : ''; ?>>Ngoài nước</option>
                </select>
            </div>

            <div class="form-item">
                <label for="image">Hình Ảnh</label>
                <input type="file" name="image" id="image">
                <?php if (isset($messenger['image'])): ?>
                    <span class="error"><?php echo implode(', ', $messenger['image']); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-item">
            <label for="description">Mô Tả</label>
            <textarea style="width: 800px;height: 176px;" name="description" id="description"><?php echo old('description', $old); ?></textarea>
            <?php if (isset($messenger['description'])): ?>
                <span class="error"><?php echo implode(', ', $messenger['description']); ?></span>
            <?php endif; ?>
        </div>
        <div class="form-buttons">
            <button type="submit" class="btn-primary">Sửa Tours</button>
            <button type="button" class="btn-secondary" onclick="window.location.href='?page=category'">Quay lại</button>
        </div>
        <input type="hidden" name="id_tours" value="<?php echo $tourID; ?>">
    </form>
</div>

</body>
</html>

