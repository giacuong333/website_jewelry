// Khi người dùng click vào liên kết "Trang chủ" trong breadcrumb
document.querySelectorAll('.breadcrumb-item')[0].addEventListener('click', function(e) {
    e.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
    window.location.href = '/'; // Chuyển hướng về trang chủ
  });
  