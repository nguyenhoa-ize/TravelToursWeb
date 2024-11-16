<script>
  $(document).ready(function() {
    $('#home-link').on('click', function(event) {
      event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
      window.location.href = '/TravelToursWeb/index.php'; // Chuyển hướng đến index.php
    })
  });
</script>