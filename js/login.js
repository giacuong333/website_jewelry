$(document).ready(function () {
  $(".btn-login").click(function (e) {
    e.preventDefault();
    handleLogin();
  });

  function handleLogin() {
    const userEmail = $("#useremail").val().trim();
    const userPassword = $("#password").val().trim();
    const errorEmailMessage = $(".error-message")[0];
    const errorPasswordMessage = $(".error-message")[1];

    if (!isEmpty(userEmail, errorEmailMessage)) return;
    if (!isEmail(userEmail, errorEmailMessage)) return;
    if (!isEmpty(userPassword, errorPasswordMessage)) return;

    $.ajax({
      type: "POST",
      url: "../includes/login.inc.php",
      data: { useremail: userEmail, password: userPassword, login: "login" },
      success: function (response) {
        if (response == "1") {
          window.location.href = "../admin/admin.php";
        } else if (response == "2") {
          window.location.href = "../index.php";
        } else if (response == "usernotfound") {
          alert("Tài khoản không tồn tại"); // Alert for account not found
        } else if (response == "wrongpassword") {
          $(errorPasswordMessage).text("Sai mật khẩu");
        }
      },
    });
  }

  function isEmpty(checkElement, errorElement) {
    // Refresh the content
    $(errorElement).text("");

    if (checkElement === "" || checkElement === null) {
      $(errorElement).text("Vui lòng điền đầy đủ thông tin");
      return false;
    }

    return true;
  }

  function isEmail(email, errorElement) {
    // Refresh the content
    $(errorElement).text("");

    const emailRegex = /^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+[.][A-Za-z]{2,4}$/;
    if (!emailRegex.test(email)) {
      $(errorElement).text("Email không đúng định dạng");
      return false;
    }

    return true;
  }
});
