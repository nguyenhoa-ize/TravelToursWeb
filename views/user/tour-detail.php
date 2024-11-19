<?php
    include ("../../config.php");
    include("../../includes/connect.php");

    // Kiểm tra và lấy giá trị 'id' từ URL nếu có
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = 0;  // Giá trị mặc định nếu không có 'id' hoặc 'id' không hợp lệ
    }

    // Truy vấn lấy thông tin của tour dựa trên id
    $sl = "SELECT id_tours, is_domestic, name, description, departure_point, destination_point, price, image, discount_price FROM tours WHERE id_tours = $id";
    $kq = mysqli_query($conn1, $sl);

    // Kiểm tra xem truy vấn có thành công không
    if ($kq) {
        // Kiểm tra nếu có kết quả
        if (mysqli_num_rows($kq) > 0) {
            // Lấy kết quả của tour
            $row = mysqli_fetch_assoc($kq);
        } else {
            echo "Không tìm thấy tour với ID: $id";
        }
    } else {
        echo "Lỗi truy vấn cơ sở dữ liệu: " . mysqli_error($conn1);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row['name'];?></title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="../../templates/css/style_tour.css">
    <script src="../../templates/js/tour_detail.js"></script>
</head>
<body>
    <?php include ('../../templates/layout/header.php');?>
    <div class="duong-dan">
        <div class="container">
            <ul class="duongdan">					
                <li class="home">
                    <a href="../../index.php" title="Trang chủ"><span>Trang chủ</span></a>						
                    <span class="icon">&nbsp;<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-right fa-w-10"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" class=""></path></svg>&nbsp;</span>
                </li>
                <li>
                    <a class="changeurl" href="#">
                        <span>
                            <?php 
                            if ($row['is_domestic'] == 1) {
                                echo 'Tour trong nước';
                            } else {
                                echo 'Tour nước ngoài';
                            }
                            ?>
                        </span>
                    </a>
                    <span class="icon">&nbsp;<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-right fa-w-10"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" class=""></path></svg>&nbsp;</span>
                </li>
                <li><strong><span><?php echo $row['name'];?></span></strong></li>
            </ul>
        </div>
    </div>
    <div class="detail-tour">
        <h1 class="title-tour"><?php echo $row['name'];?></h1>
        <div class="info-tour">
            <div class="khoi-hanh item">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                        <path d="M9.01107 1.625C13.103 1.625 16.9043 4.90179 16.9043 9.03571C16.9043 11.7682 15.9811 13.7001 14.434 15.9524C12.707 18.4667 10.5018 20.8338 9.51601 21.8515C9.23162 22.1451 8.76735 22.1451 8.48296 21.8515C7.4972 20.8338 5.29202 18.4667 3.56496 15.9524C2.01787 13.7001 1.09473 11.7682 1.09473 9.03571C1.09473 4.90179 4.89588 1.625 8.98782 1.625" stroke="#0396ff" stroke-width="2" stroke-linecap="round"></path>
                        <path d="M11.9637 9.47235C11.9637 11.1256 10.6409 12.4928 9.00411 12.4928C7.36733 12.4928 6.03516 11.1256 6.03516 9.47235C6.03516 7.81912 7.36733 6.56542 9.00411 6.56542C10.6409 6.56542 11.9637 7.81912 11.9637 9.47235Z" stroke="#0396ff" stroke-width="2"></path>
                    </svg>
                </div>
                <div class="info">
                    <div class="title">
                        Khởi hành từ 
                    </div>
                    <div class="content">
                        <?php echo $row['departure_point'];?>
                    </div>
                </div>
            </div>
            <div class="diem-den item">
                <div class="icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                        <path d="M9.01107 1.625C13.103 1.625 16.9043 4.90179 16.9043 9.03571C16.9043 11.7682 15.9811 13.7001 14.434 15.9524C12.707 18.4667 10.5018 20.8338 9.51601 21.8515C9.23162 22.1451 8.76735 22.1451 8.48296 21.8515C7.4972 20.8338 5.29202 18.4667 3.56496 15.9524C2.01787 13.7001 1.09473 11.7682 1.09473 9.03571C1.09473 4.90179 4.89588 1.625 8.98782 1.625" stroke="#0396ff" stroke-width="2" stroke-linecap="round"></path>
                        <path d="M11.9637 9.47235C11.9637 11.1256 10.6409 12.4928 9.00411 12.4928C7.36733 12.4928 6.03516 11.1256 6.03516 9.47235C6.03516 7.81912 7.36733 6.56542 9.00411 6.56542C10.6409 6.56542 11.9637 7.81912 11.9637 9.47235Z" stroke="#0396ff" stroke-width="2"></path>
                    </svg>
                </div>
                <div class="info">
                    <div class="title">
                        Điểm đến
                    </div>
                    <div class="content">
                        <?php echo $row['destination_point'];?>
                    </div>
                </div>
            </div>
            <div class="thoi-gian item">
                <div class="icon">
                    <svg fill="#0396ff" width="24" height="24" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg"><path d="M790 166h-41V83h-84v83H333V83h-83v83h-42q-34 0-58.5 24.5T125 250v582q0 34 24 58.5t59 24.5h582q35 0 59-24.5t24-58.5V250q0-35-24.5-59.5T790 166zm0 666H208V374h582v458zM291 457h208v208H291V457z"/>
                    </svg>
                </div>
                <div class="info">
                    <div class="title">
                        Thời gian
                    </div>
                    <div class="content">
                        2 ngày 1 đêm
                    </div>
                </div>
            </div>
            <div class="so-luong item">
                <div class="icon">
                    <svg width="30" height="30" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 8.5C8.5 6.56625 10.0663 5 12 5C13.9338 5 15.5 6.56625 15.5 8.5C15.5 10.4338 13.9338 12 12 12C10.0663 12 8.5 10.4338 8.5 8.5ZM12 6.75C12.9625 6.75 13.75 7.5375 13.75 8.5C13.75 9.4625 12.9625 10.25 12 10.25C11.0375 10.25 10.25 9.4625 10.25 8.5C10.25 7.5375 11.0375 6.75 12 6.75Z" fill="#0396ff"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 13.75C9.66375 13.75 5 14.9225 5 17.25V19H19V17.25C19 14.9225 14.3363 13.75 12 13.75ZM12 15.5C14.3625 15.5 17.075 16.6287 17.25 17.25H6.75C6.95125 16.62 9.64625 15.5 12 15.5Z" fill="#0396ff"/>
                        <path d="M21.4025 8.58002L21.99 9.17168L18.6567 12.505L16.99 10.8425L17.5817 10.255L18.6567 11.3259L21.4025 8.58002Z" fill="#0396ff"/>
                    </svg>
                </div>
                <div class="info">
                    <div class="title">
                        Số chỗ còn nhận
                    </div>
                    <div class="content">
                        20 người
                    </div>
                </div>
            </div>
        </div>
        <div class="main-info">
            <div class="content-tour">
                <div class="image-tour">
                    <div class="khung-anh">
                        <img class="hinh-anh" src="<?php echo SITE_URL. 'templates/image/tours/' . $row['image']; ?>" alt="<?php echo $row['name'];?>" style="width: 100%; height: 56.25%">
                    
                        <img class="hinh-anh" src="https://bizweb.dktcdn.net/thumb/1024x1024/100/505/645/products/sp5-5.jpg?v=1703064848660" style="width: 100%; height: 56.25%">
                        
                        <img class="hinh-anh" src="https://bizweb.dktcdn.net/thumb/1024x1024/100/505/645/products/sp5-5.jpg?v=1703064848660" style="width: 100%; height: 56.25%">
                        
                        <a class="prev" onclick="chuyen_hinh(-1)">❮</a>
                        <a class="next" onclick="chuyen_hinh(1)">❯</a>
                    </div>
                    <br/>
                        
                    <div style="text-align:center">
                        <span class="dot" onclick="hien_tai(1)"></span> 
                        <span class="dot" onclick="hien_tai(2)"></span> 
                        <span class="dot" onclick="hien_tai(3)"></span> 
                    </div> 
                </div>
                <ul class="tab-tour">
                    <li class="tab-link" onclick="moTabThongtin(0)">
                        <h3><span>Mô tả</span></h3>
                    </li>
                    <li class="tab-link" onclick="moTabThongtin(1)">
                        <h3><span>Lịch trình</span></h3>
                    </li>
                </ul>
                <div id="tab-0" class="tab-content active">
                    <p><?php echo $row['description'] ?></p>
                </div>
                <div id="tab-1" class="tab-content active">
                        <p>Ngày 1</p>
                </div>    
            </div>
            <div class="form-tour">
                <form id="dat-tour" name="dat-tour" method="post">
                    <p><b>Giá: </b>
                        <?php 
                        if (!empty($row['discount_price'])) { 
                            // Giá gốc (gạch ngang)
                            echo '<span style="text-decoration: line-through; color: #333; font-size: 16px">' 
                                . number_format($row['price'], 0, ',', '.') . ' VND</span>';
                            // Giá khuyến mãi
                            echo '<span style="margin-left: 10px;" id="gia-tour">' . number_format($row['discount_price'], 0, ',', '.') . ' VND</span>';
                        } else {
                            echo '<span id="gia-tour">' . number_format($row['price'], 0, ',', '.') . ' VND</span>';
                        }
                        ?>
                    </p>
                    <div id="ma-tour">
                        <p><b>Mã tour: </b><span><?php echo $row['id_tours']; ?></span> </p>
                    </div>
                    <div class="ngay-di">
                        <label for="date"><b>Chọn ngày đi:</b></label>
                        <div class="time-block">
                            <div class="icon">
                                <svg fill="#fff" width="30" height="30" viewBox="0 0 1000 1000" xmlns="http://www.w3.org/2000/svg"><path d="M790 166h-41V83h-84v83H333V83h-83v83h-42q-34 0-58.5 24.5T125 250v582q0 34 24 58.5t59 24.5h582q35 0 59-24.5t24-58.5V250q0-35-24.5-59.5T790 166zm0 666H208V374h582v458zM291 457h208v208H291V457z"/>
                                </svg>
                            </div>
                            <div class="chon-ngay">
                                <input type="date" id="date" name="date" placeholder="Chọn ngày đi">
                            </div>                     
                        </div>
                    </div>
                    <div class="soluong">
                        <span style="font-weight: bold;">Số lượng: </span>
                        <input type="number" min="0" name="so-luong" value="0" title="Số lượng" id="so-luong" onchange="tinhTongTien()">
                    </div>
                    <div class="tongtien">
                        <p id="tong"><b>Tổng tiền: </b><span id="tong-tien">0₫</span></p>
                    </div>
                    <input type="submit" value="Đặt ngay">
                    <input type="reset" value="Xóa">                    
                </form>
            </div>
        </div>
    </div>
    <?php include "../../templates/layout/footer.php"; ?>      
</body>
</html>