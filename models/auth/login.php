

<?php include '../../templates/layout/header.php';?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Nhập - Đặt Tour Du Lịch</title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-container input {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }
        .login-container button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        .login-container a {
            display: block;
            text-align: right;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h2>Đăng Nhập</h2>
    <input type="text" id="username" placeholder="Tên đăng nhập" required>
    <input type="password" id="password" placeholder="Mật khẩu" required>
    <button onclick="login()">Đăng Nhập</button>
    <a href="forgot.php">Quên mật khẩu?</a>
    <a href="register.php">Chưa có tài khoản?</a>
</div>

<script>
    function login() {
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;

        // Kiểm tra thông tin đăng nhập 
        if (username === "user" && password === "pass") {
            alert("Đăng nhập thành công!");
            // Chuyển hướng đến trang khác
            window.location.href = "homepage.html"; 
        } else {
            alert("Tên đăng nhập hoặc mật khẩu không đúng.");
        }
    }
</script>
</body>
</html>
<?php
    include '../../templates/layout/footer.php';
?>



