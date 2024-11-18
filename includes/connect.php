<?php
    // Kết nối tới cơ sở dữ liệu
    $conn = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die("Kết nối thất bại!");
    mysqli_select_db($conn, DB_DATABASE) or die("Không tồn tại database này!");
?>