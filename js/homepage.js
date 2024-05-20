$(document).ready(function () {
  function formatVndPrice(price) {
    return price.toLocaleString("it-IT", { style: "currency", currency: "VND" });
  }

  function handleRenderHotDeals() {
    $.ajax({
      type: "GET",
      url: "../server/models/gethotdeal.s.php",
      success: function (response) {
        const hotDealList = JSON.parse(response);
        const lengthOfHotDealList = hotDealList.length;

        const hotDealObj = $(".hot-deal-prd");

        const numberDisplay = 4;
        let currentIndex = 0;

        function renderDeals() {
          const html = hotDealList
            .map((item) => {
              const vndPrice = formatVndPrice(item.price);

              return `
                    <div class="product col-lg-md-3 col-md-3 text-center">
                          <div class="product-img w-100">
                                <a href="../templates/productdetails.php?data-productid=${item.id}">
                                      <img class='img-responsive w-100' style='object-fit:cover; object-position:center;' src="${item.thumbnail}" alt="product image">
                                </a>
                          </div>
                          <div class="product-name">
                                <p class="big"><a href="../templates/productdetails.php?data-productid=${item.id}">${item.title}</a></p>
                          </div>
                          <div class="product-price">${vndPrice}</div>
                    </div>
                    `;
            })
            .join("");

          hotDealObj.html(html);
          refreshDisplay();
        }

        function refreshDisplay() {
          const productHotDealObj = $(".hot-deal-prd > .product");
          productHotDealObj.hide();
          for (let i = currentIndex; i < Math.min(currentIndex + numberDisplay, lengthOfHotDealList); i++) {
            productHotDealObj.eq(i).show();
          }
        }

        function pressNext() {
          if (currentIndex + numberDisplay < lengthOfHotDealList) {
            currentIndex += 1;
            refreshDisplay();
          }
        }

        function pressPrev() {
          if (currentIndex > 0) {
            currentIndex -= 1;
            refreshDisplay();
          }
        }

        $("button.next").click(pressNext);
        $("button.prev").click(pressPrev);

        // Render first
        renderDeals();
      },
      error: function (error) {
        console.error("Error fetching hot deals:", error);
      },
    });
  }

  function handleRenderNew() {
    $.ajax({
      type: "GET",
      url: "../server/models/getnew.s.php",
      success: function (response) {
        const newProductListObj = $(".new-products > .range-product");
        const newProductList = JSON.parse(response);

        const html = newProductList
          .map((item) => {
            const vndPrice = formatVndPrice(item.price);

            return `
                  <div class="cell-product">
                        <div class="unit">
                              <div class="unit-left d-inline-block">
                                    <a href=""><img style="width:100px; height:100px;" src="${item.thumbnail}" alt=""></a>
                              </div>
                              <div class="unit-body text-start me-auto d-inline-flex flex-column justify-content-center align-items-start">
                                    <div class="p"><a href="#">${item.name}</a></div>
                                    <div class="w-100"><a href="../templates/productdetails.php?data-productid=${item.product_id}" class="text-base d-block">${item.title}</a></div>
                                    <div class="product-price" style="font-size:20px;">${vndPrice}</div>
                              </div>
                        </div>
                  </div>
                  `;
          })
          .join("");

        newProductListObj.html(html);
      },
    });
  }

  function handleRenderOutStanding() {
    $.ajax({
      type: "GET",
      url: "../server/models/getoutstanding.s.php",
      success: function (response) {
        const outstandingProductListObj = $(".outstanding-products > .range-product");
        const outstandingProductList = JSON.parse(response);

        console.log(outstandingProductList);

        const html = outstandingProductList
          .map((item) => {
            const vndPrice = formatVndPrice(item.price);

            return `
                  <div class="cell-product">
                        <div class="unit">
                              <div class="unit-left d-inline-block">
                                    <a href=""><img style="width:100px; height:100px;" src="${item.thumbnail}" alt=""></a>
                              </div>
                              <div class="unit-body text-start me-auto d-inline-flex flex-column justify-content-center align-items-start">
                                    <div class="p">
                                          <a href="#">${item.name}</a>
                                    </div>
                                    <div class="w-100">
                                          <a 
                                                href="../templates/productdetails.php?data-productid=${item.product_id}" 
                                                class="text-base d-block" 
                                          >
                                                ${item.title}
                                          </a>
                                    </div>
                                    <div class="product-price" style="font-size:20px;">${vndPrice}</div>
                              </div>
                        </div>
                  </div>
                  `;
          })
          .join("");

        outstandingProductListObj.html(html);
      },
    });
  }

  function handleRenderBestSellers() {
    $.ajax({
      type: "GET",
      url: "../server/models/getbestsellers.s.php",
      success: function (response) {
        const bestSellersObj = $(".bestsellers > .range-product");
        const bestSellersList = JSON.parse(response);

        console.log(bestSellersList);

        const html = bestSellersList
          .map((item) => {
            const vndPrice = formatVndPrice(item.price);

            return `
                        <div class="cell-product">
                              <div class="unit">
                                    <div class="unit-left d-inline-block">
                                          <a href=""><img style="width:100px; height:100px;" src="${item.thumbnail}" alt=""></a>
                                    </div>
                                    <div class="unit-body text-start me-auto d-inline-flex flex-column justify-content-center align-items-start">
                                          <div class="p">
                                                <a href="#">${item.name}</a>
                                          </div>
                                          <div class="w-100">
                                                <a 
                                                      href="../templates/productdetails.php?data-productid=${item.product_id}" 
                                                      class="text-base d-block" 
                                                >
                                                      ${item.title}
                                                </a>
                                          </div>
                                          <div class="product-price" style="font-size:20px;">${vndPrice}</div>
                                    </div>
                              </div>
                        </div>
                  `;
          })
          .join("");

        bestSellersObj.html(html);
      },
    });
  }

  // Events
  handleRenderHotDeals();
  handleRenderNew();
  handleRenderOutStanding();
  handleRenderBestSellers();
});
