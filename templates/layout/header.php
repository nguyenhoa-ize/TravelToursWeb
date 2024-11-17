<?php
session_start();

// Lấy thông tin người dùng từ session (nếu đã đăng nhập)
$fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : null;

$servername = "localhost:3307";
$username = "root";
$password = "";
$dbname = "traveltoursweb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$departureQuery = "SELECT name FROM destinations WHERE type = 'departure'";
$departureResult = $conn->query($departureQuery);
$destinationQuery = "SELECT name FROM destinations WHERE type = 'destination'";
$destinationResult = $conn->query($destinationQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelTour Homepage</title>
    <link rel="stylesheet" href="templates/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="#" id="logo-link">
                    <img src="http://localhost/TravelToursWeb/templates/image/Logo.jpeg" alt="Travel Tours">
                </a>
                <span>Travel Tours</span>
            </div>
            <nav class="navbar">
                <ul>
                    <li><a href="" id="home-link">Trang chủ</a></li>
                    <li class="dropdown">
                        <a href="#" id="about-link">Giới thiệu <span class="arrow-down">&#9660;</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="company-info-link">Thông tin công ty</a></li>
                            <li><a href="#" id="team-link">Đội ngũ</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" id="tours-link">Tour du lịch <span class="arrow-down">&#9660;</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#" id="domestic-tours-link">Tour trong nước</a></li>
                            <li><a href="#" id="international-tours-link">Tour quốc tế</a></li>
                        </ul>
                    </li>
                    <li><a href="#" id="news-link">Tin tức</a></li>
                    <li><a href="#" id="faq-link">FAQs</a></li>
                    <li><a href="#" id="contact-link">Liên hệ</a></li>
                </ul>
            </nav>

            <div class="header-right">
                <?php if ($fullname): ?>
                    <!-- Đã đăng nhập -->
                    <span>Xin Chào, <strong><?php echo htmlspecialchars($fullname); ?></strong></span>
                    <a href="models/auth/logout.php" class="btn-logout">Đăng Xuất</a>
                <?php else: ?>
                    <!-- Chưa đăng nhập -->
                    <a href="models/auth/login.php" id="login-link" class="btn-login">
                        <i class="fas fa-user"></i> Đăng Nhập
                    </a>
                    <a href="models/auth/register.php" id="register-link" class="btn-register">
                        Đăng ký
                    </a>
                <?php endif; ?>
                <span class="hotline">Hotline: 1900 0000</span>
            </div>
        </div>
    </header>


  <script>
    $(document).ready(function() {
      $('#logo-link').click(function(e) {
        e.preventDefault();
        window.location.href = 'index.php';
      });
      $('#home-link').click(function(e) {
        e.preventDefault();
        window.location.href = 'index.php';
      });
      $('#login-link').click(function(e) {
        e.preventDefault();
        window.location.href = 'models/auth/login.php'; 
        });
    $('#register-link').click(function(e) {
        e.preventDefault();
        window.location.href = 'models/auth/register.php';
        });
    });
  </script>
</body>
</html>
