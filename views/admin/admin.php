<?php
session_start();
    include '../../config.php';
    include '../../includes/connect.php';
    include '../../includes/session.php';

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
        .header {
            background-color: white; 
            height: 80px;
            width: 100%;
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            box-sizing: border-box;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
            border-bottom: 2px solid #ddd; 
        }

        .header .logo {
            font-size: 24px;
            color: blue;
            font-weight: bold;
        }

        .header .logout-btn {
            background-color:blueviolet;
            color: white;
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 10px;
            text-decoration: none;
        }

        .header .logout-btn:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo">Travel Tours Admin</div>
        <a href="http://localhost/TravelToursWeb/models/auth/login.php" class="logout-btn">Đăng xuất</a>
    </div>

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
