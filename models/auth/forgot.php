<?php
    
    include '../../config.php';

    include '../../includes/connect.php';
    include '../../includes/database.php';
    include '../../includes/functions.php';
    include '../../includes/session.php';
?>

<?php
$thongbao = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn1'])) {
    $email = trim(strip_tags($_POST['email'])); // Tiếp nhận email

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $thongbao .= "Email không hợp lệ <br>";
    } else {
        $sql = "SELECT count(*) FROM user WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch();

        if ($row[0] == 0) {
            $thongbao .= "Email này không tồn tại <br>";
        } else {
            // Tạo mật khẩu mới ngẫu nhiên
            $pass_moi = bin2hex(random_bytes(4)); // Tạo chuỗi ngẫu nhiên 8 ký tự
            $hashed_password = password_hash($pass_moi, PASSWORD_DEFAULT); // Mã hóa mật khẩu mới

            $sql = "UPDATE user SET password = :password WHERE email = :email";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute(['password' => $hashed_password, 'email' => $email]);

            if ($result) {
                $thongbao .= "Cập nhật mật khẩu thành công.<br>";
            } else {
                $thongbao .= "Cập nhật mật khẩu không thành công <br>";
            }
        }
        require_once "PHPMailer-master/PHPMailer-master/src/PHPMailer.php";
        require_once "PHPMailer-master/PHPMailer-master/src/Exception.php";
        require_once "PHPMailer-master/PHPMailer-master/src/SMTP.php";


        $mail = new PHPMailer\PHPMailer\PHPMailer(true);
        try {
            $mail->SMTPDebug = 0; 
            $mail->isSMTP(); // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com'; // Server gửi thư
            $mail->SMTPAuth = true;
            $mail->Username = 'ilovebesun1996@gmail.com'; 
            $mail->Password = 'iiwovvscaavymnbs';
            $mail->SMTPSecure = 'ssl'; //TLS hoặc `ssl`
            $mail->Port = 465; // 587 hoặc 465
            $mail -> CharSet = "UTF-8";
            $mail->smtpConnect([ "ssl" => [
                        "verify_peer"=>false,
                        "verify_peer_name" => false,
                        "allow_self_signed" => true
                        ]
                    ]
        );
        //Khai báo người gửi và người nhận mail
        $mail->setFrom('ilovebesun1996@gmail.com', 'Ban quản trị website');
        $mail->addAddress("{$email}", 'Quý khách');
        $mail->isHTML(true); // nội dung của email có mã HTML
        $mail->Subject = 'Cấp lại mật khẩu mới';
        $mail->Body = "Đây là mật khẩu mới của bạn <b> {$pass_moi} </b>";
        $mail->send();
        $thongbao .= "Đã gửi mail thành công<br>";
        } catch (Exception $e) {
        $thongbao .= "Lỗi khi gửi thư: " . $mail->ErrorInfo;
            }
        }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Quên Mật Khẩu - Đặt Tour Du Lịch</title>
  <link rel="stylesheet" href="../../templates/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="stylesheet" href="../../templates/css/style_forgot.css">

</head>
<body>
    <?php
    include '../../templates/layout/header.php';
    ?>
    
<div class="recovery-container">
  <form action="" method="post">
      <h2>Quên Mật Khẩu</h2>
      <?php
          if (!empty($msg)) {
              getSmg($msg, $msg_type);
          }
      ?>
      <input type="text" name="email" id="email" placeholder="Địa chỉ email" required>
      <button type="submit" name="btn1">Gửi yêu cầu</button>
      <a href="login.php">Quay lại đăng nhập</a>
  </form>
</div>
<?php if ($thongbao != "") { ?>
<style>
  
  .notification-container {
      max-width: 600px;
      margin: 50px auto;
      padding: 20px;
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
      border-radius: 5px;
      text-align: center;
  }
  .notification-container button,
  .notification-container a {
      padding: 10px 15px;
      margin: 5px;
      border: none;
      border-radius: 3px;
      cursor: pointer;
      font-size: 16px;
  }
  .notification-container button {
      background-color: #007bff;
      color: #fff;
  }
  .notification-container button:hover {
      background-color: #0056b3;
  }
  .notification-container a {
      background-color: #17a2b8;
      color: #fff;
      text-decoration: none;
  }
  .notification-container a:hover {
      background-color: #138496;
  }
</style>
<div class="notification-container">
  <div>
      <?=$thongbao?>
  </div>
  <button onclick="history.back()">Trở lại</button>
  <a href="../../index.php">Trang chủ</a>
</div>
<?php exit(); } ?>
<div>

</div>
</body>
</html>
<?php
    include '../../templates/layout/footer.php';
?>


