$(document).ready(function () {
  function formatVndPrice(price) {
    return price.toLocaleString("it-IT", { style: "currency", currency: "VND" });
  }

  const productPriceObj = $(".pro-price");
  const vndPrice = formatVndPrice(Number(productPriceObj.text()));
  productPriceObj.text(vndPrice);
});
