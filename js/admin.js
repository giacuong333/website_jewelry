$(document).ready(function () {
  // ========================================================== COMMON ==========================================================
  // Query the valu of an url
  function queryValue(value) {
    const query_string = window.location.search;
    const url_params = new URLSearchParams(query_string);
    return url_params.get(value);
  }

  // Selected menu item
  function setSelectedMenuItem() {
    let active_page = window.location.pathname; // Get the current path of the url
    active_page = active_page.replace("/website_jewelry/", "../");

    $(".sidebar-menu").each(function () {
      const link = $(this).attr("href"); // Get the path of the selected item

      $(this).removeClass("is-selected"); // Refresh before adding

      if (link == active_page) {
        $(this).addClass("is-selected");
      }
    });
  }
  setSelectedMenuItem();

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

        console.log(response);

        if (typeof updateCallback === "function") {
          updateCallback();
        }

        if (typeof deleteCallback === "function") {
          deleteCallback();
        }

        // Used for privileging
        if (searchType === "role") {
          privilege();
        }

        // Used for searching orders
        if (searchType === "order") {
          isSolved();
          solvedStatus(); // Patch to the admin.inc.php
          // Used for viewing order details
          viewOrderDetails();
        }
      },
      error: function () {
        alert("Error fetching data");
      },
    });
  }

  function formatDate(dateValue) {
    const date = dateValue.getDate().toString().padStart(2, "0");
    const month = (dateValue.getMonth() + 1).toString().padStart(2, "0");
    const year = dateValue.getFullYear();

    const formatted = year + "-" + month + "-" + date;
    return formatted;
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
        const categoryId = $(this).closest("tr").data("categoryid");
        window.location.href = "../admin/editproduct.php?upd-productid=" + productId + "&categoryid=" + categoryId;
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
        const roleId = $(this).closest("tr").data("roleid");
        console.log(roleId);
        window.location.href = "../admin/edituser.php?upduser_id=" + userId + "&role_id=" + roleId;
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
  // Search order by date
  const searchDateBtn = $(".btn-searchbydate");
  searchDateBtn.click(function (e) {
    e.preventDefault();

    const fromDate = new Date($("#searchfromdateinput").val());
    const toDate = new Date($("#searchtodateinput").val());

    if ($("#searchfromdateinput").val() == "" || $("#searchtodateinput").val() == "") {
      alert("Date is not selected");
      return;
    }

    if (fromDate > toDate) {
      alert("The start date is not greater than the end day!");
      return;
    }

    const formatFromDate = formatDate(fromDate);
    const formatToDate = formatDate(toDate);

    $.ajax({
      type: "POST",
      url: "../includes/admin.inc.php",
      data: { fromDate: formatFromDate, toDate: formatToDate },
      success: function (response) {
        $("#bodyorder").html(response);

        isSolved();
        solvedStatus();
        deleteOrder();
        viewOrderDetails();
      },
      error: function () {
        alert("Date is invalid");
      },
    });
  });

  // Search order
  const searchOrderInput = $("#searchorderinput");
  searchOrderInput.on("keypress", function (e) {
    const searchOrderValue = $("#searchordervalue");
    const bodyOrder = $("#bodyorder");

    // This is the `enter` key
    if (e.which == 13) {
      handleSearch("order", $(this), searchOrderValue, bodyOrder, null, deleteOrder);
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

  // Handle when clicking on the `status` button
  function solvedStatus() {
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
  }
  solvedStatus();

  // Handle the order when being clicked
  function viewOrderDetails() {
    const rowOrders = $(".row-order");
    rowOrders.each(function () {
      $(this).click(function (e) {
        const orderId = $(this).data("orderid");
        const userId = $(this).data("userid");

        $.ajax({
          type: "GET",
          url: "../includes/admin.inc.php",
          data: { orderId: orderId, userId: userId },
          success: function (response) {
            $("#order-body").prepend(response);
            const container = $(".container");
            container.css("display", "flex");

            // Cleanup when the overlay is clicked
            $(".overlay").click(function (e) {
              $(this).remove();
              container.remove();
            });
          },
          error: function () {
            alert("Fetching data error");
          },
        });
      });
    });
  }
  viewOrderDetails();

  // Check if the order status is solved
  function isSolved() {
    $(".status > button").each(function () {
      const statusBtn = $(this).text().toLowerCase();

      if (statusBtn === "đã xử lý") {
        $(this).addClass("solved").removeClass("not-solve").off("click");
      } else {
        $(this)
          .addClass("not-solve")
          .removeClass("solved")
          .click(function (e) {
            e.stopPropagation(); // prevent going to the order details
            $(this).removeClass("not-solve").addClass("solved").text("Đã xử lý");
            isSolved();
          });
      }
    });
  }
  isSolved();

  // ========================================================== CATEGORY ==========================================================
  function deleteCategory() {
    const deleteBtns = $(".del-categorybtn");
    deleteBtns.each(function () {
      $(this).click(function (e) {
        e.stopPropagation();
        const confirmation = confirm("Bạn có chắc chắn muốn xóa phân loại này?");
        if (confirmation) {
          const categoryId = $(this).closest("tr").data("categoryid");
          window.location.href = "../includes/admin.inc.php?delcategory_id=" + categoryId;
        }
      });
    });
  }
  deleteCategory();

  // Update
  function updateCategory() {
    const editBtns = $(".edit-categorybtn");
    editBtns.each(function (editBtnIndex) {
      $(this).click(function (e) {
        e.stopPropagation();
        const categoryId = $(this).closest("tr").data("categoryid");
        window.location.href = "../admin/editcategory.php?updcategory_id=" + categoryId;
      });
    });
  }
  updateCategory();

  // Move on to the add new category page
  moveOn("#addcategory", "../admin/newCategory.php");

  // Move on to the categorymanager page
  moveOn("#exitcategory", "../admin/categorymanager.php");

  // Search
  const searchCategoryInput = $("#searchcategoryinput");
  searchCategoryInput.on("keypress", function (e) {
    const searchCategoryValue = $("#searchcategoryvalue");
    const bodyCategory = $("#bodycategory");

    // This is the `enter` key
    if (e.which == 13) {
      handleSearch("category", $(this), searchCategoryValue, bodyCategory, updateCategory, deleteCategory);
    }
  });

  // ========================================================== ROLE ==========================================================
  // Move on to the add new role page
  moveOn("#addrole", "../admin/newRole.php");

  // Move on to the rolemanager page
  moveOn("#exitrole", "../admin/rolemanager.php");

  function deleteRole() {
    const deleteBtns = $(".del-rolebtn");
    deleteBtns.each(function () {
      $(this).click(function (e) {
        e.stopPropagation();
        const confirmation = confirm("Bạn có chắc chắn muốn xóa vai trò này?");
        if (confirmation) {
          const roleId = $(this).closest("tr").data("roleid");
          window.location.href = "../includes/admin.inc.php?delrole_id=" + roleId;
        }
      });
    });
  }
  deleteRole();

  function updateRole() {
    const editBtns = $(".edit-rolebtn");
    editBtns.each(function (editBtnIndex) {
      $(this).click(function (e) {
        e.stopPropagation();
        const roleId = $(this).closest("tr").data("roleid");
        window.location.href = "../admin/editrole.php?updrole_id=" + roleId;
      });
    });
  }
  updateRole();

  // Search
  const searchRoleInput = $("#searchroleinput");
  searchRoleInput.on("keypress", function (e) {
    const searchRoleValue = $("#searchrolevalue");
    const bodyRole = $("#bodyrole");

    // This is the `enter` key
    if (e.which == 13) {
      handleSearch("role", $(this), searchRoleValue, bodyRole, updateRole, deleteRole);
    }
  });

  // ========================================================== PRIVILEGE ==========================================================
  // Clicking on the `Phân quyền` button
  function privilege() {
    $(".btn-privilege").each(function () {
      $(this).click(function (e) {
        e.preventDefault();
        const roleId = $(this).closest("tr").data("roleid");

        $.ajax({
          type: "GET",
          url: "../includes/admin.inc.php",
          data: { role_privilege_id: roleId },
          success: function (response) {
            $(".privilege-panel").html(response);

            // Clicking on the overlay
            $(".btn--exit").click(function () {
              $(".overlay").remove();
              $(".privilege-form").remove();
            });
          },
        });
      });
    });
  }
  privilege();
});
