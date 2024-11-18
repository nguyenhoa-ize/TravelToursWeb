<?php
    // Kết nối tới cơ sở dữ liệu
    $conn1 = @mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die("Kết nối thất bại!");
    mysqli_select_db($conn1, DB_DATABASE) or die("Không tồn tại database này!");
    try {
        if(class_exists('PDO')){
    
            $dsn = 'mysql:dbname='._DB.';host='._HOST;
    
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //Set utf8
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Tạo thông báo ra ngoại lệ khi gặp lỗi
                ];
    
            $conn = new PDO($dsn,_USER,_PASS,$options);
            // if($conn){
            //     echo ' Kết nối thành công ';
            // }
        }
    
    }catch(Exception $exception){
        echo '<div style="color:red; padding: 5px 15px;border: 1px solid red;">';
        echo $exception -> getMessage().'<br>';
        echo '</div>';
        die();
    }
?>