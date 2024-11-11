<?php
// Hàm khởi tạo session
function startSession() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); // Khởi tạo session nếu chưa có
    }
}

// Hàm gán session
function setSession($key, $value) {
    startSession(); // Đảm bảo session đã được khởi tạo
    $_SESSION[$key] = $value;
}

// Hàm đọc session
function getSession($key = '') {
    startSession(); // Đảm bảo session đã được khởi tạo
    if (empty($key)) {
        return $_SESSION;
    } else {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }
}

// Hàm xoá session
function removeSession($key = '') {
    startSession(); // Đảm bảo session đã được khởi tạo
    if (empty($key)) {
        session_destroy(); // Hủy toàn bộ session
    } else {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]); // Xóa key session
        }
    }
}

// Hàm gán flash data (dữ liệu tạm thời cho một lần truy cập)
function setFlashData($key, $value) {
    startSession(); // Đảm bảo session đã được khởi tạo
    $_SESSION['flash_' . $key] = $value; // Lưu flash data vào session
}

// Hàm đọc flash data (và xóa sau khi đọc)
function getFlashData($key) {
    startSession(); // Đảm bảo session đã được khởi tạo
    $key = 'flash_' . $key;
    $data = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    removeSession($key); // Xóa dữ liệu flash sau khi đã đọc
    return $data;
}

?>