<?php
$servername = "localhost";
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
    <?php   include 'templates/layout/header.php';?>
    <div>
        <img id="banner" src="templates/image/banner.png" alt="Banner">
    </div>
    <div class="form-search">
        <form action="search.php" method="GET" style="display: flex; align-items: center; gap: 10px;">
            <input type="text" name="query" placeholder="Bạn muốn đi đâu?" autocomplete="off">
            <div class="icon-background">
                <i class="fa fa-map-marker"></i>
            </div>
            <select name="departure">
                <option value="">Chọn điểm đi</option>
                <?php while($row = $departureResult->fetch_assoc()): ?>
                    <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
            <div class="icon-background">
                <i class="fa fa-map-marker"></i>
            </div>
            <select name="destination">
                <option value="">Chọn điểm đến</option>
                <?php while($row = $destinationResult->fetch_assoc()): ?>
                    <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                <?php endwhile; ?>
            </select>
            <div class="icon-background">
                <i class="fa fa-calendar"></i>
            </div>
            <input type="date" name="date">
            <button type="submit" class="btn-search">Tìm kiếm</button>
        </form>
    </div>
    <div class="container-fluid about py-5">
    <div class="container-fluid about py-5">
    <div class="container py-5">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <div class="h-100" style="border: 30px solid; border-color: transparent #13357B transparent #13357B;">
                    <img src="templates/image/Aboutus.jpeg" class="img-fluid w-100 h-100" alt="About Us Image">
                </div>
            </div>
            
            <div class="col-lg-7" >
                <h5 class="section-about-title pe-3">Giới thiệu</h5>
                <h1 class="mb-4">Chào mừng bạn đến với <span class="text-primary">Travel Tours!</span></h1>
                <p class="mb-4">Chúng tôi tự hào mang đến cho bạn những trải nghiệm du lịch đẳng cấp và đáng nhớ. Với đội ngũ chuyên nghiệp, dịch vụ tận tâm, Travel Tours luôn nỗ lực để biến những chuyến đi của bạn trở nên hoàn hảo nhất.</p>
                <p class="mb-4">Tại Travel Tours, chúng tôi cung cấp các chuyến bay hạng nhất, những khách sạn được chọn lọc kỹ càng và dịch vụ lưu trú 5 sao. Ngoài ra, bạn sẽ được trải nghiệm những phương tiện di chuyển hiện đại nhất và có cơ hội khám phá hơn 150 tour du lịch thành phố cao cấp. Đặc biệt, chúng tôi luôn sẵn sàng phục vụ bạn 24/7, đảm bảo mọi nhu cầu của bạn được đáp ứng nhanh chóng và hiệu quả.</p>
                <div class="row gy-2 gx-4 mb-4">
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>First Class Flights</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Handpicked Hotels</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>5 Star Accommodations</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>Latest Model Vehicles</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>150 Premium City Tours</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="mb-0"><i class="fa fa-arrow-right text-primary me-2"></i>24/7 Service</p>
                    </div>
                </div>
                <a class="btn btn-primary rounded-pill py-3 px-5 mt-2" href="#">Read More</a>
            </div>
        </div>
    </div>
</div>

    </div>

    <?php   include 'templates/layout/footer.php';?>
</body>
</html>
