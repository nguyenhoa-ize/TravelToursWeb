<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ND Travel</title>
    <link rel="stylesheet" href="styles.css">
    <script src="js/jquery-3.7.1.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="header-container">
            <div class="logo">
                <a href="#">
                    <img src="templates/image/Logo.jpeg" alt="Travel Tours">
                    <span>Travel Tours</span>
                </a>
            </div>
            <nav class="navbar">
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li class="dropdown">
                        <a href="#">Giới thiệu <span class="arrow-down">&#9660;</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Thông tin công ty</a></li>
                            <li><a href="#">Đội ngũ</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#">Tour du lịch <span class="arrow-down">&#9660;</span></a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Tour trong nước</a></li>
                            <li><a href="#">Tour quốc tế</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Tin tức</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Liên hệ</a></li>
                </ul>
            </nav>

            <div class="header-right">
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" placeholder="Tìm kiếm..." class="search-input">
                    <button type="submit" class="search-button">Tìm kiếm</button>
                </div>

                <div class="dropdown">
                    <a href="#" class="dropdown-btn">
                        <i class="fas fa-user"></i> <span class="arrow-down">&#9660;</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Đăng nhập</a></li>
                        <li><a href="#">Đăng ký</a></li>
                    </ul>
                </div>
                <span class="hotline">Hotline: 1900 0000</span>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.search-icon').click(function() {
                    $('.search-input').toggle();
                    $('.search-button').toggle();
                });

                $('.dropdown > a').click(function(e) {
                    e.preventDefault();
                    $('.dropdown-menu').not($(this).siblings('.dropdown-menu')).slideUp();
                    $(this).siblings('.dropdown-menu').stop(true, true).slideToggle(200);
                });

                $(document).click(function(e) {
                    if (!$(e.target).closest('.dropdown').length) {
                        $('.dropdown-menu').slideUp();
                    }
                });
            });
        </script>
    </header>

</body>
</html>
