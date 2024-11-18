
<?php
session_start();
$servername = "localhost:3307";
$username = "root";
$password = ""; 
$dbname = "traveltoursweb";

// Tạo kết nối cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$page = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : null;
$action = isset($_GET['action']) ? htmlspecialchars($_GET['action']) : null;
$id_user = isset($_GET['id_user']) ? (int)$_GET['id_user'] : null; // Ép kiểu số nếu ID là số
$id_tours = isset($_GET['id_tours']) ? (int)$_GET['id_tours'] : null; // Ép kiểu số nếu ID là số



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/TravelToursWeb/templates/css/stylesAdmin.css">
    <link rel="stylesheet" href="http://localhost/TravelToursWeb/templates/css/style.css">
    <title>Dashboard</title>
    <style>
        .header{
            background-color: cadetblue;
            height: 70px;
            width: 100%;
            position: fixed;
            left: 0;
            top: 0;
        }
    </style>
</head>

<body>
        <div class="header" ></div>
        <div class="sidebar">
            <a href="?page=QLND">User</a>
            <a href="?page=category">Tour du lịch</a>
            <a href="?page=orders">Đơn hàng</a>
        </div>
        <div class="content">
            <?php
            // Kiểm tra và xử lý các trang trong sidebar
            if (isset($page)) {
                switch ($page) {
                    case 'QLND':
                        if ($action === 'add_user' && file_exists("add.php")) {
                            include("add.php");
                        } elseif ($action === 'edit_user' && $id_user && file_exists("edit.php")) {
                            include("edit.php");
                        } else {
                            include("QLND.php");
                        }
                        break;
            
                    case 'category':
                        if ($action === 'add_category' && file_exists("addCategory.php")) {
                            include("addCategory.php");
                        } elseif ($action === 'edit_category' && $id_tours && file_exists("editCategory.php")) {
                            include("editCategory.php");
                        } else {
                            include("category.php");
                        }
                        break;
            
                    case 'orders':
                        include("orders.php");
                        break;
            
                    default:
                        echo "<h2>Trang không tồn tại!</h2>";
                        break;
                }
            } else {
                echo '<h2 style="margin-top: 36px;">Chào mừng đến với Trang quản lý!</h2>';

            }        
            ?>
        </div>
    
</body>
</html>
