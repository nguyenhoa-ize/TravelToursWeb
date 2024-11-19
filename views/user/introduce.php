<?php
    include '../../config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giới thiệu</title>
    <link rel="stylesheet" href="../../templates/css/style_introduce.css">
</head>
<body>
<?php include "../../templates/layout/header.php"; ?>
    <!-- About Section -->
    <section class="about">
        <div class="about-container">
            <div class="about-image">
                <img src="<?php echo SITE_URL . 'templates/image/about.jpeg'; ?>" alt="Hình ảnh giới thiệu">
            </div>
            <div class="about-text">
                <h2>Giới thiệu về chúng tôi</h2>
                <p>Travel Tours mang đến cho bạn cơ hội khám phá những điểm đến tuyệt vời, từ những dãy núi hùng vĩ, những khu rừng nguyên sinh xanh tươi, cho đến những bãi biển tuyệt đẹp, nơi bạn có thể thư giãn và tận hưởng vẻ đẹp tự nhiên. Bất kể bạn là người yêu thích sự phiêu lưu với các hoạt động leo núi, đi bộ đường dài hay là người tìm kiếm sự yên bình với những chuyến du lịch nghỉ dưỡng, chúng tôi đều có những gói tour phù hợp để bạn khám phá thế giới một cách trọn vẹn nhất. Các điểm đến không chỉ hấp dẫn bởi cảnh đẹp mà còn bởi nền văn hóa đặc sắc và lịch sử lâu đời, chắc chắn sẽ mang đến cho bạn những trải nghiệm khó quên. Hãy cùng chúng tôi bắt đầu chuyến hành trình khám phá, tìm hiểu và tận hưởng những kỳ quan thiên nhiên và di sản văn hóa độc đáo của các vùng đất trên khắp thế giới.</p>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services">
        <h2 class="section-title">Dịch vụ của chúng tôi</h2>
        <div class="services-container">
            <div class="service-item">
                <img src="<?php echo SITE_URL . 'templates/image/plane.jpeg'; ?>" alt="Đặt vé máy bay">
                <h3>Đặt vé máy bay</h3>
                <p>Đặt vé máy bay tiện lợi và giá cả phải chăng tới những điểm đến yêu thích của bạn.</p>
            </div>
            <div class="service-item">
                <img src="<?php echo SITE_URL . 'templates/image/hotel.jpeg'; ?>" alt="Đặt phòng khách sạn">
                <h3>Đặt phòng khách sạn</h3>
                <p>Ở tại các khách sạn hàng đầu với nhiều ưu đãi và chương trình khuyến mãi.</p>
            </div>
            <div class="service-item">
                <img src="<?php echo SITE_URL . 'templates/image/tour.jpeg'; ?>" alt="Tour tùy chỉnh">
                <h3>Tour tùy chỉnh</h3>
                <p>Thiết kế các gói tour theo sở thích và nhu cầu của bạn.</p>
            </div>
        </div>
    </section>

    <!-- Tours Section -->
    <section id="tours" class="tours">
        <h2 class="section-title">Tour nổi bật</h2>
        <div class="tours-container">
            <div class="tour-item">
                <img src="<?php echo SITE_URL . 'templates/image/mountain.jpeg'; ?>" alt="Hình ảnh Tour">
                <h3>Hành trình núi</h3>
                <p>Trải nghiệm leo núi và chiêm ngưỡng cảnh quan hùng vĩ.</p>
                <a href="http://localhost/traveltoursweb/index.php" class="btn">Xem Chi Tiết</a>
            </div>
            <div class="tour-item">
                <img src="<?php echo SITE_URL . 'templates/image/beach.jpeg'; ?>" alt="Hình ảnh Tour">
                <h3>Thư giãn tại biển</h3>
                <p>Nghỉ ngơi tại những bãi biển đẹp với làn nước trong xanh.</p>
                <a href="http://localhost/traveltoursweb/index.php" class="btn">Xem Chi Tiết</a>
            </div>
            <div class="tour-item">
                <img src="<?php echo SITE_URL . 'templates/image/city.jpeg'; ?>" alt="Hình ảnh Tour">
                <h3>Khám phá thành phố</h3>
                <p>Tham quan các thành phố sôi động và nền văn hóa đa dạng.</p>
                <a href="http://localhost/traveltoursweb/index.php" class="btn">Xem Chi Tiết</a>
            </div>
        </div>
    </section>


<?php include "../../templates/layout/footer.php"; ?>
</body>
</html>
