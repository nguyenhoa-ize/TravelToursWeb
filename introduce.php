<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    // Check if the user is logged in
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit;
    }

    // Get the user's name
    $user_name = $_SESSION['user']['name'];

    // Set the page title
    $page_title = "Giới thiệu";

    // Include the header
    include('includes/header.php');
    ?>

    <div class="container">
    <div class="row">
        <div class="col-md-12">
        <h1>Giới thiệu</h1>
        <p>Xin chào, <?php echo $user_name; ?>! Chào mừng bạn đến với trang web của chúng tôi. </p>
        <p>Đây là một trang web đơn giản được tạo ra để minh họa cho việc sử dụng PHP và MySQL.</p>
        <p>Hãy khám phá trang web của chúng tôi để tìm hiểu thêm về các tính năng và cách thức hoạt động.</p>
        </div>
    </div>
    </div>

    <?php
    // Include the footer
    include('includes/footer.php');
    ?>
</body>
</html>