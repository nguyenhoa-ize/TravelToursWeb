<?php
include "config.php";
include "includes/connect.php";
include "includes/database.php";
include "includes/functions.php";
include "includes/session.php";
$departureQuery = "SELECT DISTINCT departure_point AS name FROM tours WHERE departure_point IS NOT NULL";
$departureResult = $conn1->query($departureQuery);
$destinationQuery = "SELECT DISTINCT destination_point AS name FROM tours WHERE destination_point IS NOT NULL";
$destinationResult = $conn1->query($destinationQuery);
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
    <div id="main">
        <div>
            <img id="banner" src="templates/image/banner.png" alt="Banner">
        </div>
        <div class="form-search">
            <form action="search.php" method="GET" style="display: flex; align-items: center; gap: 10px;">
                <input type="text" name="query" placeholder="Bạn muốn đi đâu?" autocomplete="off">
                <div class="icon-background">
                    <i class="fa fa-map-marker"></i>
                </div>
                <select name="departure_point">
                    <option value="">Chọn điểm đi</option>
                    <?php while($row = $departureResult->fetch_assoc()): ?>
                        <option value="<?= $row['name'] ?>"><?= $row['name'] ?></option>
                    <?php endwhile; ?>
                </select>
                <div class="icon-background">
                    <i class="fa fa-map-marker"></i>
                </div>
                <select name="destination_point">
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
            <!-- Phần Giới thiệu -->
            <div class="container-fluid about py-5">
                <div class="container py-5">
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-5">
                            <div class="h-100" style="border: 30px solid; border-color: transparent #13357B transparent #13357B;">
                                <img src="templates/image/Aboutus.jpeg" class="img-fluid w-100 h-100" alt="About Us Image">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <h1 class="mb-4">Chào mừng bạn đến với <span class="text-primary">Travel Tours!</span></h1>
                            <p class="mb-4">Chúng tôi tự hào mang đến cho bạn những trải nghiệm du lịch đẳng cấp và đáng nhớ. Với đội ngũ chuyên nghiệp, dịch vụ tận tâm, Travel Tours luôn nỗ lực để biến những chuyến đi của bạn trở nên hoàn hảo nhất.</p>
                            <p class="mb-4">Tại Travel Tours, chúng tôi cung cấp các chuyến bay hạng nhất, những khách sạn được chọn lọc kỹ càng và dịch vụ lưu trú 5 sao. Ngoài ra, bạn sẽ được trải nghiệm những phương tiện di chuyển hiện đại nhất và có cơ hội khám phá hơn 150 tour du lịch thành phố cao cấp. Đặc biệt, chúng tôi luôn sẵn sàng phục vụ bạn 24/7, đảm bảo mọi nhu cầu của bạn được đáp ứng nhanh chóng và hiệu quả.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phần Tour Phổ Biến -->
            <div class="popular-tours container-fluid py-5">
                <h2 class="section-title text-center mb-5">Tour Phổ Biến</h2>
                <div class="container">
                    <div class="row">
                        <?php
                        $popularToursQuery = "SELECT name, description, price, image FROM tours WHERE is_popular = 1 LIMIT 4";
                        $popularToursResult = $conn1->query($popularToursQuery);

                        while ($row = $popularToursResult->fetch_assoc()):
                        ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="tour-card">
                                    <img src="templates/image/tours/<?php echo $row['image'] ?>" class="img-fluid" alt="<?= $row['name'] ?>">
                                    <div class="tour-info p-3">
                                        <h5><?= $row['name'] ?></h5>
                                        <p><?= $row['description'] ?></p>
                                        <p><strong>Giá:</strong> <?= number_format($row['price'], 0, ',', '.') ?> VND</p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>

            <!-- Phần Khuyến Mãi -->
            <div class="promotions container-fluid py-5">
                <h2 class="section-title text-center mb-5">Khuyến Mãi</h2>
                <div class="container">
                    <div class="row">
                        <?php
                        $promotionToursQuery = "SELECT name, description, price, discount_price, image FROM tours WHERE discount_price IS NOT NULL LIMIT 4";
                        $promotionToursResult = $conn1->query($promotionToursQuery);

                        while ($row = $promotionToursResult->fetch_assoc()):
                        ?>
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="tour-card">
                                    <img src="templates/image/tours/<?= $row['image'] ?>" class="img-fluid" alt="<?= $row['name'] ?>">
                                    <div class="tour-info p-3">
                                        <h5><?= $row['name'] ?></h5>
                                        <p><?= $row['description'] ?></p>
                                        <p><strong>Giá Gốc:</strong> <del><?= number_format($row['price'], 0, ',', '.') ?> VND</del></p>
                                        <p><strong>Giá Khuyến Mãi:</strong> <?= number_format($row['discount_price'], 0, ',', '.') ?> VND</p>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="container-fluid bg-light service py-5">
        <div class="container py-5">
            <div class="mx-auto text-center mb-5" style="max-width: 900px;">
                <h1 class="mb-0">Các Dịch Vụ Của Chúng Tôi</h1>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="service-content-inner text-center bg-primary text-white rounded p-4">
                        <div class="service-icon mb-3">
                            <i class="fa fa-globe fa-4x text-white"></i>
                        </div>
                        <h5 class="mb-3">Tour Quốc Tế</h5>
                        <p>Dịch vụ tổ chức các tour quốc tế chuyên nghiệp, mang đến những trải nghiệm tuyệt vời cho khách hàng với chi phí hợp lý và chất lượng dịch vụ tốt nhất.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-content-inner text-center bg-white border border-primary rounded p-4">
                        <div class="service-icon mb-3">
                            <i class="fa fa-hotel fa-4x text-primary"></i>
                        </div>
                        <h5 class="mb-3">Đặt Phòng Khách Sạn</h5>
                        <p>Chúng tôi cung cấp dịch vụ đặt phòng khách sạn với các ưu đãi hấp dẫn, đảm bảo khách hàng có được những lựa chọn tốt nhất với giá cả hợp lý.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-content-inner text-center bg-white border border-primary rounded p-4">
                        <div class="service-icon mb-3">
                            <i class="fa fa-user fa-4x text-primary"></i>
                        </div>
                        <h5 class="mb-3">Hướng Dẫn Viên Du Lịch</h5>
                        <p>Dịch vụ hướng dẫn viên chuyên nghiệp, am hiểu địa phương, nhiệt tình hỗ trợ khách hàng trong suốt chuyến đi để có trải nghiệm đáng nhớ.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-content-inner text-center bg-white border border-primary rounded p-4">
                        <div class="service-icon mb-3">
                            <i class="fa fa-cog fa-4x text-primary"></i>
                        </div>
                        <h5 class="mb-3">Quản Lý Sự Kiện</h5>
                        <p>Chúng tôi hỗ trợ tổ chức và quản lý các sự kiện quan trọng, đảm bảo mọi chi tiết đều được chuẩn bị một cách hoàn hảo và chu đáo.</p>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <button class="btn btn-primary">Xem Thêm Dịch Vụ</button>
            </div>
        </div>
    </div>
                            

    <?php   include 'templates/layout/footer.php';?>
</body>
</html>
