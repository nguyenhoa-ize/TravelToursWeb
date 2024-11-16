<?php
    include '../../config.php';
    include '../../includes/connect.php';
    include '../../includes/functions.php';
   
   
    include '../../includes/database.php';
   
    include '../../includes/session.php';

    $filterAll = filter();
    if(!empty($filterAll['id'])){
        $userID=$filterAll['id'];

        $userDetail=oneRaw("SELECT * FROM user WHERE id='$userID'");
        if(!empty($userDetail)){
            setFlashData('user-detail',$userDetail);
        }else{
            redirect('?page=edit_user');
        }
    }

   if (isPost()) {
        $password = $filterAll['password']; 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $filterAll = filter();
        $errors =[];// Chứa các lỗi

        // Validate fullname
        if (empty($filterAll['username'])) {
            $errors['username']['required'] = 'Cần phải nhập họ tên';
        } else {
            if (strlen($filterAll['username']) < 5) {
                $errors['username']['min'] = 'Họ tên phải có ít nhất 5 ký tự.';
            }
        }
        // validate email: bắt buộc phải nhập, đúng định dạng, kiểm tra email đã tồn tại hay chưa
        if (empty($filterAll['email'])) {
            $errors['email']['required'] = 'Cần phải nhập email';
        } 
        else {
            $email  = $filterAll['email'];
            $sql = "SELECT id FROM user WHERE email ='$email'AND id <> $userID ";
            if(getRows($sql) > 0){
                $errors['email']['unique'] = 'Email đã tồn tại.';
        }
        
        // Validate số điện thoại: bắt buộc phải nhập, số có đúng định dạng không
        if (empty($filterAll['phone'])) {
            $errors['phone']['required'] = 'Số điện thoại bắt buộc phải nhập.';
        } else {
            if(!isPhone($filterAll['phone'])){
                $errors['phone']['isPhone'] = 'Số điện thoại không hợp lệ.';
            }
        }
         if(!empty($filterAll['password'])){
             // Validate pasword_confirm: bắt buộc phải nhập, giống password
          if (empty($filterAll['confirm-password'])) {
            $errors['confirm-password']['required'] = 'Bạn phải nhập lại mật khẩu.';
        } else {
            if(($filterAll['password']) != $filterAll['confirm-password']){
                $errors['pconfirm-password']['match'] = 'Mật khẩu bạn nhập lại không đúng.';
            }
        }
    }}
    if(empty($errors)){
        $dataUpdate = [
            'username' => $filterAll['username'],
            'email' => $filterAll['email'],
            'phone' => $filterAll['phone'],
            'status' => $filterAll['status'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        if(!empty($filterAll['password'])){
            $dataUpdate['password'] = password_hash($filterAll['password'], PASSWORD_DEFAULT);
        }
        $condition = "id = $userID";
        $UpdateStatus = update('user',$dataUpdate, $condition);
        if($UpdateStatus){
            setFlashData('smg', 'Sửa người dùng thành công!');
            setFlashData('smg_type', 'success');
                
        }else{
                setFlashData('smg','Không thành công');
                setFlashData('smg_type','danger');
               
        }
       
        }else{
            setFlashData('smg','Vui lòng kiểm tra lại dữ liệu!!');
            setFlashData('smg_type','danger');
            setFlashData('errors',$errors);
            setFlashData('old',$filterAll);
        }
        redirect('?page=QLND&action=edit_user&id='.$userID);
    }

    $smg = getFlashData('smg');
    $smg_type = getFlashData('smg_type');    
    $errors = getFlashData('errors');
    $old = getFlashData('old');
    $userDetail = getFlashData('user-detail');
    if(!empty($userDetail)){
        $old = $userDetail;
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng Ký - Đặt Tour Du Lịch</title>
    <link rel="stylesheet" href="../../templates/css/styleAdd.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
<div class="register-container">
        <?php
            // Hiển thị thông báo nếu có
            if (!empty($smg)) {
                echo "<div class='alert alert-{$smg_type}'>{$smg}</div>";
                }
        ?>
    <form action="" method="post">
        <h2>Sửa người dùng</h2>
        
        <div class="form-group">
            <div class="form-item">
                <label for="username">Họ tên</label>
                <input type="text" name="username" id="username" placeholder="Họ tên" 
                       value="<?php echo old('username', $old); ?>">
                <?php echo form_error('username', '<span class="error">', '</span>', $errors); ?>
            </div>
            
            <div class="form-item">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Mật khẩu ( Không nhập nếu không thay đổi) ">
                <?php echo form_error('password', '<span class="error">', '</span>', $errors); ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="form-item">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Địa chỉ email" 
                       value="<?php echo old('email', $old); ?>">
                <?php echo form_error('email', '<span class="error">', '</span>', $errors); ?>
            </div>
            
            <div class="form-item">
                <label for="confirm-password">Nhập lại Password</label>
                <input type="password" name="confirm-password" id="confirm-password" placeholder="Nhập lại mật khẩu ( Không nhập nếu không thay đổi)" >
                <?php echo form_error('confirm-password', '<span class="error">', '</span>', $errors); ?>
            </div>
        </div>
        
        <div class="form-group">
            <div class="form-item">
                <label for="phone">Số điện thoại</label>
                <input type="number" name="phone" id="phone" placeholder="Số điện thoại" 
                       value="<?php echo old('phone', $old); ?>">
                <?php echo form_error('phone', '<span class="error">', '</span>', $errors); ?>
            </div>
            
            <div class="form-item">
                <label for="status">Trạng thái</label>
                <select name="status" id="status" >
                    <option value="0" <?php echo (old('status', $old) == '0') ? 'selected' : ''; ?>>Đã kích hoạt</option>
                    <option value="1" <?php echo (old('status', $old) == '1') ? 'selected' : ''; ?>>Chưa kích hoạt</option>
                </select>
                <?php echo form_error('status', '<span class="error">', '</span>', $errors); ?>
            </div>
        </div>
        <input  type="hidden" name="id" value="<?php echo $userID ?>">
        
        <div class="form-buttons">
            <button type="submit" class="btn-primary">Sửa người dùng</button>
            <button type="button" class="btn-secondary" onclick="window.location.href='?page=QLND'">Quay lại</button>
        </div>
    </form>
</div>

</body>
</html>

