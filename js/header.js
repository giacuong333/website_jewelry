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

  function renderCategoryList() {
    $.ajax({
      type: "GET",
      url: "../server/models/getcategory.s.php",
      success: function (response) {
        const categoryList = JSON.parse(response);
        const categoryListObj = $("ul.child-list-items");

        const html = categoryList
          .map((item) => {
            return `
            <li class="child-item dropdown-item" data-categoryid='${item.id}'>
              <a href="../templates/SanPham.php?category_id=${item.id}">${item.name}</a>
            </li>
          `;
          })
          .join("");

        categoryListObj.html(html);
      },
    });
  }

  // Events
  $(window).scroll(handleScroll);
  $(window).resize(handleDropdownChild);
  $("li.item.dropdown")
    .unbind("click")
    .click(() => (window.location.href = "../templates/SanPham.php"));
  $(window).onload = renderCategoryList();
});
