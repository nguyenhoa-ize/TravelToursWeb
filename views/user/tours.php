<?php
    include '../../config.php';
    include '../../includes/connect.php';

    // Lấy các giá trị lọc từ yêu cầu (nếu có)
    $priceFilter = isset($_GET['price']) ? $_GET['price'] : '';
    $departureFilter = isset($_GET['departure']) ? $_GET['departure'] : '';
    $destinationFilter = isset($_GET['destination']) ? $_GET['destination'] : '';

    $sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'default';

    $sql = "SELECT id_tours, is_domestic, name, description, departure_point, destination_point, price, image, discount_price FROM tours WHERE 1";
     // Thêm điều kiện lọc theo mức giá (nếu có)
     if ($priceFilter) {
        $sql .= " AND price ";
        if ($priceFilter == "<3000000") {
            $sql .= "< 3000000";
        } elseif ($priceFilter == "3000000-5000000") {
            $sql .= "BETWEEN 3000000 AND 5000000";
        } elseif ($priceFilter == "5000000-7000000") {
            $sql .= "BETWEEN 5000000 AND 7000000";
        } elseif ($priceFilter == "7000000-9000000") {
            $sql .= "BETWEEN 7000000 AND 9000000";
        } elseif ($priceFilter == ">9000000") {
            $sql .= "> 9000000";
        }
    }

    // Thêm điều kiện lọc theo điểm khởi hành (nếu có)
    if ($departureFilter) {
        $sql .= " AND departure_point = '$departureFilter'";
    }

    // Thêm điều kiện lọc theo điểm đến (nếu có)
    if ($destinationFilter) {
        $sql .= " AND destination_point = '$destinationFilter'";
    }

    if ($sortOrder == 'asc') {
        $sql .= " ORDER BY price ASC";
    } elseif ($sortOrder == 'desc') {
        $sql .= " ORDER BY price DESC";
    }



    $kq = mysqli_query($conn1, $sql);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Tour Du Lịch</title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="../../templates/css/style_tour.css">
</head>
<body>
    <?php include "../../templates/layout/header.php"; ?>
    <h1 style="display: none;">Danh sách Tour Du Lịch</h1>
    <div class="duong-dan">
        <div class="container">
            <ul class="duongdan">					
                <li class="home">
                    <a href="<?php echo SITE_URL. 'index.php'?>" title="Trang chủ"><span>Trang chủ</span></a>						
                    <span class="icon">&nbsp;<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-right fa-w-10"><path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" class=""></path></svg>&nbsp;</span>
                </li>
                <li><strong><span>Tất cả các tour</span></strong></li>
            </ul>
        </div>
    </div>
    <div class="content">
        <div class="menu">
            <div class="danh-muc">
                <h2>Danh mục tour</h2>
                <ul class="loai-tour">
                    <li>
                        <a title="Tour trong nước" href="" class="link">Tour trong nước </a>
                    </li>
                    <li>
                        <a title="Tour nước ngoài" href="#" class="link">Tour nước ngoài</a>
                    </li>
                </ul>
            </div>
    
            <div class="tour-filter">
                <div class="filter-container">
                    <!-- Tiêu chí đã chọn -->
                    <div class="dieukien-dachon">
                        <span>Bạn đã chọn:</span>
                        <a href="#" onclick="clearAllFilters()" class="clear-all">Bỏ hết</a>
                        <ul id="dieukien-dachon-list">
                            <!-- Các tiêu chí được chọn sẽ hiển thị tại đây -->
                        </ul>
                    </div>

                    <!-- Bộ lọc mức giá -->
                    <div class="bo-loc">
                        <h3>Chọn mức giá</h3>
                        <ul>
                            <li><input type="checkbox" id="price-1" value="<3000000" onchange="toggleFilter(this)"> Giá dưới 3.000.000đ</li>
                            <li><input type="checkbox" id="price-2" value="3000000-5000000" onchange="toggleFilter(this)"> 3.000.000đ - 5.000.000đ</li>
                            <li><input type="checkbox" id="price-3" value="5000000-7000000" onchange="toggleFilter(this)"> 5.000.000đ - 7.000.000đ</li>
                            <li><input type="checkbox" id="price-4" value="7000000-9000000" onchange="toggleFilter(this)"> 7.000.000đ - 9.000.000đ</li>
                            <li><input type="checkbox" id="price-5" value=">9000000" onchange="toggleFilter(this)"> Giá trên 9.000.000đ</li>
                        </ul>
                    </div>

                    <!-- Bộ lọc điểm khởi hành -->
                    <div class="bo-loc">
                        <h3>Điểm khởi hành</h3>
                        <select id="departure-select" onchange="toggleSelectFilter('departure')">
                        <?php
                            $sql1 = "SELECT DISTINCT departure_point FROM tours";
                            $kq1 = mysqli_query($conn1, $sql1);

                            if ($kq1 && mysqli_num_rows($kq1) > 0) {
                                echo '<option value="">Chọn điểm khởi hành</option>';
                                while ($khoihanh = mysqli_fetch_assoc($kq1)) {
                                    $departurePoint = $khoihanh['departure_point'];
                                    echo '<option value="' . htmlspecialchars($departurePoint) . '">' . htmlspecialchars($departurePoint) . '</option>';
                                }
                            } else {
                                echo '<option value="">Không có điểm khởi hành</option>';
                            }
                        ?>
                        </select>
                    </div>

                    <!-- Bộ lọc điểm đến -->
                    <div class="bo-loc">
                        <h3>Điểm đến</h3>
                        <select id="destination-select" onchange="toggleSelectFilter('destination')">
                        <?php
                            $sql2 = "SELECT DISTINCT departure_point FROM tours";
                            $kq2 = mysqli_query($conn1, $sql2);

                            if ($kq2 && mysqli_num_rows($kq2) > 0) {
                                echo '<option value="">Chọn điểm đến</option>';
                                while ($diemden = mysqli_fetch_assoc($kq2)) {
                                    $departurePoint = $diemden['destination_point'];
                                    echo '<option value="' . htmlspecialchars($departurePoint) . '">' . htmlspecialchars($departurePoint) . '</option>';
                                }
                            } else {
                                echo '<option value="">Không có điểm khởi hành</option>';
                            }
                        ?>
                        </select>
                    </div>
                </div>
            </div>    

            <script>
            // Hàm để hiển thị và cập nhật các điều kiện lọc đã chọn
            function toggleFilter(checkbox) {
                const selectedList = document.getElementById('dieukien-dachon-list');
                const value = checkbox.value;

                if (checkbox.checked) {
                    // Tạo phần tử hiển thị điều kiện lọc
                    const li = document.createElement('li');
                    li.style.cursor = "pointer";
                    li.textContent = value;
                    li.dataset.value = value;
                    li.classList.add('selected-item');

                    // Thêm sự kiện xóa khi click vào chính li
                    li.onclick = function () {
                        removeFilter(value);
                    };

                    selectedList.appendChild(li);
                } else {
                    // Xóa điều kiện nếu bỏ chọn checkbox
                    const item = selectedList.querySelector(`[data-value="${value}"]`);
                    if (item) item.remove();
                }
                // Kiểm tra và hiển thị/ẩn phần điều kiện đã chọn
                hienthi_dieukienchon();
            }

            // Hàm để xóa một điều kiện cụ thể
            function removeFilter(value) {
                // Xóa khỏi danh sách điều kiện đã chọn
                const selectedList = document.getElementById('dieukien-dachon-list');
                const item = selectedList.querySelector(`[data-value="${value}"]`);
                if (item) item.remove();
                // Bỏ chọn checkbox tương ứng
                const checkbox = document.querySelector(`input[value="${value}"]`);
                if (checkbox) checkbox.checked = false;
                // Kiểm tra và hiển thị/ẩn phần điều kiện đã chọn
                hienthi_dieukienchon();
            }

            // Hàm để kiểm tra và hiển thị/ẩn phần điều kiện đã chọn
            function hienthi_dieukienchon() {
                const selectedList = document.getElementById('dieukien-dachon-list');
                const dieukienDachon = document.querySelector('.dieukien-dachon');
                
                // Nếu có ít nhất một điều kiện đã chọn, hiển thị phần điều kiện đã chọn
                if (selectedList.children.length > 0) {
                    dieukienDachon.style.display = 'block';
                } else {
                    dieukienDachon.style.display = 'none';
                }
            }

            // Hàm để xóa toàn bộ điều kiện lọc
            function clearAllFilters() {
                const selectedList = document.getElementById('dieukien-dachon-list');
                selectedList.innerHTML = ''; // Xóa toàn bộ danh sách

                // Bỏ chọn tất cả các checkbox
                const checkboxes = document.querySelectorAll('.bo-loc input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = false;
                });

                // Bỏ chọn tất cả các select
                const selects = document.querySelectorAll('.bo-loc select');
                selects.forEach(select => {
                    select.selectedIndex = 0;  // Đặt lại select về giá trị mặc định
                });

                // Kiểm tra và hiển thị/ẩn phần điều kiện đã chọn
                hienthi_dieukienchon();
            }

            // Hàm để ẩn/hiện danh sách dài
            function toggleList(listId) {
                const list = document.getElementById(listId);
                const hiddenItems = list.querySelectorAll('.hidden');
                const button = list.nextElementSibling;
                if (hiddenItems[0].style.display === 'none' || !hiddenItems[0].style.display) {
                    hiddenItems.forEach(item => item.style.display = 'block');
                    button.textContent = 'Thu gọn';
                } else {
                    hiddenItems.forEach(item => item.style.display = 'none');
                    button.textContent = 'Xem thêm';
                }
            }

            // Hàm để cập nhật điều kiện lọc khi chọn điểm khởi hành hoặc điểm đến
            function toggleSelectFilter(type) {
                const selectedList = document.getElementById('dieukien-dachon-list');
                const value = document.getElementById(`${type}-select`).value;

                if (value) {
                    // Tạo phần tử hiển thị điều kiện lọc
                    const li = document.createElement('li');
                    li.style.cursor = "pointer";
                    li.textContent = value;
                    li.dataset.value = value;
                    li.classList.add('selected-item');

                    // Thêm sự kiện xóa khi click vào chính li
                    li.onclick = function () {
                        removeFilter(value);
                    };

                    selectedList.appendChild(li);
                } else {
                    // Xóa điều kiện nếu không có giá trị chọn
                    const item = selectedList.querySelector(`[data-value="${value}"]`);
                    if (item) item.remove();
                }
                // Kiểm tra và hiển thị/ẩn phần điều kiện đã chọn
                hienthi_dieukienchon();
            }
            </script>
        </div>                                  
        <div class="danhsach-tour">
            <div class="sap-xep">
                <h3 style="float: left;">Sắp xếp theo</h3>
                <select id="sort-select" onchange="sortFilters()">
                    <option value="default">Mặc định</option>
                    <option value="asc">Giá tăng dần</option>
                    <option value="desc">Giá giảm dần</option>
                </select>
            </div>
            <script>
                function sortFilters() {
                    var sortValue = document.getElementById('sort-select').value;
                    var url = window.location.href.split('?')[0];  // Lấy URL hiện tại

                    // Gửi giá trị lựa chọn sắp xếp qua URL
                    window.location.href = url + '?sort=' + sortValue;
                }
            </script>
            <div class="tour-container">
            <?php if ($kq) {
                $i=0;
                while ($tour = mysqli_fetch_assoc($kq)) {
                $i++;
            ?>
                <div class="the-tour">
                    <div class="cot-hinh-anh">
                        <div class="khung-hinh-anh">
                            <a class="link-hinh-anh" href="<?php echo SITE_URL. 'views/user/tour-detail.php?id=' . $tour['id_tours']; ?>">
                                <img class="hinh-anh-tour" src="<?php echo SITE_URL. 'templates/image/tours/' . $tour['image']; ?>" alt="<?php echo $tour['name'];?>">
                            </a>
                        </div>
                    </div>
                    <div class="cot-thong-tin">
                        <div class="thong-tin-tour">
                            <div class="chi-tiet-tour">
                                <span class="ma-tour">Mã tour: <?php echo $tour['id_tours'];?> </span>
                                <h3 class="tieu-de-tour">
                                    <a href="<?php echo SITE_URL. 'views/user/tour-detail.php?id=' . $tour['id_tours']; ?>"><?php echo $tour['name'];?></a>
                                </h3>
                                <div class="thoi-gian-tour">
                                    <svg fill="#000000" width="24px" height="24px" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-1-7.59V4h2v5.59l3.95 3.95-1.41 1.41L9 10.41z"/></svg>
                                    Thời gian: 3N2Đ
                                </div>
                                <div class="chon-ngay">
                                    <div class="date-selector">
                                        <button type="button" class="arrow arrow<?php echo $i;?> left">
                                            <svg version="1.1" id="Icons" width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                                viewBox="0 0 32 32" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                                            </style>
                                            <circle class="st0" cx="16" cy="16" r="13"/>
                                            <polyline class="st0" points="18,21 13,16 18,11 "/>
                                            </svg>       
                                        </button>
                                        <div class="dates">
                                        <?php
                                            $sl1 = "SELECT day FROM itinerary  WHERE id_tours =" .  $tour['id_tours'];
                                            $kq1 = mysqli_query($conn1, $sl1);
                                        ?>
                                        <?php if ($kq1) {
                                            while ($date = mysqli_fetch_assoc($kq1)) {
                                                // Lấy ngày hiện tại và chuyển về định dạng timestamp
                                                $today = strtotime(date('Y-m-d'));

                                                // Chuyển đổi ngày trong cơ sở dữ liệu thành timestamp
                                                $db_date = strtotime($date['day']);

                                                // So sánh và chỉ hiển thị nếu ngày trong cơ sở dữ liệu lớn hơn ngày hiện tại
                                                if ($db_date > $today) { ?>
                                                    <button type="button" class="date date<?php echo $i;?>"><?php echo date('d/m/Y', $db_date); ?></button>
                                                <?php }
                                            };
                                        }; ?>
                                        </div>
                                        <button type="button" class="arrow arrow<?php echo $i;?> right">
                                            <svg version="1.1" id="Icons" width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                                            viewBox="0 0 32 32" xml:space="preserve">
                                            <style type="text/css">
                                                .st0{fill:none;stroke:#fff;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                                            </style>
                                            <circle class="st0" cx="16" cy="16" r="13"/>
                                            <polyline class="st0" points="14,11 19,16 14,21 "/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener("DOMContentLoaded", () => {
                                        const dates = document.querySelectorAll(".date<?php echo $i;?>");
                                        const leftArrow = document.querySelector(".arrow<?php echo $i;?>.left");
                                        const rightArrow = document.querySelector(".arrow<?php echo $i;?>.right");

                                        let visibleStart = 0; // Chỉ mục bắt đầu hiển thị
                                        const maxVisibleDates = 3; // Số ngày hiển thị tối đa

                                        // Cập nhật hiển thị ngày
                                        const updateVisibleDates = () => {
                                            dates.forEach((date, index) => {
                                                date.style.display =
                                                    index >= visibleStart && index < visibleStart + maxVisibleDates
                                                        ? "inline-block"
                                                        : "none";
                                            });

                                            // Kiểm tra để disable nút mũi tên
                                            leftArrow.disabled = visibleStart === 0;
                                            rightArrow.disabled = visibleStart + maxVisibleDates >= dates.length;
                                        };

                                        // Xử lý sự kiện khi click vào ngày
                                        dates.forEach((date, index) => {
                                            date.addEventListener("click", () => {
                                                dates.forEach((d) => d.classList.remove("active")); // Loại bỏ lớp active khỏi tất cả các ngày
                                                date.classList.add("active"); // Thêm lớp active cho ngày được chọn
                                            });
                                        });

                                        // Xử lý khi click mũi tên trái
                                        leftArrow.addEventListener("click", () => {
                                            if (visibleStart > 0) {
                                                visibleStart--;
                                                updateVisibleDates();
                                            }
                                        });

                                        // Xử lý khi click mũi tên phải
                                        rightArrow.addEventListener("click", () => {
                                            if (visibleStart + maxVisibleDates < dates.length) {
                                                visibleStart++;
                                                updateVisibleDates();
                                            }
                                        });

                                        // Khởi tạo trạng thái ban đầu
                                        updateVisibleDates();
                                    });
                                </script>
                            </div>
                            <div class="meta-tour">
                                <div class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                                        <path d="M9.01107 1.625C13.103 1.625 16.9043 4.90179 16.9043 9.03571C16.9043 11.7682 15.9811 13.7001 14.434 15.9524C12.707 18.4667 10.5018 20.8338 9.51601 21.8515C9.23162 22.1451 8.76735 22.1451 8.48296 21.8515C7.4972 20.8338 5.29202 18.4667 3.56496 15.9524C2.01787 13.7001 1.09473 11.7682 1.09473 9.03571C1.09473 4.90179 4.89588 1.625 8.98782 1.625" stroke="#0396ff" stroke-width="2" stroke-linecap="round"></path>
                                        <path d="M11.9637 9.47235C11.9637 11.1256 10.6409 12.4928 9.00411 12.4928C7.36733 12.4928 6.03516 11.1256 6.03516 9.47235C6.03516 7.81912 7.36733 6.56542 9.00411 6.56542C10.6409 6.56542 11.9637 7.81912 11.9637 9.47235Z" stroke="#0396ff" stroke-width="2"></path>
                                    </svg>
                                    <p>Khởi hành từ: <span><?php echo  $tour['departure_point'];?></span></p>
                                </div>
                                <?php if (!empty($tour['discount_price'])) { ?>
                                    <!-- Giá gốc với định dạng và gạch ngang -->
                                    <div class="gia-tour" style="text-decoration: line-through; color: #333;">
                                        <?php 
                                        $formatted_price = number_format($tour['price'], 0, ',', '.') . ' VND';
                                        echo $formatted_price;
                                        ?>
                                    </div>
                                    <!-- Giá khuyến mãi -->
                                    <div class="gia-tour">
                                        <?php 
                                        $formatted_discount_price = number_format($tour['discount_price'], 0, ',', '.') . ' VND';
                                        echo $formatted_discount_price;
                                        ?>
                                    </div>
                                <?php } else { ?>
                                    <!-- Chỉ hiển thị giá nếu không có khuyến mãi -->
                                    <div class="gia-tour">
                                        <?php 
                                        $formatted_price = number_format($tour['price'], 0, ',', '.') . ' VND';
                                        echo $formatted_price;
                                        ?>
                                    </div>
                                <?php } ?>
                                <a href="<?php echo SITE_URL. 'views/user/tour-detail.php?id=' . $tour['id_tours']; ?>" class="xem-chi-tiet-tour">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
                echo "Error: " . mysqli_error($conn1);
            }?>
            </div>
        </div>
    </div>
    <?php include "../../templates/layout/footer.php"; ?>
</body>
</html>