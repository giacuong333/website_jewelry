$(document).ready(function () {
  const menuItemListObj = $(".list-items");
  const headerNavbarObj = $(".main-header");

  $(window).scroll(function () {
    menuItemListObj.removeClass("shadow-sm").removeClass("position-fixed").removeClass("top-0").removeClass("start-0").removeClass("end-0");

    if ($(window).scrollTop() > headerNavbarObj.height()) {
      menuItemListObj.addClass("shadow-sm").addClass("position-fixed").addClass("top-0").addClass("start-0").addClass("end-0");
    }
  });
});
