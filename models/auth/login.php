<?php
include '../../templates/layout/header.php';
?>

<div class="login-container">
    <h2>Đăng nhập</h2>
    <form action="" method="post">
    <label for="email">Email:</label>
        <input type="email" id="email" name="email" required placeholder="Nhập địa chỉ email của bạn">

        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password"  required placeholder="Nhập mật khẩu"> 
        <button type="submit">Đăng nhập</button>
        <a href="?models=auth&action=forgot" class="forgot-password">Quên mật khẩu?</a>
    </form>
    <p>Bạn chưa có tài khoản? <a href="?models=auth&action=register">Đăng ký</a></p>
</div>



<?php
include '../../templates/layout/footer.php';
?>

