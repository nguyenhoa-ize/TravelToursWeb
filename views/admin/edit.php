<?php
    include '../../includes/connect.php';
    include '../../includes/functions.php';
    include '../../includes/database.php';

    $messenger = [];  // Mảng chứa thông báo lỗi hoặc thành công

    // Kiểm tra nếu có ID người dùng
    $filterAll = filter();
    if (!empty($filterAll['id_user'])) {
        $userID = $filterAll['id_user'];
        $userDetail = oneRaw("SELECT * FROM user WHERE id_user='$userID'");
        if (!empty($userDetail)) {
            $old = $userDetail;
        } else {
            redirect('?page=edit_user');
        }
    }

    if (isPost()) {
        $password = $filterAll['password']; 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $filterAll = filter();
        $errors = [];  // Reset lỗi
        // Validate số điện thoại: bắt buộc phải nhập, số có đúng định dạng không
        if (!isPhone($filterAll['phone'])) {
            $messenger['phone']['isPhone'] = 'Số điện thoại không hợp lệ.';
        }
        

        // Validate password nếu có thay đổi
        if (!empty($filterAll['password'])) {
            if (empty($filterAll['confirm-password'])) {
                $messenger['confirm-password']['required'] = 'Bạn phải nhập lại mật khẩu.';
            } else {
                if ($filterAll['password'] != $filterAll['confirm-password']) {
                    $messenger['confirm-password']['match'] = 'Mật khẩu bạn nhập lại không đúng.';
                }
            }
        }

        // Nếu không có lỗi
        if (empty($messenger)) {
            $dataUpdate = [
                'username' => $filterAll['username'],
                'email' => $filterAll['email'],
                'phone' => $filterAll['phone'],
                'status' => $filterAll['status'],
                'created_at' => date('Y-m-d H:i:s'),
            ];

            // Cập nhật mật khẩu nếu có
            if (!empty($filterAll['password'])) {
                $dataUpdate['password'] = password_hash($filterAll['password'], PASSWORD_DEFAULT);
            }

            // Cập nhật dữ liệu
            if (isset($userID) && !empty($userID)) {
                $updateStatus = update('user', $dataUpdate, "id_user = '$userID'");
                if ($updateStatus) {
                    $_SESSION['messenger'] = ['success' => 'Cập nhật người dùng thành công!'];
                } else {
                    $_SESSION['messenger'] = ['danger' => 'Không thể cập nhật người dùng.'];
                }
            } else {
                $_SESSION['messenger'] = ['danger' => 'Không có dữ liệu để cập nhật.'];
            }
        } else {
            $_SESSION['messenger'] = $messenger;
            $_SESSION['general_error'] = 'Vui lòng kiểm tra lại dữ liệu.';
        }
    
        redirect('?page=QLND&action=edit_user&id_user='.$userID);
    }
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
    <form action="" method="post">
        <h2>Sửa người dùng</h2>
        
        <div class="form-group">
            <div class="form-item">
                <label for="username">Họ tên</label>
                <input type="text" name="username" id="username" placeholder="Họ tên" required
                       value="<?php echo old('username', $old); ?>">
            </div>
            
            <div class="form-item">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Mật khẩu ( Không nhập nếu không thay đổi) ">
            </div>
        </div>
        
        <div class="form-group">
            <div class="form-item">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Địa chỉ email" required
                       value="<?php echo old('email', $old); ?>">
            </div>
            
            <div class="form-item">
                <label for="confirm-password">Nhập lại Password</label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Nhập lại mật khẩu ( Không nhập nếu không thay đổi)" >
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
            </div>
        </div>

        <input  type="hidden" name="id_user" value="<?php echo $userID ?>">

        <div class="form-buttons">
            <button type="submit" class="btn-1">Sửa người dùng</button>
            <button type="button" class="btn-2" onclick="window.location.href='?page=QLND'">Quay lại</button>
        </div>
    </form>
</div>

</body>
</html>
