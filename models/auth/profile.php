<?php
include '../../config.php';
include '../../templates/layout/header.php';
include '../../includes/connect.php';
include '../../includes/database.php';
include '../../includes/functions.php';
include '../../includes/session.php';



session_start(); 


$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;

// Kiểm tra nếu người dùng chưa đăng nhập
if (!isset($_SESSION['id_user'])) {
    $userDetails = [
        'username' => '',
        'fullname' => '',
        'email' => '',
        'phone' => '',
        'address' => ''
    ];
} else {
    // Truy vấn thông tin người dùng
    $id_user = $_SESSION['id_user'];
    $sql = "SELECT * FROM user WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Lỗi khi chuẩn bị câu truy vấn: " . $conn->errorInfo()[2];
        exit;
    }
    $stmt->execute([$id_user]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userDetails = $user;
    } else {
        $userDetails = [
            'username' => '',
            'fullname' => '',
            'email' => '',
            'phone' => '',
            'address' => ''
        ];
    }
}

// Cập nhật thông tin người dùng
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Cập nhật thông tin người dùng bao gồm cả email
    $sql_update = "UPDATE user SET username = ?, fullname = ?, email = ?, phone = ?, address = ? WHERE id_user = ?";
    $stmt_update = $conn->prepare($sql_update);
    if ($stmt_update === false) {
        echo "Lỗi khi chuẩn bị câu truy vấn cập nhật: " . $conn->errorInfo()[2];
        exit;
    }
    $stmt_update->execute([$username, $fullname, $email, $phone, $address, $id_user]);

    // Cập nhật lại thông tin người dùng sau khi lưu
    $userDetails['username'] = $username;
    $userDetails['fullname'] = $fullname;
    $userDetails['email'] = $email;
    $userDetails['phone'] = $phone;
    $userDetails['address'] = $address;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật thông tin tài khoản</title>
    <link rel="stylesheet" href="../../templates/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../../templates/css/style_profile.css">
</head>
<body>
    <div class="profile-container">
        <h2>Thông tin tài khoản</h2>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($userDetails['username']); ?>" required>

            <label for="fullname">Họ tên:</label>
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($userDetails['fullname']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($userDetails['email']); ?>" required>
            
            <label for="phone">Số điện thoại:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($userDetails['phone']); ?>">
            
            <label for="address">Thành phố bạn đang ở:</label>
            <textarea name="address" required><?php echo htmlspecialchars($userDetails['address']); ?></textarea>
            
            <button type="submit" name="update_profile">Lưu</button>
        </form>
        <h2>Đổi mật khẩu</h2>
        <button type="button" onclick="window.location.href='change_password.php'">Đổi mật khẩu</button>
    </div>
</body>
</html>

<?php
include '../../templates/layout/footer.php';
?>
