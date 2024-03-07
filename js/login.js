import { isEmail, isEmpty } from "./config.js";

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
        alert(response);
        if (response == "1") {
          window.location.href = "../admin/admin.php";
        } else if (response == "2") {
          window.location.href = "../index.php";
        } else if (response == "usernotfound") {
          $(errorEmailMessage).text("Tài khoản không tồn tại"); // Alert for account not found
        } else if (response == "wrongpassword") {
          $(errorPasswordMessage).text("Sai mật khẩu");
        }
      },
    });
  }
});
