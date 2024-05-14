import { isEmpty, isEmail, isPhoneNumber } from "./config.js";

$(document).ready(function () {
  function handleSubmitFeedback(event) {
    let isValid = true;

    // Check input fields before placing order
    $(".form-group").each(function () {
      const inputField = $(this).find("input");
      const error = $(this).find(".error-message");

      if (inputField.length && !isEmpty(inputField.val(), error)) {
        isValid = false;
      } else if (inputField.attr("type") === "email" && !isEmail(inputField.val(), error)) {
        isValid = false;
      } else if (inputField.attr("name") === "phonenumber" && !isPhoneNumber(inputField.val(), error)) {
        isValid = false;
      }
    });

    if (isValid) {
      $(event.target).attr("type", "submit").trigger("click");
    }
  }

  // Bind input event listeners outside the loop
  $(".form-group input, .form-group textarea").on("input", function () {
    $(this).siblings(".error-message").text("");
  });

  // Handle events
  $("button[name='place-order']")
    .unbind("click")
    .click((event) => {
      const userId = $("input[name='userid']").data("userid");

      if (userId !== "none") {
        handleSubmitFeedback(event);
      } else {
        alert("Log in to place the order");
      }
    });

  $("#homepage")
    .unbind("click")
    .click(() => (window.location.href = "../templates/trangchu.php"));
});
