$(document).ready(function () {
  $(".product-item")
    .unbind("click")
    .click(function () {
      const productid = $(this).data("productid");
      sideEffectOfCart();
    });

  function sideEffectOfCart() {
    const popupcartObj = $(".popupcart");
    const popupcartOverlayObj = $(".overlay");

    popupcartObj.removeClass("d-none").addClass("d-block");
    popupcartOverlayObj.removeClass("d-none").addClass("d-block");

    $(".overlay, .popupcart_close")
      .unbind("click")
      .click(() => {
        popupcartObj.removeClass("d-block").addClass("d-none");
        popupcartOverlayObj.removeClass("d-block").addClass("d-none");
      });
  }

  // Set value for quantity
  const plusBtn = $("button.plus");
  const minusBtn = $("button.minus");

  plusBtn.unbind("click").click(function (event) {
    event.preventDefault();
    const quantityInput = $(this).siblings("input[name='quantity']");
    const currentValue = Number(quantityInput.val()) || 1;
    quantityInput.val(currentValue + 1);
  });

  minusBtn.unbind("click").click(function (event) {
    event.preventDefault();
    const quantityInput = $(this).siblings("input[name='quantity']");
    const currentValue = Number(quantityInput.val()) || 1;
    quantityInput.val(currentValue - 1);
  });
});
