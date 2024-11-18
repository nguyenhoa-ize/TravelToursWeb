<?php
    include '../../config.php';
    include '../../templates/layout/header.php';
    include '../../includes/connect.php';
    include '../../includes/database.php';
    include '../../includes/functions.php';
    include '../../includes/session.php';
?>
<?php
    
    if (isPost()) {
        $filterAll = filter();
    
        if (!empty(trim($filterAll['email'])) && !empty(trim($filterAll['password']))) {
            // kiểm tra đăng nhập
            $email = $filterAll['email'];
            $password = $filterAll['password'];
    
            // Truy vấn lấy thông tin users theo email
            $userQuery = oneRaw("SELECT password FROM user WHERE email = '$email'");
    
            if (!empty($userQuery)) {
                $passwordHash = $userQuery['password'];
                if (password_verify($password, $passwordHash)) {
                    $roleQuery = oneRaw("SELECT role FROM user WHERE email = '$email'");
                    if ($roleQuery['role'] == 'admin') {
                        // Chuyển hướng người dùng đến trang quản lý
                        redirect('../../views/admin/admin.php');
                        exit();
                    } else {
                        // Chuyển hướng người dùng đến trang chủ
                        redirect('../../index.php');
                        exit();
                    }

                } else {
                    setFlashData('msg', 'Mật khẩu không chính xác.');
                    setFlashData('msg_type', 'danger');
                    redirect('login.php');
                }
            } else {
                setFlashData('msg', 'Email không tồn tại.');
                setFlashData('msg_type', 'danger');
                redirect('login.php');
            }
        exit();
        } else {
            setFlashData('msg', 'Vui lòng nhập email và mật khẩu.');
            setFlashData('msg_type', 'danger');
            redirect('login.php');
        }
        
        
    }
    
    $msg = getFlashData('msg');
    $msg_type = getFlashData('msg_type');
    
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập - Đặt Tour Du Lịch</title>
    <link rel= "stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../templates/css/style_login.css">
</head>
<body>
<div class="login-container">
    <form action="" method="post">
    <h2>Đăng Nhập</h2>
    <?php
        if (!empty($msg)) {
            getSmg($msg, $msg_type);
        }

        ?>
    <input type="text" name="email" id="email" placeholder="Địa chỉ email">
    <input type="password" name="password" id="password" placeholder="Mật khẩu">
    <button type="submit">Đăng nhập</button>
    <a href="forgot.php">Quên mật khẩu?</a>
    <a href="register.php">Chưa có tài khoản?</a>
    </form>
</div>
</body>
</html>
<?php
    include '../../templates/layout/footer.php';
?>


