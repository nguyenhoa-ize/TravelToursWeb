<?php
    include '../../config.php';
    include '../../templates/layout/header.php';
    include '../../includes/connect.php';
    include '../../includes/database.php';
    include '../../includes/functions.php';
    include '../../includes/session.php';
?>
<?php
    session_start();
    
    if (isPost()) {
        $filterAll = filter();
    
        if (!empty(trim($filterAll['username'])) && !empty(trim($filterAll['password']))) {
            // kiểm tra đăng nhập
            $username = $filterAll['username'];
            $password = $filterAll['password'];
    
            // Truy vấn lấy thông tin users theo username
            $userQuery = oneRaw("SELECT password FROM user WHERE username = '$username'");
    
            if (!empty($userQuery)) {
                $passwordHash = $userQuery['password'];
                if (password_verify($password, $passwordHash)) {
                    // Truy vấn lấy thông tin fullname và role
                    $userDetails = oneRaw("SELECT fullname, role, id_user FROM user WHERE username = '$username'");
                
                    if (!empty($userDetails)) {
                        // Lưu thông tin vào session
                        $_SESSION['loggedin'] = true;
                        $_SESSION['id_user'] = $userDetails['id_user'];
                        $_SESSION['fullname'] = $userDetails['fullname'];
                        $_SESSION['role'] = $userDetails['role'];
                
                        // Chuyển hướng tùy thuộc vào vai trò của người dùng
                        if ($userDetails['role'] == 'admin') {
                            redirect('../../views/admin/admin.php'); // Trang quản lý
                        } else {
                            redirect('../../index.php'); // Trang chủ
                        }
                        exit();
                    }
                } else {
                    setFlashData('msg', 'Mật khẩu không chính xác.');
                    setFlashData('msg_type', 'danger');
                    redirect('login.php');
                }                
            } else {
                setFlashData('msg', 'Username không tồn tại.');
                setFlashData('msg_type', 'danger');
                redirect('login.php');
            }
        exit();
        } else {
            setFlashData('msg', 'Vui lòng nhập username và mật khẩu.');
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
    <input type="text" name="username" id="username" placeholder="Nhập username">
    <input type="password" name="password" id="password" placeholder="Mật khẩu">
    <button type="submit">Đăng nhập</button>
    <a href="forgot.php">Quên mật khẩu?</a>
    <a href="register.php">Chưa có tài khoản?</a>
    </form>
</div>


</body>
</html>



