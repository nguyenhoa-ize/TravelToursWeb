<<<<<<< HEAD
<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "traveltoursweb";

// Tạo kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Thực hiện truy vấn lấy danh sách người dùng
$kq = $conn->query("SELECT * FROM user");
$stt = 1;
?>
=======
<!-- index.php -->
>>>>>>> 6368f10ff27c5eb8d7f3d9e38cd392040352a872
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .sidebar {
            width: 250px;
            background-color: #f1f1f1;
            padding: 15px;
            height: 100vh;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        .sidebar a {
            display: block;
            padding: 10px;
            margin-bottom: 5px;
            color: black;
            text-decoration: none;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #ddd;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['action']) && $_GET['action'] === 'QLND') {
        include("QLND.php");
    } 
    ?>
    <div class="sidebar">
    <a href="?page=QLND">User</a>
    <a href="?page=add_category">Sản phẩm</a>
    <a href="?page=orders">Đơn hàng</a>
</div>
<div class="content">
    <?php
    if (isset($_GET['page']) && $_GET['page'] === 'QLND') {
        if (isset($_GET['action'])) {
            if ($_GET['action'] === 'add_user') {
                include("add.php"); // Hiển thị form thêm người dùng
            } elseif ($_GET['action'] === 'edit_user' && isset($_GET['id'])) {
                include("edit.php"); // Hiển thị form sửa người dùng
            } 
        } else {
            include("QLND.php"); // Hiển thị danh sách người dùng
        }
    } else {
        echo "<h2>Chào mừng đến với bảng điều khiển!</h2>";
    }
    ?>
</div>
</body>
</html>
