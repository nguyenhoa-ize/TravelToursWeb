<?php
    include '../../templates/layout/header.php';
    include '../../config.php';
    include '../../includes/connect.php';
    include '../../includes/database.php';
    include '../../includes/functions.php';
    include '../../includes/session.php';
?>
<?php 
   if (isPost()) {
        $filterAll = filter();
        $errors =[];// Chứa các lỗi

        //Validate username
        if (empty($filterAll['username'])) {
            $errors['username']['required'] = 'Bạn chưa nhập username';
        } else {
            if (strlen($filterAll['username']) < 5) {
                $errors['username']['min'] = 'Username phải có ít nhất 5 ký tự.';
            }
        }

        // Validate fullname
        if (empty($filterAll['fullname'])) {
            $errors['fullname']['required'] = 'Bạn chưa nhập họ và tên';
        } else {
            if (strlen($filterAll['fullname']) < 5) {
                $errors['fullname']['min'] = 'Họ tên phải có ít nhất 5 ký tự.';
            }
        }
        // validate email: bắt buộc phải nhập, đúng định dạng, kiểm tra email đã tồn tại hay chưa
        if (empty($filterAll['email'])) {
            $errors['email']['required'] = 'Cần phải nhập email';
        } 
        else {
            $email  = $filterAll['email'];
            $sql = "SELECT id FROM user WHERE email ='$email'";
            if(getRows($sql) > 0){
                $errors['email']['unique'] = 'Email đã tồn tại.';
        }
        
        // Validate số điện thoại: bắt buộc phải nhập, số có đúng định dạng không
        if (empty($filterAll['phone'])) {
            $errors['phone']['required'] = 'Bạn chưa nhập số điện thoại.';
        } else {
            if(!isPhone($filterAll['phone'])){
                $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ.';
            }
        }
        // Validate password: bắt buộc phải nhập, >=8 ký tự
        if (empty($filterAll['password'])) {
            $errors['password']['required'] = 'Mật khẩu bắt buộc phải nhập.';
        } else {
            if(strlen($filterAll['password']) < 6){
                $errors['password']['min'] = 'Mật khẩu phải lớn hơn hoặc bằng 6.';
            }
        }
        // Validate pasword_confirm: bắt buộc phải nhập, giống password
        if (empty($filterAll['confirm-password'])) {
            $errors['confirm-password']['required'] = 'Bạn phải nhập lại mật khẩu.';
        } else {
            if(($filterAll['password']) != $filterAll['confirm-password']){
                $errors['pconfirm-password']['match'] = 'Mật khẩu bạn nhập lại không đúng.';
            }
        }
    }
    if(empty($errors)){
        $dataInsert = [
            'username' => $filterAll['username'],
            'fullname' => $filterAll['fullname'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'password' => password_hash($filterAll['password'],PASSWORD_DEFAULT),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $insertStatus = insert('user',$dataInsert);
        if($insertStatus){
            setFlashData('smg','Đăng ký thành công');
            setFlashData('smg_type','success');
            redirect('login.php');
            
        }
        else{
            setFlashData('smg','Vui lòng kiểm tra lại dữ liệu!!');
            setFlashData('smg_type','danger');
            setFlashData('errors',$errors);
            setFlashData('old',$filterAll);
            redirect('register.php');
            
        }
    
    } else {
    // Nếu có lỗi, lưu lại thông tin đã nhập
    setFlashData('errors', $errors);
    setFlashData('old', $filterAll);
    }
}

$smg = getFlashData('smg');
$smg_type = getFlashData('smg_type');
$errors = getFlashData('errors');
$old = getFlashData('old');
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký - Đặt Tour Du Lịch</title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f2f6fc;
            font-family: Arial, sans-serif;
        }
        .register-container {
            max-width: 500px;
            margin: 100px auto;
            padding: 40px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        .register-container h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }
        .register-container input {
            display: block;
            width: 460px;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        .register-container button {
            display: block;
            width: 500px;
            padding: 12px 20px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .register-container button:hover {
            background-color: #0056b3;
        }
        .register-container a {
            display: block;
            text-align: right;
            margin-top: 10px;
            color: #007bff;
            text-decoration: none;
        }
        .register-container a:hover {
            text-decoration: underline;
        }
        .alert {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-size: 16px;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
<div class="register-container">
    <?php 
            if(!empty($smg)){
               getSmg($smg,$smg_type);
            }
           
    ?>
    <form action="" method="post">
    <h2>Đăng Ký Tài Khoản</h2>
    <?php 
        echo form_error('username','<span class="error">','</span>',$errors );
    ?>
    <input type="text" name="username" id="username" placeholder="Username" value="<?php 
    echo old('username',$old);
    ?>">
    <?php 
        echo form_error('fullname','<span class="error">','</span>',$errors );
    ?>
    <input type="text" name="fullname" id="fullname" placeholder="Họ và tên" value="<?php 
    echo old('fullname',$old);
    ?>">
    <?php 
        echo form_error('email','<span class="error">','</span>',$errors );
    ?>
    <input type="email" name="email" id="email" placeholder="Email"value="<?php 
    echo old('email',$old);
    ?>">
    <?php 
        echo form_error('phone','<span class="error">','</span>',$errors );
    ?>
    <input type="number" name="phone" id="phone" placeholder="Số điện thoại"value="<?php 
    echo old('phone',$old);
    ?>">
    <?php 
        echo form_error('password','<span class="error">','</span>',$errors );
    ?>
    <input type="password" name="password" id="password" placeholder="Mật khẩu">
    <?php 
        echo form_error('confirm-password','<span class="error">','</span>',$errors );
    ?>
    <input type="password" name="confirm-password" id="confirm-password" placeholder="Xác nhận mật khẩu">
    <button type="submit">Đăng ký</button> 
    <a href="login.php">Đã có tài khoản?</a>
    </form>
</div>
</body>
</html>

<?php
    include '../../templates/layout/footer.php';
?>

