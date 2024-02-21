$(document).ready(function () {
  const logoutBtn = $(".sidebar-menu");

  logoutBtn.click(function (e) {
    e.preventDefault();
    window.location.href = "../includes/logout.inc.php";
  });
});
