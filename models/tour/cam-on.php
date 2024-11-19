<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <style>
        /* CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #0056b3;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .thank-you-container {
            text-align: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .thank-you-container h1 {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .thank-you-container p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .thank-you-container a {
            display: inline-block;
            text-decoration: none;
            background-color: #fff;
            color: #2575fc;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .thank-you-container a:hover {
            background-color: #6a11cb;
            color: #fff;
        }

        .thank-you-container svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="thank-you-container">
        <!-- Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#fff">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1.29 15.29l-3.89-3.89 1.41-1.41 2.48 2.48 5.18-5.18 1.41 1.41-6.59 6.59z"/>
        </svg>
        <!-- Title -->
        <h1>Thank You!</h1>
        <p>Bạn đã đặt tour thành công. Chúc bạn có một tour du lịch vui vẻ!</p>
        <a href="../../index.php">Quay lại trang chủ</a>
    </div>
</body>
</html>
