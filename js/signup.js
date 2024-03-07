import { isEmail, isEmpty, isPhoneNumber, isCorrectVerifyPassword } from "./config.js";

$(document).ready(function () {
  $(".btn-signup").click(function (e) {
    e.preventDefault();
    handleSignup();
  });

  function handleSignup() {
    const fullname = $("#fullname").val().trim();
    const email = $("#email").val().trim();
    const phone_number = $("#phone_number").val().trim();
    const password = $("#password").val().trim();
    const verify_password = $("#verifyPass").val().trim();

    const errorFullNameMessage = $(".error-message")[0];
    const errorEmailMessage = $(".error-message")[1];
    const errorPhoneNumberMessage = $(".error-message")[2];
    const errorPasswordMessage = $(".error-message")[3];
    const errorVerifyPasswordMessage = $(".error-message")[4];

    if (!isEmpty(fullname, errorFullNameMessage)) return;
    if (!isEmpty(email, errorEmailMessage)) return;
    if (!isEmpty(phone_number, errorPhoneNumberMessage)) return;
    if (!isEmpty(password, errorPasswordMessage)) return;
    if (!isEmpty(verify_password, errorVerifyPasswordMessage)) return;
    if (!isEmail(email, errorEmailMessage)) return;
    if (!isPhoneNumber(phone_number, errorPhoneNumberMessage)) return;
    if (!isCorrectVerifyPassword(password, verify_password, errorVerifyPasswordMessage)) return;

    $.ajax({
      type: "POST",
      url: "../includes/signup.inc.php",
      data: { fullname: fullname, email: email, phone_number: phone_number, password: password, signup: "signup" },
      success: function (response) {
        const responseJson = JSON.parse(response);
        if (responseJson.error === "emailtaken") {
          $(errorEmailMessage).text("Email đã đăng ký");
        } else if (responseJson.error === "phonenumbertaken") {
          $(errorPhoneNumberMessage).text("Số điện thoại đã đăng ký");
        } else if (responseJson.success === "success") {
          alert("Đăng ký tài khoản thành công");
          window.location.href = "../templates/login.php";
        }
      },
      error: function () {
        alert("Đã có lỗi xảy ra, vui lòng thử lại sau.");
      },
    });
  }
});
