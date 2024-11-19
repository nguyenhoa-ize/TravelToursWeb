<?php
include '../../config.php';
include '../../templates/layout/header.php';
include '../../includes/connect.php';
include '../../includes/database.php';
include '../../includes/functions.php';
include '../../includes/session.php';

// Kiểm tra trạng thái phiên
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Khởi động phiên nếu chưa có
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['btn_change_password'])) {
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_new_password']);
    
    $user_id = $_SESSION['id_user'];
    $error_messages = ["current_password" => "", "new_password" => "", "confirm_new_password" => ""];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        setFlashData('msg', 'Vui lòng nhập đầy đủ thông tin.');
        setFlashData('msg_type', 'danger');
        redirect('change_password.php'); // Chuyển hướng lại trang đổi mật khẩu
    } else {
        $sql = "SELECT password FROM user WHERE id_user = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($current_password, $user['password'])) {
            setFlashData('msg', 'Mật khẩu hiện tại không đúng.');
            setFlashData('msg_type', 'danger');
            redirect('change_password.php');
        } elseif (strlen($new_password) < 6) {
            setFlashData('msg', 'Mật khẩu mới phải có ít nhất 6 ký tự.');
            setFlashData('msg_type', 'danger');
            redirect('change_password.php');
        } elseif ($new_password !== $confirm_password) {
            setFlashData('msg', 'Mật khẩu mới và xác nhận mật khẩu không khớp.');
            setFlashData('msg_type', 'danger');
            redirect('change_password.php');
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE user SET password = :new_password WHERE id_user = :user_id";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bindParam(':new_password', $hashed_password, PDO::PARAM_STR);
            $update_stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

            if ($update_stmt->execute()) {
                setFlashData('msg', 'Đổi mật khẩu thành công!');
                setFlashData('msg_type', 'success');
                redirect('profile.php'); // Chuyển hướng đến trang profile
            } else {
                setFlashData('msg', 'Có lỗi xảy ra khi đổi mật khẩu. Vui lòng thử lại.');
                setFlashData('msg_type', 'danger');
                redirect('change_password.php');
            }
        }
    }
}

$msg = getFlashData('msg');
$msg_type = getFlashData('msg_type');

?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đổi Mật Khẩu - Đặt Tour Du Lịch</title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../templates/css/style_change_password.css">
</head>
<body>
    <div class="password-change-container">
        <form action="" method="POST">
            <h2>Đổi Mật Khẩu</h2>
            <?php if (!empty($msg)) { ?>
                <div class="alert alert-<?php echo $msg_type; ?>">
                    <?php echo $msg; ?>
                </div>
            <?php } ?>
            <input type="password" name="current_password" id="current_password" placeholder="Mật khẩu hiện tại">
            <input type="password" name="new_password" id="new_password" placeholder="Mật khẩu mới">
            <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="Xác nhận mật khẩu mới">
            <button type="submit" name="btn_change_password">Đổi mật khẩu</button>
            <a href="profile.php">Quay lại</a>
        </form>
    </div>
</body>
</html>
<?php
include '../../templates/layout/footer.php';
?>
