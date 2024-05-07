$(document).ready(function () {
  function handleScroll() {
    if (window.matchMedia("(min-width: 767px)").matches) {
      const menuItemListObj = $(".list-items");
      const headerNavbarObj = $(".main-header");

      menuItemListObj.removeClass("shadow-sm").removeClass("fixed-top");

      if ($(window).scrollTop() > headerNavbarObj.height()) {
        menuItemListObj.addClass("shadow-sm").addClass("fixed-top");
      }
    }
  }

  function handleDropdownChild() {
    const dropdownChild = $(".child-list-items").closest(".dropdown");
    console.log(dropdownChild);
    dropdownChild.removeClass("dropend");
    if (window.matchMedia("(max-width: 767px)").matches) {
      dropdownChild.addClass("dropend");
    }
  }

  $(window).scroll(handleScroll);
  $(window).resize(handleDropdownChild);
});
