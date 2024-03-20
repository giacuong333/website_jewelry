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

  // Sent pass code to email
  $("button[name='getformerpassword']").click(function (e) {
    const forgot_email = $("#forgotuseremail").val();

    sessionStorage.setItem("forgotEmail", forgot_email);

    $("#forgotPasswordForm").submit(); // Submit the form
  });

  // Confirm pass code
  $("button[name='confirmpasscode']").click(function () {
    const pass_code = $("input[name='reset_token']").val();
    const forgot_email = sessionStorage.getItem("forgotEmail");
    const confirm_btn = $(this);

    $.ajax({
      type: "POST",
      url: "../includes/forgetpassword.inc.php",
      data: {
        pass_code: pass_code,
        forgot_email: forgot_email,
      },
      success: function (response) {
        const errorElement = confirm_btn.closest(".form-group").find(".error-message");
        if (response == "codeexpired") {
          errorElement.text("Code đã hết hạn");
        } else if (response == "codedoesnotexist") {
          errorElement.text("Code không hợp lệ");
        } else {
          $("#login-main").prepend(response);
        }

        turnOffOverlay();
      },
    });
  });

  function turnOffOverlay() {
    $(".overlay").click(function () {
      $(this).remove();
      $(".change-password-container").remove();
    });
  }
});
