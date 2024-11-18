<?php
    include '../../config.php';
    include '../../includes/connect.php';
    include '../../includes/database.php';
    include '../../includes/functions.php';

    if (isPost()) {
        $filterAll = filter();
        $password = $filterAll['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $_SESSION['messenger'] = []; // Chứa thông báo lỗi nếu có

        // Validate số điện thoại: bắt buộc phải nhập, số có đúng định dạng không
        if (!isPhone($filterAll['phone'])) {
            $_SESSION['messenger']['phone']['isPhone'] = 'Số điện thoại không hợp lệ.';
        }

        // Validate password: kiểm tra mật khẩu nhập lại
        if ($filterAll['password'] != $filterAll['confirm-password']) {
            $_SESSION['messenger']['confirm-password']['match'] = 'Mật khẩu bạn nhập lại không đúng.';
        }

        if (empty($_SESSION['messenger'])) {
            $dataInsert = [
                'username' => $filterAll['username'],
                'email' => $filterAll['email'],
                'phone' => $filterAll['phone'],
                'password' => $hashedPassword,
                'status' => $filterAll['status'],
                'created_at' => date('Y-m-d H:i:s')
            ];

            $insertStatus = insert('user', $dataInsert);
            header('Location: ?page=QLND');
            exit();
        } else {
            $_SESSION['old'] = $filterAll;
            header('Location: ?page=QLND&action=add_user');
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
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký - Đặt Tour Du Lịch</title>
    <link rel="stylesheet" href="../../templates/css/styleAdd.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="register-container">
    <form action="" method="post">
        <h2>Thêm Người Dùng</h2>
        
        <div class="form-group">
            <div class="form-item">
                <label for="username">Họ tên</label>
                <input type="text" name="username" id="username" placeholder="Họ tên" required
                       value="<?php echo old('username', $old); ?>">
                <?php echo form_error('username', '<span class="error">', '</span>', $messenger); ?>
            </div>
            
            <div class="form-item">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Mật khẩu" required>
                <?php echo form_error('password', '<span class="error">', '</span>', $messenger); ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="form-item">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Địa chỉ email" required
                       value="<?php echo old('email', $old); ?>">
                <?php echo form_error('email', '<span class="error">', '</span>', $messenger); ?>
            </div>
            
            <div class="form-item">
                <label for="confirm-password">Nhập lại Password</label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Nhập lại mật khẩu" required>
                <?php echo form_error('confirm-password', '<span class="error">', '</span>', $messenger); ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="form-item">
                <label for="phone">Số điện thoại</label>
                <input type="number" name="phone" id="phone" placeholder="Số điện thoại" required 
                       value="<?php echo old('phone', $old); ?>">
                <?php echo form_error('phone', '<span class="error">', '</span>', $messenger); ?>
            </div>
            
            <div class="form-item">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" >
                    <option value="0" <?php echo (old('status', $old) == '0') ? 'selected' : ''; ?>>Đã kích hoạt</option>
                    <option value="1" <?php echo (old('status', $old) == '1') ? 'selected' : ''; ?>>Chưa kích hoạt</option>
                </select>
                <?php echo form_error('status', '<span class="error">', '</span>', $messenger); ?>
            </div>
        </div>
        
        <div class="form-buttons">
            <button type="submit" class="btn-primary">Thêm người dùng</button>
            <button type="button" class="btn-secondary" onclick="window.location.href='?page=QLND'">Quay lại</button>
        </div>
    </form>
</div>

</body>
</html>
