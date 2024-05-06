import { isEmpty, isCorrectVerifyPassword } from "./config.js";

$(document).ready(function () {
  // Handle events
  const btnGroup = $(".btns-group > .btn");
  const customerinfoContent = $(".customerinfo-content > div");

  btnGroup.each(function () {
    $(this)
      .unbind("click")
      .click(() => {
        // Side effects
        btnGroup.removeClass("active");
        $(this).addClass("active");

        const elementOfLink = $(`.${Object.keys($(this).data())[0]}`);
        // Refresh
        customerinfoContent.removeClass("d-block").addClass("d-none");
        // Show the current page
        elementOfLink.removeClass("d-none").addClass("d-block");
      });
  });

  function isValidChangePwd() {
    const changePwdForm = $(".customerinfo__changepwd > .form-group");
    let isValid = true;

    if (changePwdForm) {
      changePwdForm.each(function () {
        const inputField = $(this).find("input");
        const error = $(this).find(".error-message");

        if (inputField.length && !isEmpty(inputField.val(), error)) {
          isValid = false;
        }

        inputField.on("input", () => error.text(""));
      });
    }

    return isValid;
  }

  function handleResetPwd() {
    let isValid = isValidChangePwd();
    let correctPwd = true;

    const oldPwd = $("#oldpwd");
    const oldPwdError = oldPwd.closest(".form-group").find(".error-message");
    const newPwd = $("#newpwd");
    const verifypwd = $("#verifypwd");
    const verifypwdError = verifypwd.closest(".form-group").find(".error-message");

    if (isValid) {
      if (!isCorrectVerifyPassword(newPwd.val(), verifypwd.val(), verifypwdError)) {
        correctPwd = false;
      }
    }

    if (isValid && correctPwd) {
      $.ajax({
        type: "post",
        url: "../includes/changepwd.inc.php",
        data: { oldPwd: oldPwd.val(), newPwd: newPwd.val(), type: "changepwd" },
        success: function (response) {
          if (response) {
            alert("Đổi mật khẩu thành công");
            window.location.reload();
          } else {
            oldPwdError.text("Mật khẩu cũ không đúng");
          }
        },
      });
    }
  }

  $(".resetpwd-btn").unbind("click").click(handleResetPwd);
});
