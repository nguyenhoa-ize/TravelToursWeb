<?php include '../../templates/layout/header.php';?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký - Đặt Tour Du Lịch</title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f2f6fc;
        }
        .register-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .register-container h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }
        .register-container input {
            display: block;
            width: 100%;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .register-container button {
            display: block;
            width: 100%;
            padding: 12px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-container a {
            display: block;
            text-align: right;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h2>Đăng Ký Tài Khoản</h2>
    <input type="text" id="fullname" placeholder="Họ và tên" required>
    <input type="email" id="email" placeholder="Email" required>
    <input type="text" id="username" placeholder="Tên đăng nhập" required>
    <input type="password" id="password" placeholder="Mật khẩu" required>
    <input type="password" id="confirm-password" placeholder="Xác nhận mật khẩu" required>
    <button onclick="register()">Đăng Ký</button>
    <a href="login.php">Đã có tài khoản?</a>
</div>

<script>
    function register() {
        const fullname = document.getElementById('fullname').value;
        const email = document.getElementById('email').value;
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm-password').value;

        // Kiểm tra thông tin đăng ký
        if (password === confirmPassword) {
            alert("Đăng ký tài khoản thành công!");
            // Chuyển hướng đến trang đăng nhập
            window.location.href = "login.php"; 
        } else {
            alert("Mật khẩu không khớp. Vui lòng kiểm tra lại.");
        }
    }
</script>
</body>
</html>
<?php include '../../templates/layout/footer.php';?>