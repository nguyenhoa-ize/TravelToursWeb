<?php
// Kiểm tra email
function isEmail($email){
    $checkEmail = filter_var($email.FILTER_VALIDATE_EMAIL);
    return $checkEmail;
}

//Hàm kiểm tra số nguyên 
function isNumberInt($number){
    $checkNumber = filter_var($number.FILTER_VALIDATE_INT);
    return $checkNumber;
}
//Hàm kiểm tra số thực 
function isNumberFloat($number){
    $checkNumber = filter_var($number.FILTER_VALIDATE_FLOAT);
    return $checkNumber;
}

//Kiểm tra phương thức GET 
function isGet(){
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        return true;
    }
    return false;
}

//Hàm lọc dữ liệu
function filter(){
    $filterArr = [];
    if (isGet()){
        //Xử lý các dữ liệu trước khi hiển thị ra
        //return $_GET;
        if (!empty($_GET)){
            foreach($_GET as $key => $value)
            {
                $key =strip_tags($key);
                if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_GET,$key, FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }
                else {
                    $filterArr[$key] = filter_input(INPUT_GET,$key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
                
        }
    }

    if (isPost()){
        //Xử lý các dữ liệu trước khi hiển thị ra
        //return $_POST;
        if (!empty($_POST)){
            foreach($_POST as $key => $value)
            {
                $key =strip_tags($key);
                if(is_array($value)){
                    $filterArr[$key] = filter_input(INPUT_POST,$key, FILTER_SANITIZE_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
                }
                else {
                    $filterArr[$key] = filter_input(INPUT_POST,$key, FILTER_SANITIZE_SPECIAL_CHARS);
                }  
            }
        }
    }
    return $filterArr;
}

//Kiểm tra phương thức POST 
function isPOST(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        return true;
    }
    return false;
}
//Hàm kiểm tra số điện thoại 
function isPhone($phone){
    // 0396852831
    $checkZero = false;

    // Điều kiện 1: ký tự đầu tiên là số 0
    if ($phone[0] == '0') {
        $checkZero = true;
        $phone = substr($phone, 1);
    }

    // Điều kiện 2: Đằng sau nó có 9 số
    $checkNumber = false;
    if (isNumberInt($phone) && (strlen($phone) == 9)) {
        $checkNumber = true;
    }

    if ($checkZero && $checkNumber) {
        return true;
    }

    return false;
}
// Thông báo lỗi
function getSmg($smg, $type = 'success')
{
    echo '<div class= "alert alert-' . $type . '">';
    echo $smg;
    echo '</div>';
}
// Hàm chuyển hướng
function redirect($path = 'index.php')
{
    header("Location: $path");
    exit;
}

// Hàm thông báo lỗi
function form_error($fileName, $beforeHtml = '', $afterHtml = '', $errors)
{
    return (!empty($errors[$fileName])) ? '<span class="error">' . reset($errors[$fileName]) . '</span>' : null;
}


// Hàm hiển thị dữ liệu cũ
function old($fileName, $oldData, $default = null)
{
    return (!empty($oldData[$fileName])) ? $oldData[$fileName] : $default;
}


