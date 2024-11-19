<?php
// Giả sử bạn đã có các file cần thiết như config.php, connect.php, session.php, v.v.
include '../../config.php';
include '../../includes/connect.php';
include '../../includes/session.php';

// Hàm filter() giả sử lọc dữ liệu từ URL hoặc form
function filter() {
    return $_GET; // Hoặc bạn có thể thay bằng $_POST tùy thuộc vào phương thức gửi dữ liệu
}

// Hàm redirect() để chuyển hướng người dùng
function redirect($url) {
    header("Location: $url");
    exit();
}

// Kiểm tra và lấy dữ liệu thanh toán
$filterAll = filter();
if (!empty($filterAll['id_order'])) {
    $paymentID = $filterAll['id_order']; // Lấy id_order từ dữ liệu lọc
    $paymentDetail = oneRaw("SELECT * FROM orders WHERE id_order='$paymentID'"); // Truy vấn thông tin thanh toán

    if (!empty($paymentDetail)) {
        // Lấy thông tin từ bảng tours và users
        $tourID = $paymentDetail['id_tours'];
        $userID = $paymentDetail['id_user'];

        // Truy vấn bảng tours để lấy tên tour
        $tourDetail = oneRaw("SELECT name FROM tours WHERE id_tours='$tourID'");

        // Truy vấn bảng users để lấy tên người dùng (username)
        $userDetail = oneRaw("SELECT username FROM user WHERE id_user='$userID'");

        // Lưu thông tin vào biến $old
        $old = $paymentDetail;
        $old['name'] = $tourDetail['name']; // Thêm tên tour vào thông tin đơn hàng
        $old['username'] = $userDetail['username']; // Thêm tên người dùng vào thông tin đơn hàng
    } else {
        // Nếu không tìm thấy đơn hàng, chuyển hướng về trang danh sách đơn hàng
        redirect("?page=cart");
    }
} else {
    // Nếu không có id_order trong URL, chuyển hướng về trang danh sách đơn hàng
    redirect("?page=cart");
}

// Hàm oneRaw() giả sử trả về một dòng dữ liệu
function oneRaw($query) {
    global $conn1; // Sử dụng kết nối cơ sở dữ liệu toàn cục
    $result = $conn1->query($query);
    return $result->fetch_assoc(); // Trả về mảng kết quả
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thanh Toán</title>
  <link rel="stylesheet" href="../../templates/css/style_payment.css">
  <style>
    /* Bạn có thể thêm CSS tại đây nếu cần */
  </style>
  <!-- Thêm thư viện jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
  <div class="trang-thanh-toan">
    <div class="thanh-toan">
      <!-- Bảng phương thức thanh toán -->
      <div class="lua-chon-thanh-toan">
        <table>
          <thead>
            <tr>
              <th>Phương thức thanh toán</th>
              <th>&ensp;&ensp;&ensp;&ensp;&ensp;</th>
              <th>&ensp;</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="phuong-thuc-thanh-toan">
                  <img src="../../templates/image/payment/momo.png" alt="Momo">
                  <span>Momo</span>
                </div>
              </td>
              <td><input type="radio" name="phuong-thuc" value="Momo"></td>
            </tr>
            <tr>
              <td>
                <div class="phuong-thuc-thanh-toan">
                  <img src="../../templates/image/payment/zalo.png" alt="ZaloPay">
                  <span>ZaloPay</span>
                </div>
              </td>
              <td><input type="radio" name="phuong-thuc" value="ZaloPay"></td>
            </tr>
            <tr>
              <td>
                <div class="phuong-thuc-thanh-toan">
                  <img src="../../templates/image/payment/shopee.png" alt="Shopee">
                  <span>Shopee</span>
                </div>
              </td>
              <td><input type="radio" name="phuong-thuc" value="Shopee"></td>
            </tr>
            <tr>
              <td>
                <div class="phuong-thuc-thanh-toan">
                  <img src="../../templates/image/payment/viettin.png" alt="vietin">
                  <span>VietinBank</span>
                </div>
              </td>
              <td><input type="radio" name="phuong-thuc" value="vietin"></td>
            </tr>
            <tr>
              <td>
                <div class="phuong-thuc-thanh-toan">
                  <img src="../../templates/image/payment/paypal.png" alt="vietinpaypal">
                  <span>Paypal</span>
                </div>
              </td>
              <td><input type="radio" name="phuong-thuc" value="paypal"></td>
            </tr>
            <tr>
              <td>
                <div class="phuong-thuc-thanh-toan">
                  <img src="../../templates/image/payment/visa.png" alt="Visa">
                  <span>Visa</span>
                </div>
              </td>
              <td><input type="radio" name="phuong-thuc" value="Visa"></td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Bảng tóm tắt đơn hàng -->
      <div class="tom-tat-don-hang">
        <table>
          <thead>
            <tr>
              <th colspan="2">Tóm tắt đơn hàng</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>&ensp;Mã đơn hàng:</td>
              <td><?= $old['id_tours'] ?></td> <!-- Hiển thị mã đơn hàng -->
            </tr>
            <tr>
              <td>&ensp;Tên đơn hàng:</td>
              <td><?= $old['name'] ?></td> <!-- Hiển thị tên tour -->
            </tr>
            <tr>
              <td>&ensp;Tên người đặt:</td>
              <td><?= $old['username'] ?></td> <!-- Hiển thị tên người dùng -->
            </tr>
            <tr class="tong">
              <td><strong>&ensp;Tổng cộng:</strong></td>
              <td><?= $old['thanh_tien'] ?></td> <!-- Hiển thị tổng tiền -->
            </tr>
          </tbody>
        </table>
        <div>
          <button class="nut-thanh-toan" id="payButton">Thanh toán</button>
          <button class="huy-thanh-toan">Thoát</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal xác nhận thanh toán -->
  <div id="modalXacNhan" class="modal">
    <div class="modal-content">
      <p>Bạn có chắc chắn muốn thanh toán?</p>
      <button class="btn-confirm" id="confirmPayment">Xác nhận</button>
      <button class="btn-cancel" id="cancelPayment">Hủy</button>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Hiện modal khi nhấn nút Thanh toán
      $('#payButton').click(function() {
        if ($('input[name="phuong-thuc"]:checked').length > 0) {
          $('#modalXacNhan').show(); // Sử dụng show() để hiển thị modal
        } else {
          alert('Vui lòng chọn phương thức thanh toán.');
        }
      });

      // Ẩn modal khi nhấn Hủy
      $('#cancelPayment').click(function() {
        $('#modalXacNhan').hide(); // Sử dụng hide() để ẩn modal
      });

      // Xác nhận thanh toán
      $('#confirmPayment').click(function() {
        $('#modalXacNhan').hide(); // Sử dụng hide() để ẩn modal
        alert('Thanh toán thành công!');
      });
      // Khi nhấn nút "Thoát"
      $('.huy-thanh-toan').click(function() {
        // Chuyển hướng về trang index
        window.location.href = "http://localhost/TravelToursWeb/";  // Thay đổi đường dẫn theo vị trí của trang index
      });
    });
  </script>

</body>
</html>
