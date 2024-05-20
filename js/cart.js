$(document).ready(function () {
  // Move on to the payment page
  $("button[name='btn-placeorder']")
    .unbind("click")
    .click(() => (window.location.href = "../templates/payment.php"));

  $(".product-item .product-img, button[name='add_product_to_cart']")
    .off("click")
    .click(function () {
      let productid = null;
      if ($(this).hasClass("product-img")) {
        productid = $(this).closest(".product-item").data("productid");
      } else if ($(this).attr("name") === "add_product_to_cart") {
        productid = $(this).closest(".productdetail-item").data("productid");
      }

      if (productid) {
        handleAddProductToCart(productid);
        sideEffectOfCart();
      } else {
        console.log("Product ID not found.");
      }
    });

  $(".shoppingcart").unbind("click").click(sideEffectOfCart);

  // Format vnd currency
  function formatVndPrice(price) {
    return price.toLocaleString("it-IT", { style: "currency", currency: "VND" });
  }

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
          let totalOfProducts = 0;

          const indexOfNewProduct = productList.findIndex((product) => productId === product.id);
          const titleOfNewProduct = productList[indexOfNewProduct].title;

          const html = productList.map((product, index) => {
            const totalPriceOfproduct = Number(product.customer_quantity) * Number(product.price);
            totalOfOrder += totalPriceOfproduct;
            totalOfProducts += Number(product.customer_quantity);

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
              <td class="text-center product-price" data-productprice="${product.price}" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">${formatVndPrice(Number(product.price))}</td>
              <td class="text-center">
                <div>
                    <button type="button" class="minus">-</button>
                    <input type="number" name="quantity" disabled="disabled" style="min-width: 50px;" value="${product.customer_quantity}">
                    <button type="button" class="plus">+</button>
                </div>
                <div class="text-muted in-stock" style="font-size: 12px;" data-instock="${product.quantity}">
                      In stock: ${product.quantity}
                </div>
              </td>
              <td class="text-center total-price" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">${formatVndPrice(Number(totalPriceOfproduct))}</td>
            </tr>
            `;
          });

          // Side effect
          $("#popuppanel__header_title > span").text(`${titleOfNewProduct}`);
          $("#popuppanel__subheader_cart").text(`Giỏ hàng của bạn (${totalOfProducts}) sản phẩm`);
          $("#total_or_order").text(formatVndPrice(Number(totalOfOrder)));
          $(".quantity").text(`${totalOfProducts}`);

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
            changeQuantity(productObj, quantityInput.val(), quantityInput);
          });

          minusBtn.unbind("click").click(function (event) {
            event.preventDefault();
            const quantityInput = $(this).siblings("input[name='quantity']");
            const currentValue = Number(quantityInput.val()) || 1;
            quantityInput.val(currentValue - 1);
            updateTotalPrice($(this));

            const productObj = $(this).closest("tr");
            changeQuantity(productObj, quantityInput.val(), quantityInput);
          });

          quantityInput.on("input", function () {
            updateTotalPrice($(this));

            const productObj = $(this).closest("tr");
            changeQuantity(productObj, quantityInput.val(), quantityInput);
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
    const totalPrice = formatVndPrice(Number(pricePerUnit * quantity));

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

          let totalOfProducts = 0;

          const totalOfOrder = productList.reduce((total, product) => {
            totalOfProducts += Number(product.customer_quantity);
            return total + Number(product.price) * Number(product.customer_quantity);
          }, 0);

          // Side effect
          $("#popuppanel__subheader_cart").text(`Giỏ hàng của bạn (${totalOfProducts}) sản phẩm`);
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

  function changeQuantity(productObj, customer_quantity, maxQuantity) {
    const productId = productObj.data("productid");
    $.ajax({
      type: "POST",
      url: "../includes/cart.inc.php",
      data: { productId, customer_quantity, type: "changeQuantity" },
      success: function (response) {
        if (customer_quantity == 0) {
          productObj.remove();
        }
        let quantity = 0;
        const productList = Object.values(JSON.parse(response));
        const totalOfOrder = productList.reduce((total, product) => {
          quantity += Number(product.customer_quantity);
          return total + Number(product.price) * Number(product.customer_quantity);
        }, 0);

        // Side effect
        $("#popuppanel__subheader_cart").text(`Giỏ hàng của bạn (${customer_quantity}) sản phẩm`);
        $("#total_or_order").text(formatVndPrice(Number(totalOfOrder)));
        updateQuantityOfCart(quantity);
        if (quantity === 0) {
          handleCartEmpty(productList);
        }

        if (maxQuantity) {
          console.log(maxQuantity);
          const inputObj = $(maxQuantity).closest("td").find(".in-stock");
          if (inputObj) {
            const maxQuantityValue = Number(inputObj.data("instock"));
            if (maxQuantity.val() >= maxQuantityValue) {
              maxQuantity.val(maxQuantityValue);
              maxQuantity.siblings(".plus").attr("disabled", "disabled");
            } else {
              maxQuantity.siblings(".plus").removeAttr("disabled");
            }
          } else {
            console.log("Element not found");
          }
        }
      },
    });
  }

  function handleCartEmpty(productList) {
    $(".product_in_cart").html("<td colspan='4'>Không có sản phẩm nào trong giỏ hàng. Quay lại<a href='../templates/SanPham.php' style='color: #7fcbc9'>cửa hàng</a>để tiếp tục mua sắm.</td>");
  }

  function updateQuantityOfCart(quantity) {
    $(".quantity").text(quantity);
    $("#popuppanel__subheader_cart").text(`Giỏ hàng của bạn (${quantity}) sản phẩm`);
  }

  // See the products in the cart
  $(".shoppingcart")
    .unbind("click")
    .click(function () {
      sideEffectOfCart();
      seeCart();
    });

  function seeCart() {
    $.ajax({
      type: "GET",
      data: {},
      url: "../includes/seeProductInCart.inc.php",
      success: function (response) {
        if (response !== "none") {
          const productList = Object.values(JSON.parse(response));
          console.log(productList);
          const productInCartObj = $(".product_in_cart");

          if (productList) {
            let totalOfOrder = 0;
            let totalOfProducts = 0;

            const html = productList
              .map((product, index) => {
                const totalPriceOfproduct = Number(product.customer_quantity) * Number(product.price);
                totalOfOrder += totalPriceOfproduct;
                totalOfProducts += Number(product.customer_quantity);

                return `
                <tr data-productid=${product.id} data-productindex="${index}">
                  <td class="d-flex align-items-start">
                      <img src="${product.thumbnail}" alt="" class="img-responsive border" style="width: 80px">
                      <div class="d-inline-flex flex-column justify-content-start align-items-start ms-2">
                          <span style="font-size: 14px; font-weight: 600; color: #7fcbc9;" class="mb-2">${product.title}</span>
                          <span style="font-size: 12px; font-weight: 500; color: #aaa; cursor: pointer" class="remove-product"><i class="fa-solid fa-close me-1 mb-2" style="font-weight: 900; font-size: 14px"></i>Bỏ sản phẩm</span>
                      </div>
                  </td>
                  <td class="text-center product-price" data-productprice="${product.price}" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">${formatVndPrice(Number(product.price))}</td>
                  <td class="text-center">
                    <div>
                        <button type="button" class="minus">-</button>
                        <input type="number" name="quantity" disabled="disabled" style="min-width: 50px;" value="${product.customer_quantity}">
                        <button type="button" class="plus">+</button>
                    </div>
                    <div class="text-muted in-stock" style="font-size: 12px;" data-instock="${product.quantity}">
                      In stock: ${product.quantity}
                    </div>
                  </td>
                  <td class="text-center total-price" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">${formatVndPrice(Number(totalPriceOfproduct))}</td>
                </tr>
            `;
              })
              .join("");

            // Side effect
            $("#popuppanel__subheader_cart").text(`Giỏ hàng của bạn (${totalOfProducts}) sản phẩm`);
            $("#total_or_order").text(formatVndPrice(Number(totalOfOrder)));
            $(".quantity").text(`${totalOfProducts}`);

            productInCartObj.html(html);

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
              changeQuantity(productObj, quantityInput.val(), quantityInput);
            });

            minusBtn.unbind("click").click(function (event) {
              event.preventDefault();
              const quantityInput = $(this).siblings("input[name='quantity']");
              const currentValue = Number(quantityInput.val()) || 1;
              quantityInput.val(currentValue - 1);
              updateTotalPrice($(this));

              const productObj = $(this).closest("tr");
              changeQuantity(productObj, quantityInput.val(), quantityInput);
            });

            quantityInput.on("input", function () {
              updateTotalPrice($(this));

              const productObj = $(this).closest("tr");
              changeQuantity(productObj, quantityInput.val(), quantityInput);
            });

            // remove product from the cart
            productInCartObj.off("click", ".remove-product").on("click", ".remove-product", function () {
              const productObj = $(this).closest("tr");
              handleRemoveProduct(productObj);
            });
          }
        }
      },
    });
  }
});
