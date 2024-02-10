$(document).ready(function () {
  // ========================================================== SIDE BAR MENU ==========================================================
  let sidebarMenu = $(".sidebar-menu");

  sidebarMenu.each(function (menuIndex) {
    $(this).click((e) => {
      e.preventDefault();
      sidebarMenu.removeClass("is-selected"); // Remove the class from all menu items
      $(this).addClass("is-selected");
      move(menuIndex);
    });
  });

  function move(index) {
    switch (index) {
      case 0:
        window.location.href = "../admin/categorymanager.php";
        break;
      case 1:
        window.location.href = "../admin/usermanager.php";
        break;
      case 2:
        window.location.href = "../admin/productmanager.php";
        break;
      case 3:
        window.location.href = "../admin/statisticmanager.php";
        break;
      case 4:
        window.location.href = "../admin/contactmanager.php";
        break;
      case 5:
        window.location.href = "../admin/ordermanager.php";
        break;
      case 6:
        window.location.href = "../admin/authorizemanager.php";
        break;
      case 7:
        window.location.href = "../admin/othermanager.php";
        break;
      case 8:
        window.location.href = "../includes/logout.inc.php";
        break;
    }
  }

  // ========================================================== COMMON ==========================================================

  // Move on to another page
  function moveOn(element, url) {
    if (element) {
      $(element).click((e) => {
        // e.preventDefault();
        window.location.href = url;
      });
    }
  }

  // Search function for keypress event
  function handleSearch(searchType, searchInputParam, valueElement, containElement, updateCallback, deleteCallback) {
    const searchInput = $(searchInputParam).val();
    const searchValue = $(valueElement).val();

    $.ajax({
      type: "POST",
      url: "../includes/admin.inc.php",
      data: { searchValue: searchValue, searchInput: searchInput, searchType: searchType },
      success: function (response) {
        $(containElement).html(response);

        // Used for searching orders
        $(".status > button").each(function () {
          isSolved($(this));
        });

        if (typeof updateCallback === "function") {
          updateCallback();
        }

        if (typeof deleteCallback === "function") {
          deleteCallback();
        }
      },
      error: function () {
        alert("Error fetching data");
      },
    });
  }

  // ========================================================== PRODUCT ==========================================================
  // Move on to the add product page
  moveOn("#addproduct", "../admin/newProduct.php");

  // Exit the add product page
  moveOn("#exitproduct", "../admin/productmanager.php");

  // Set img
  $("#productinputimg").on("change", setImg);
  function setImg() {
    const inputFile = $("#productinputimg");
    const productImg = $("#productimg");
    if (inputFile[0].files && inputFile[0].files[0]) {
      productImg.attr("src", URL.createObjectURL(inputFile[0].files[0]));
    }
  }

  // Delete product
  function delProduct() {
    const delBtns = $(".del-productbtn");
    delBtns.each(function () {
      $(this).click((e) => {
        e.stopPropagation();
        const confirmation = confirm("Bạn có chắc chắn muốn xóa sản phẩm này?");
        if (confirmation) {
          const productId = $(this).closest("tr").data("productid");
          window.location.href = "../includes/admin.inc.php?del-productid=" + productId;
        }
      });
    });
  }
  delProduct();

  // Update product
  function updProduct() {
    const updBtns = $(".edit-productbtn");
    updBtns.each(function () {
      $(this).click((e) => {
        e.stopPropagation();
        const productId = $(this).closest("tr").data("productid");
        window.location.href = "../admin/editproduct.php?upd-productid=" + productId;
      });
    });
  }
  updProduct();

  // Search product
  const searchProductInput = $("#searchproductinput");
  searchProductInput.on("keypress", function (e) {
    const searchProductValue = $("#searchproductvalue");
    const bodyProduct = $("#bodyproduct");

    if (e.which == 13) {
      handleSearch("product", $(this), searchProductValue, bodyProduct, updProduct, delProduct);
    }
  });

  // ========================================================== USER ==========================================================
  // Move on to the add user page
  moveOn("#adduser", "../admin/newUser.php");

  // Exit the add user page
  moveOn("#exituser", "../admin/usermanager.php");

  // Update
  function updateUser() {
    const editBtns = $(".edit-userbtn");
    editBtns.each(function (editBtnIndex) {
      $(this).click(function (e) {
        e.stopPropagation();
        const userId = $(this).closest("tr").data("userid");
        window.location.href = "../admin/edituser.php?upduser_id=" + userId;
      });
    });
  }
  updateUser();

  // Delete
  function deleteUser() {
    const delBtns = $(".del-userbtn");
    delBtns.each(function (delBtnIndex) {
      $(this).click(function (e) {
        e.stopPropagation();
        const confirmation = confirm("Bạn có chắc chắn muốn xóa người dùng này?");
        if (confirmation) {
          const userId = $(this).closest("tr").data("userid");
          window.location.href = "../includes/admin.inc.php?deluser_id=" + userId;
        }
      });
    });
  }
  deleteUser();

  // Search user
  const searchUserInput = $("#searchinput");
  searchUserInput.on("keypress", function (e) {
    const searchUserValue = $("#searchvalue");
    const bodyUser = $("#bodyuser");
    // This is the `enter` key
    if (e.which == 13) {
      handleSearch("user", $(this), searchUserValue, bodyUser, updateUser, deleteUser);
    }
  });

  // ========================================================== ORDER ==========================================================
  // Search order
  const searchOrderInput = $("#searchorderinput");
  searchOrderInput.on("keypress", function (e) {
    const searchOrderValue = $("#searchordervalue");
    const bodyOrder = $("#bodyorder");

    // This is the `enter` key
    if (e.which == 13) {
      handleSearch("order", $(this), searchOrderValue, bodyOrder, updateOrder, deleteOrder);
    }
  });

  // Handle when clicking on the `delete` icon
  function deleteOrder() {
    const deleteBtns = $(".del-orderbtn");
    deleteBtns.each(function () {
      $(this).click(function (e) {
        e.stopPropagation();
        const confirmation = confirm("Bạn có chắc chắn muốn xóa hóa đơn này?");
        if (confirmation) {
          const orderId = $(this).closest("tr").data("orderid");
          window.location.href = "../includes/admin.inc.php?delorder_id=" + orderId;
        }
      });
    });
  }
  deleteOrder();

  // Handle when clicking on the `update` icon
  function updateOrder() {}

  // Handle when clicking on the `status` button
  const statusBtns = $(".status > button");
  statusBtns.each(function () {
    $(this).click(function () {
      const orderId = $(this).closest(".row-order").data("orderid");
      const orderStatus = parseInt($(this).val());

      if (orderStatus == 0) {
        $.ajax({
          type: "POST",
          url: "../includes/admin.inc.php",
          data: { orderId: orderId, orderStatus: orderStatus },
          dataType: "dataType",
          success: function (response) {
            alert(response);
            console.log(response);
            if (response == true) {
              alert("The order was handled");
            }
          },
          // error: function () {
          //   alert("There's something wrong when saving status into the database");
          // },
        });
      }
    });
  });

  // Handle the order when being clicked
  const rowOrders = $(".row-order");
  rowOrders.each(function () {
    $(this).click(function (e) {
      const orderId = $(this).data("orderid");

      $.ajax({
        type: "GET",
        url: "../includes/admin.inc.php",
        data: { orderId: orderId },
        success: function (response) {
          $("#bodyorder").append(response);
          $(".container").css("display", "flex");

          const overlay = $(".overlay");
          overlay.click(function (e) {
            $(".container").css("display", "none");
          });
        },
        error: function () {
          alert("Fetching data error");
        },
      });
    });
  });

  // Check if the order status is solved
  function isSolved(button) {
    const statusBtn = button.text().toLowerCase();

    if (statusBtn === "đã xử lý") {
      button.addClass("solved").removeClass("not-solve").off("click");
    } else {
      button
        .addClass("not-solve")
        .removeClass("solved")
        .click(function (e) {
          e.stopPropagation(); // prevent going to the order details
          $(this).removeClass("not-solve").addClass("solved").text("Đã xử lý");
          isSolved($(this));
        });
    }
  }

  $(".status > button").each(function () {
    isSolved($(this));
  });
});
