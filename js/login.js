import { isEmail, isEmpty } from "./config.js";

$(document).ready(function () {
  $(".btn-login").click(function (e) {
    e.preventDefault();
    handleLogin();
  });

  function handleValidLogin() {
    let isValid = true;

    $(".middle .form-group").each(function () {
      const inputField = $(this).find("input");
      console.log(inputField);
      const textareaField = $(this).find("textarea");
      const error = $(this).find(".error-message");

      if (inputField.length && !isEmpty(inputField.val(), error)) {
        isValid = false;
      } else if (inputField.attr("type") === "email" && !isEmail(inputField.val(), error)) {
        isValid = false;
      } else if (inputField.attr("name") === "phonenumber" && !isPhoneNumber(inputField.val(), error)) {
        isValid = false;
      }

      if (textareaField.length && !isEmpty(textareaField.val(), error)) {
        isValid = false;
      }
    });

    return isValid;
  }

  function handleLogin() {
    let isValid = handleValidLogin();

    if (isValid) {
      const userEmail = $("#useremail");
      const userPassword = $("#password");
      const errorEmailMessage = userEmail.closest(".form-group").find(".error-message");
      const errorPasswordMessage = userPassword.closest(".form-group").find(".error-message");

      $.ajax({
        type: "POST",
        url: "../includes/login.inc.php",
        data: { useremail: userEmail.val().trim(), password: userPassword.val().trim(), login: "login" },
        success: function (response) {
          if (response == "1") {
            window.location.href = "../admin/admin.php";
          } else if (response == "2") {
            window.location.href = "../templates/trangchu.php";
          } else if (response == "usernotfound") {
            $(errorEmailMessage).text("Tài khoản không tồn tại"); // Alert for account not found
          } else if (response == "wrongpassword") {
            $(errorPasswordMessage).text("Sai mật khẩu");
          }
        },
      });
    }
  }

  // ========================================== GET PASSWORD VIA EMAIL

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

        const submit_newpassword_btn = $("button[name='submit-newpassword']");
        if (submit_newpassword_btn.length > 0) {
          submit_newpassword_btn.click(function () {
            const user_email = sessionStorage.getItem("forgotEmail");

            const new_password = $("input[name='newpassword']").val();

            $.ajax({
              type: "POST",
              url: "../includes/forgetpassword.inc.php",
              data: {
                user_email: user_email,
                new_password: new_password,
              },
              success: function (response) {
                console.log(response);

                if (response == 1) {
                  alert("Update password successfully");
                  sessionStorage.removeItem("forgotEmail");
                  window.location.href = "../templates/login.php";
                } else {
                  alert("Update password failed");
                }
              },
            });
          });
        }
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
