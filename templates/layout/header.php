<?php
include '../../config.php';
session_start();
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$fullname = $isLoggedIn ? $_SESSION['fullname'] : null; // Lấy fullname nếu đã đăng nhập

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ND Travel</title>
  <link rel="stylesheet" href="<?php echo SITE_URL. 'templates/css/style.css'?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
  <header>
      <div class="header-container">
          <div class="logo">
              <a href="#" id="logo-link">
                  <img src="<?php echo SITE_URL. 'templates/image/Logo.jpeg'?>" alt="Travel Tours">
              </a>
              <span>Travel Tours</span>
          </div>
          <nav class="navbar">
              <ul>
                  <li><a href="" id="home-link">Trang chủ</a></li>
                  <li><a href="<?php echo SITE_URL. 'views/user/introduce.php'?>" id="about-link">Giới thiệu</a></li>
                  <li class="dropdown">
                      <a href="<?php echo SITE_URL. 'views/user/tours.php'?>" id="tours-link">Tour du lịch <span class="arrow-down">&#9660;</span></a>
                      <ul class="dropdown-menu">
                          <li><a href="#" id="domestic-tours-link">Tour trong nước</a></li>
                          <li><a href="#" id="international-tours-link">Tour quốc tế</a></li>
                      </ul>
                  </li>
                  <li><a href="http://localhost/traveltoursweb/views/user/FAQs.php" id="faq-link">FAQs</a></li>
              </ul>
          </nav>

          <div class="header-right">
            <?php if ($isLoggedIn): ?>
            <div class="cart-container">
                <i class="fas fa-shopping-cart cart-icon"></i>
                <span class="cart-text">Giỏ hàng</span>
                <span class="cart-count">0</span>
            </div>
                <div class="user-greeting">
                    <span>Xin Chào, <?php echo htmlspecialchars($fullname); ?>!</span>
                    <a href="<?php echo SITE_URL . 'models/auth/profile.php'; ?>" class="btn-account">Tài khoản</a> 
                    <a href="<?php echo SITE_URL . 'models/auth/logout.php'; ?>" class="btn-logout">Đăng xuất</a>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="<?php echo SITE_URL . 'models/auth/login.php'; ?>" id="login-link" class="btn-login">
                        <i class="fas fa-user"></i> Đăng Nhập
                    </a>
                    <a href="<?php echo SITE_URL . 'models/auth/register.php'; ?>" id="register-link" class="btn-register">
                        Đăng ký
                    </a>
                </div>
            <?php endif; ?>
            <span class="hotline">Hotline: 1900 0000</span>
        </div>
      </div>
  </header>

  <script>
    $(document).ready(function() {
      $('#logo-link').click(function(e) {
        e.preventDefault();
        window.location.href = '<?php echo SITE_URL. 'index.php'?>';
      });
      $('#home-link').click(function(e) {
        e.preventDefault();
        window.location.href = '<?php echo SITE_URL. 'index.php'?>';
      });
      $('#login-link').click(function(e) {
        e.preventDefault();
        window.location.href = '<?php echo SITE_URL. 'models/auth/login.php'?>'; 
        });
    $('#register-link').click(function(e) {
        e.preventDefault();
        window.location.href = '<?php echo SITE_URL. 'models/auth/register.php'?>';
        });
    });
  </script>
</body>
</html>
