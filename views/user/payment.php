<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thanh Toán</title>
  <link rel="stylesheet" href="../../templates/css/style_payment.css">
  <style>
    
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
              <th>Lựa chọn</th>
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
              <td>Mã đơn hàng:</td>
              <td>123456</td>
            </tr>
            <tr>
              <td>Tours</td>
              <td>€69.60</td>
            </tr>
            <tr class="tong">
              <td><strong>Tổng cộng</strong></td>
              <td><strong>€97.36</strong></td>
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
          $('#modalXacNhan').fadeIn();
        } else {
          alert('Vui lòng chọn phương thức thanh toán.');
        }
      });

      // Ẩn modal khi nhấn Hủy
      $('#cancelPayment').click(function() {
        $('#modalXacNhan').fadeOut();
      });

      // Xác nhận thanh toán
      $('#confirmPayment').click(function() {
        $('#modalXacNhan').fadeOut();
        alert('Thanh toán thành công!');
      });
    });
  </script>
</body>
</html>
