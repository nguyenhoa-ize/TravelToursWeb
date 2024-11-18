<?php
    include '../../config.php';
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách Tour Du Lịch</title>
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
                        <a title="Tour trong nước" href="/tour-trong-nuoc" class="link">Tour trong nước </a>
                    </li>
                    <li>
                        <a title="Tour nước ngoài" href="/tour-nuoc-ngoai" class="link">Tour nước ngoài</a>
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
                    <ul class="list" id="departure-list">
                        <li><input type="checkbox" value="Hà Nội" onchange="toggleFilter(this)"> Hà Nội</li>
                        <li><input type="checkbox" value="TP Hồ Chí Minh" onchange="toggleFilter(this)"> TP Hồ Chí Minh</li>
                        <li><input type="checkbox" value="Đà Nẵng" onchange="toggleFilter(this)"> Đà Nẵng</li>
                        <li class="hidden"><input type="checkbox" value="Hải Phòng" onchange="toggleFilter(this)"> Hải Phòng</li>
                        <li class="hidden"><input type="checkbox" value="Nha Trang" onchange="toggleFilter(this)"> Nha Trang</li>
                    </ul>
                    <button class="toggle-btn" onclick="toggleList('departure-list')">Xem thêm</button>
                </div>
    
                <!-- Bộ lọc điểm đến -->
                <div class="bo-loc">
                    <h3>Điểm đến</h3>
                    <ul class="list" id="destination-list">
                        <li><input type="checkbox" value="Hà Nội" onchange="toggleFilter(this)"> Hà Nội</li>
                        <li><input type="checkbox" value="TP Hồ Chí Minh" onchange="toggleFilter(this)"> TP Hồ Chí Minh</li>
                        <li><input type="checkbox" value="Đà Nẵng" onchange="toggleFilter(this)"> Đà Nẵng</li>
                        <li class="hidden"><input type="checkbox" value="Hạ Long" onchange="toggleFilter(this)"> Hạ Long</li>
                        <li class="hidden"><input type="checkbox" value="Phú Quốc" onchange="toggleFilter(this)"> Phú Quốc</li>
                    </ul>
                    <button class="toggle-btn" onclick="toggleList('destination-list')">Xem thêm</button>
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
            <div class="tour-container">
                <!-- Tour 1 -->
                <div class="the-tour">
                    <img src="https://cdn2.ivivu.com/2023/12/21/10/ivivu-cho-hoa-dau-nam-con-minh-kieu-tu-trung-quoc-930x520.gif" alt="Tour Đà Lạt 3N2Đ">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                            <path d="M9.01107 1.625C13.103 1.625 16.9043 4.90179 16.9043 9.03571C16.9043 11.7682 15.9811 13.7001 14.434 15.9524C12.707 18.4667 10.5018 20.8338 9.51601 21.8515C9.23162 22.1451 8.76735 22.1451 8.48296 21.8515C7.4972 20.8338 5.29202 18.4667 3.56496 15.9524C2.01787 13.7001 1.09473 11.7682 1.09473 9.03571C1.09473 4.90179 4.89588 1.625 8.98782 1.625" stroke="#0396ff" stroke-width="2" stroke-linecap="round"></path>
                            <path d="M11.9637 9.47235C11.9637 11.1256 10.6409 12.4928 9.00411 12.4928C7.36733 12.4928 6.03516 11.1256 6.03516 9.47235C6.03516 7.81912 7.36733 6.56542 9.00411 6.56542C10.6409 6.56542 11.9637 7.81912 11.9637 9.47235Z" stroke="#0396ff" stroke-width="2"></path>
                        </svg>
                        <p>Khởi hành từ: <span>Hà Nội</span></p>
                    </div>
                    <h3 class="tour-name">
                        <a href="#" title="Du lịch Nha Trang - VinWonders Nha Trang - Hòn Mun 3N2Đ">
                            Du lịch Nha Trang - VinWonders Nha Trang - Hòn Mun 3N2Đ
                        </a> Hà Nội 2N1Đ
                    </h3>
                    <p>Khám phá vẻ đẹp của thành phố ngàn hoa.</p>
                    <p class="price">3,000,000 VND</p>
                </div>
                <!-- Tour 2 -->
                <div class="the-tour">
                    <img src="https://cdn2.ivivu.com/2023/12/21/10/ivivu-cho-hoa-dau-nam-con-minh-kieu-tu-trung-quoc-930x520.gif" alt="Tour Phú Quốc 4N3Đ">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                            <path d="M9.01107 1.625C13.103 1.625 16.9043 4.90179 16.9043 9.03571C16.9043 11.7682 15.9811 13.7001 14.434 15.9524C12.707 18.4667 10.5018 20.8338 9.51601 21.8515C9.23162 22.1451 8.76735 22.1451 8.48296 21.8515C7.4972 20.8338 5.29202 18.4667 3.56496 15.9524C2.01787 13.7001 1.09473 11.7682 1.09473 9.03571C1.09473 4.90179 4.89588 1.625 8.98782 1.625" stroke="#0396ff" stroke-width="2" stroke-linecap="round"></path>
                            <path d="M11.9637 9.47235C11.9637 11.1256 10.6409 12.4928 9.00411 12.4928C7.36733 12.4928 6.03516 11.1256 6.03516 9.47235C6.03516 7.81912 7.36733 6.56542 9.00411 6.56542C10.6409 6.56542 11.9637 7.81912 11.9637 9.47235Z" stroke="#0396ff" stroke-width="2"></path>
                        </svg>
                        <p>Khởi hành từ: <span>Hà Nội</span></p>
                    </div>
                    <h3 class="tour-name">
                        <a href="#" title="Du lịch Nha Trang - VinWonders Nha Trang - Hòn Mun 3N2Đ">
                            Du lịch Nha Trang - VinWonders Nha Trang - Hòn Mun 3N2Đ
                        </a> Hà Nội 2N1Đ
                    </h3>
                    <p>Thư giãn tại hòn đảo ngọc của Việt Nam.</p>
                    <p class="price">5,500,000 VND</p>
                </div>
                <!-- Tour 3 -->
                <div class="the-tour">
                    <img src="https://cdn2.ivivu.com/2023/12/21/10/ivivu-cho-hoa-dau-nam-con-minh-kieu-tu-trung-quoc-930x520.gif" alt="Tour Hà Nội 2N1Đ">
                    <div class="icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                            <path d="M9.01107 1.625C13.103 1.625 16.9043 4.90179 16.9043 9.03571C16.9043 11.7682 15.9811 13.7001 14.434 15.9524C12.707 18.4667 10.5018 20.8338 9.51601 21.8515C9.23162 22.1451 8.76735 22.1451 8.48296 21.8515C7.4972 20.8338 5.29202 18.4667 3.56496 15.9524C2.01787 13.7001 1.09473 11.7682 1.09473 9.03571C1.09473 4.90179 4.89588 1.625 8.98782 1.625" stroke="#0396ff" stroke-width="2" stroke-linecap="round"></path>
                            <path d="M11.9637 9.47235C11.9637 11.1256 10.6409 12.4928 9.00411 12.4928C7.36733 12.4928 6.03516 11.1256 6.03516 9.47235C6.03516 7.81912 7.36733 6.56542 9.00411 6.56542C10.6409 6.56542 11.9637 7.81912 11.9637 9.47235Z" stroke="#0396ff" stroke-width="2"></path>
                        </svg>
                        <p>Khởi hành từ: <span>Hà Nội</span></p>
                    </div>
                    <h3 class="tour-name">
                        <a href="#" title="Du lịch Nha Trang - VinWonders Nha Trang - Hòn Mun 3N2Đ">
                            Du lịch Nha Trang - VinWonders Nha Trang - Hòn Mun 3N2Đ
                        </a> Hà Nội 2N1Đ
                    </h3>
                    <p>Tham quan thủ đô ngàn năm văn hiến.</p>
                    <p class="price">2,000,000 VND</p>
                </div>
            </div>
        </div>
    </div>
    <?php include "../../templates/layout/footer.php"; ?>
</body>
</html>