import { isEmail, isEmpty, isPhoneNumber } from "./config.js";

$(document).ready(function () {
  function handleSubmitFeedback(e) {
    let isValid = true;

    $(".form-group").each(function () {
      const inputField = $(this).find("input");
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

    if (isValid) {
      // Directly submit the form
      $(e.target).attr("type", "submit").trigger("click");
    }
  }

  // Bind input event listeners outside the loop
  $(".form-group input, .form-group textarea").on("input", function () {
    $(this).siblings(".error-message").text("");
  });

  // Handle events
  $("button[name='submit_feedback']").unbind("click").click(handleSubmitFeedback);
});
