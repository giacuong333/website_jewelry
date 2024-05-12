$(document).ready(function () {
  $(".product-item")
    .unbind("click")
    .click(function () {
      const productid = $(this).data("productid");

      handleAddProductToCart(productid);
      sideEffectOfCart();
    });

  function handleAddProductToCart(productId) {
    $.ajax({
      type: "POST",
      url: "../includes/cart.inc.php",
      data: { productId, type: "addToCart" },
      success: function (response) {
        if (response) {
          // const productList = JSON.parse(response);
          const productList = Object.values(JSON.parse(response));
          const productInCartObj = $(".product_in_cart");
          let totalOfOrder = 0;

          const indexOfNewProduct = productList.findIndex((product) => productId === product.id);
          const titleOfNewProduct = productList[indexOfNewProduct].title;

          const html = productList.map((product, index) => {
            const totalPriceOfproduct = Number(product.customer_quantity) * Number(product.price);
            totalOfOrder += totalPriceOfproduct;

            return `
            <tr data-productid=${product.id} data-productindex="${index}">
              <td class="d-flex align-items-start">
                  <img src="${product.thumbnail}" alt="" class="img-responsive border" style="width: 80px">
                  <div class="d-inline-flex flex-column justify-content-start align-items-start ms-2">
                      <span style="font-size: 14px; font-weight: 600; color: #7fcbc9;" class="mb-2">${product.title}</span>
                      <span style="font-size: 12px; font-weight: 500; color: #aaa; cursor: pointer" class="remove-product"><i class="fa-solid fa-close me-1 mb-2" style="font-weight: 900; font-size: 14px"></i>Bỏ sản phẩm</span>
                      ${
                        productId === product.id
                          ? `
                      <span style=" color: #898989; font-size: 14px">
                        <i class="fa-solid fa-check me-1" style="color: #7fcbc9; font-weight: 900; font-size: 14px"></i>Sản phẩm vừa thêm!
                      </span>`
                          : ""
                      }
                  </div>
              </td>
              <td class="text-center product-price" data-productprice="${product.price}" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">${product.price}</td>
              <td class="text-center">
                <div>
                    <button type="button" class="minus">-</button>
                    <input type="number" name="quantity" value="${product.customer_quantity}">
                    <button type="button" class="plus">+</button>
                </div>
              </td>
              <td class="text-center total-price" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">${totalPriceOfproduct}</td>
            </tr>
            `;
          });

          // Side effect
          $("#popuppanel__header_title > span").text(`${titleOfNewProduct}`);
          $("#popuppanel__subheader_cart").text(`Giỏ hàng của bạn (${productList.length}) sản phẩm`);
          $("#total_or_order").text(totalOfOrder);

          productInCartObj.html(html.join(""));

          // Set value for quantity
          const plusBtn = $("button.plus");
          const minusBtn = $("button.minus");
          const quantityInput = $("input[name='quantity']");

          plusBtn.unbind("click").click(function (event) {
            event.preventDefault();
            const quantityInput = $(this).siblings("input[name='quantity']");
            const currentValue = Number(quantityInput.val()) || 1;
            quantityInput.val(currentValue + 1);
            updateTotalPrice($(this));

            const productObj = $(this).closest("tr");
            changeQuantity(productObj, quantityInput.val());
          });

          minusBtn.unbind("click").click(function (event) {
            event.preventDefault();
            const quantityInput = $(this).siblings("input[name='quantity']");
            const currentValue = Number(quantityInput.val()) || 1;
            quantityInput.val(currentValue - 1);
            updateTotalPrice($(this));

            const productObj = $(this).closest("tr");
            changeQuantity(productObj, quantityInput.val());
          });

          quantityInput.on("input", function () {
            updateTotalPrice($(this));

            const productObj = $(this).closest("tr");
            changeQuantity(productObj, quantityInput.val());
          });

          // remove product from the cart
          productInCartObj.off("click", ".remove-product").on("click", ".remove-product", function () {
            const productObj = $(this).closest("tr");
            handleRemoveProduct(productObj);
          });
        }
      },
    });
  }

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

  function updateTotalPrice(button) {
    const totalPriceCell = button.closest("tr").find(".total-price");
    const pricePerUnit = Number(button.closest("tr").find(".product-price").data("productprice"));
    if (button.attr("type") === "number") {
      var quantityInput = button;
    } else {
      var quantityInput = button.siblings("input[name='quantity']");
    }
    const quantity = Number(quantityInput.val() || 1);
    const totalPrice = pricePerUnit * quantity;

    totalPriceCell.text(totalPrice);
  }

  function handleRemoveProduct(productObj) {
    const productId = productObj.data("productid");
    $.ajax({
      type: "POST",
      url: "../includes/cart.inc.php",
      data: { productId, type: "removeFromCart" },
      success: function (response) {
        if (response !== "0") {
          const productList = Object.values(JSON.parse(response));
          productObj.remove(); // remove the product from the cart UI

          const totalOfOrder = productList.reduce((total, product) => {
            return total + Number(product.price) * Number(product.customer_quantity);
          }, 0);

          // Side effect
          $("#popuppanel__subheader_cart").text(`Giỏ hàng của bạn (${productList.length}) sản phẩm`);
          $("#total_or_order").text(totalOfOrder);
        } else if (response === "0") {
          alert("Failed");
        }
      },
      error: function (error) {
        alert("Error occured while removing the product");
      },
    });
  }

  function changeQuantity(productObj, customer_quantity) {
    const productId = productObj.data("productid");
    $.ajax({
      type: "POST",
      url: "../includes/cart.inc.php",
      data: { productId, customer_quantity, type: "changeQuantity" },
      success: function (response) {
        if (customer_quantity == 0) {
          productObj.remove();
        }
        const productList = Object.values(JSON.parse(response));
        const totalOfOrder = productList.reduce((total, product) => {
          return total + Number(product.price) * Number(product.customer_quantity);
        }, 0);

        // Side effect
        $("#popuppanel__subheader_cart").text(`Giỏ hàng của bạn (${productList.length}) sản phẩm`);
        $("#total_or_order").text(totalOfOrder);
      },
    });
  }
});
