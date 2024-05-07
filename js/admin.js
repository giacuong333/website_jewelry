import { isCorrectVerifyPassword, isEmail, isEmpty, isExceedDefault, isNumber, isPhoneNumber, queryValue } from "./config.js";

$(document).ready(function () {
  // ========================================================== COMMON ==========================================================
  // Set current selected page
  function setSelectedPage() {
    let id = parseInt(document.body.id) - 1;
    const pages = $(".pagination-container__pages-num");
    $(pages[id]).addClass("pagination-container__pages--current");
  }
  setSelectedPage();

  // Selected menu item
  function setSelectedMenuItem() {
    let active_page_basename = window.location.pathname.split("/"); // Get the current path of the url

    $(".sidebar-menu").each(function () {
      const link = $(this).attr("href").split("/"); // Get the path of the selected item

      $(this).removeClass("is-selected"); // Refresh before adding

      if (link[link.length - 1] === active_page_basename[active_page_basename.length - 1]) {
        $(this).addClass("is-selected");
      }
    });
  }
  setSelectedMenuItem();

  // Move on to another page
  function moveOn(element, url) {
    if (element) {
      $(element).click((e) => {
        window.location.href = url;
      });
    }
  }

  // Is valid input fields
  function isValidInputs(inputObj, errorObj, type) {
    let isValid = false;
    if ((isValid = isEmpty(inputObj.val(), errorObj))) {
      switch (type) {
        case "email":
          isValid = isEmail(inputObj.val(), errorObj);
          break;
        case "phoneNumber":
          isValid = isPhoneNumber(inputObj.val(), errorObj);
          break;
        case "number":
          isValid = isNumber(inputObj.val(), errorObj);
          break;
        case "verifypassword":
          isValid = isCorrectVerifyPassword(inputObj.val(), $("input[name='password']").val(), errorObj);
          break;
      }
    }
    return isValid;
  }

  // Handle valid input fields when the user's typing
  function handleValidInput(inputFields) {
    let isValid = true;
    for (const key in inputFields) {
      const inputType = inputFields[key];
      const inputObj = $(`input[name=${key}`);
      const errorObj = inputObj.closest("td").find(".error-message");
      isValid = isValidInputs(inputObj, errorObj, inputType) && isValid;
    }
    return isValid;
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
        console.log(response);

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

        // Used for contact
        if (searchType === "contact") {
          showContent();
        }

        if (searchType === "gallery") {
          // View the image details
          show_image_details();

          // Delete the image
          const trash_icon = $(".image-details > .fa-trash");
          if (trash_icon) {
            trash_icon.click(function () {
              const img_id = $(this).closest(".image-details").attr("id");

              const question = confirm("Bạn có chắc chắn muốn xóa ảnh này?");

              if (question) {
                handle_delete_image(img_id);
              }
            });
          }
        }

        // View import invoice details
        if (searchType === "import_invoice") {
          show_import_invoice_details();
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

  // Validate input fields
  $("button[name='saveproduct']")
    .unbind("click")
    .click(function () {
      const inputFields = {
        title: "",
        price: "number",
        discount: "number",
      };
      if (handleValidInput(inputFields)) {
        $(this).attr("type", "submit").trigger("click");
      }
    });

  $("button[name='updateproduct']")
    .unbind("click")
    .click(function () {
      const inputFields = {
        title: "",
        price: "number",
        discount: "number",
      };
      if (handleValidInput(inputFields)) {
        $(this).attr("type", "submit").trigger("click");
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

  // Validate input fields
  $("button[name='saveuser']")
    .unbind("click")
    .click(function () {
      const inputFields = {
        fullname: "",
        email: "email",
        phonenumber: "phoneNumber",
        password: "",
        verifypassword: "",
        verifypassword: "verifypassword",
      };
      if (handleValidInput(inputFields)) {
        $(this).attr("type", "submit").trigger("click");
      }
    });

  $("button[name='updateuser']")
    .unbind("click")
    .click(function () {
      const inputFields = {
        fullname: "",
        email: "email",
        phonenumber: "phoneNumber",
      };
      if (handleValidInput(inputFields)) {
        $(this).attr("type", "submit").trigger("click");
      }
    });

  // Check whether the user is set

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
      data: { fromDate: formatFromDate, toDate: formatToDate, searchType: "order_invoice" },
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

  // Validate input fields
  $("button[name='savecategory']")
    .unbind("click")
    .click(function () {
      if (handleValidInput({ categoryname: "" })) {
        $(this).attr("type", "submit").trigger("click");
      }
    });

  $("button[name='updatecategory']")
    .unbind("click")
    .click(function () {
      if (handleValidInput({ categoryname: "" })) {
        $(this).attr("type", "submit").trigger("click");
      }
    });

  // ========================================================== ROLE ==========================================================
  // Move on to the add new role page
  moveOn("#addrole", "../admin/newRole.php");

  // Move on to the rolemanager page
  moveOn("#exitrole", "../admin/rolemanager.php");

  // Delete
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

  // Update
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

  // Validate input fields
  $("button[name='saverole']")
    .unbind("click")
    .click(function () {
      if (handleValidInput({ rolename: "" })) {
        $(this).attr("type", "submit").trigger("click");
      }
    });

  $("button[name='updaterole']")
    .unbind("click")
    .click(function () {
      if (handleValidInput({ rolename: "" })) {
        $(this).attr("type", "submit").trigger("click");
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

  // =========================================================== GALLERY ============================================================
  function show_image_details() {
    const image_item_list = $(".gallery-container__item");

    image_item_list.each(function () {
      $(this).click(function () {
        const img_id = $(this).attr("id");

        $.ajax({
          type: "GET",
          url: "../includes/admin.inc.php",
          async: false,
          data: { img_id: img_id, type: "get_img" },
          success: function (response) {
            $("body").append(response);

            // Cleanup when the overlay is clicked
            $(".overlay").click(function (e) {
              $(this).remove();
              $(".image-details").remove();
            });

            // Delete the image
            const trash_icon = $(".image-details > .fa-trash");
            if (trash_icon) {
              trash_icon.click(function () {
                const img_id = $(this).closest(".image-details").attr("id");

                const question = confirm("Bạn có chắc chắn muốn xóa ảnh này?");

                if (question) {
                  handle_delete_image(img_id);
                }
              });
            }
          },
        });
      });
    });
  }
  show_image_details();

  function handle_delete_image(img_id) {
    $.ajax({
      type: "POST",
      url: "../includes/admin.inc.php",
      data: { img_id: img_id, type: "del_img" },
      success: function (response) {
        if (response == 1) {
          alert("Xóa ảnh thành công");
          window.location.reload();
        } else {
          alert("Xóa ảnh thất bại");
        }
      },
    });
  }

  // Upload an image
  function show_image_upload() {
    const upload_image_btn = $("#addgallery");

    upload_image_btn.click(function () {
      $.ajax({
        type: "GET",
        url: "../includes/admin.inc.php",
        data: { show_img_upload_panel: "show" },
        success: function (response) {
          $("body").append(response);

          // Cleanup when the overlay is clicked
          $(".overlay").click(function (e) {
            $(this).remove();
            $(".image-details").remove();
          });

          // Set img
          $("#image_choosen").on("change", setImg);
          function setImg() {
            const inputFile = $("#image_choosen");
            const img = $(".image-details__img-up > img");
            if (inputFile[0].files && inputFile[0].files[0]) {
              img.attr("src", URL.createObjectURL(inputFile[0].files[0]));
            }
          }

          // Save img
          $("#uploadgallery").click(function () {
            handle_upload_img();
          });
        },
      });
    });
  }
  show_image_upload();

  // Save img to datase

  function handle_upload_img() {
    const img_chosen = $("#image_choosen");
    const img_title = $(".image_title");
    const img_chosen_error = img_chosen.closest(".form-group").find(".error-message");
    const img_title_error = img_title.closest(".form-group").find(".error-message");

    let is_allowed = true;

    if (isEmpty(img_chosen.val(), img_chosen_error)) {
      is_allowed = false;
    }

    if (isEmpty(img_title.val(), img_title_error)) {
      is_allowed = false;
    }

    if (is_allowed) {
      $.ajax({
        type: "POST",
        url: "../includes/admin.inc.php",
        data: {
          image_path: img_chosen.val(),
          image_title: img_title.val(),
          upload_img: "upload_img",
        },

        success: function (response) {
          if (response === "success") {
            alert("Upload image successfully");
            window.location.reload();
          } else if (response == "failed") {
            alert("Upload image failed");
          }
        },
      });
    }
  }

  // Search gallery
  const searchGalleryInput = $("#searchgalleryinput");
  searchGalleryInput.on("keypress", function (e) {
    const searchGalleryValue = $("#searchgalleryvalue");
    const galleryContainer = $(".body");

    if (e.which == 13) {
      if ($(this).val().trim() !== "") {
        handleSearch("gallery", $(this), searchGalleryValue, galleryContainer, null, null);
      } else {
        window.location.reload();
      }
    }
  });

  // ========================================================== INPUT INVOICE ==========================================================
  // Delete
  function del_input_invoice() {
    $(".del-importbtn").each(function () {
      $(this).click(function (e) {
        e.stopPropagation();
        const question = confirm("Bạn có chắc chắn muốn xóa hóa đơn này?");
        if (question) {
          const input_invoice_id = $(this).closest("tr").data("import_invoiceid");

          $.ajax({
            type: "POST",
            url: "../includes/admin.inc.php",
            data: { input_invoice_id: input_invoice_id, type: "del_input_invoice" },
            success: function (response) {
              if (response == 1) {
                alert("Delete successfully");
                window.location.reload();
              } else {
                alert("Delete failed");
              }
            },
          });
        }
      });
    });
  }
  del_input_invoice();

  // Move on to the add new input invoice page
  moveOn(".btn-addinputinvoice", "../admin/newinputinvoice.php");

  // Exit the page
  moveOn("#exitimportinvoice", "../admin/importmanager.php");

  // View import invoice details
  function show_import_invoice_details() {
    $(".row-import-invoice").each(function () {
      $(this).click(function () {
        const import_invoice_id = $(this).data("import_invoiceid");

        $.ajax({
          type: "GET",
          url: "../includes/admin.inc.php",
          data: { import_invoice_id: import_invoice_id, type: "get_import_invoice_details" },
          success: function (response) {
            $("#import-body").prepend(response);

            // Close overlay
            $(".overlay").click(function () {
              $(this).remove();
              $(".import-invoice-container").remove();
            });
          },
        });
      });
    });
  }
  show_import_invoice_details();

  // Save product temporarily
  function save_product_temp() {
    $(".saveproducttempo").click(function () {
      const product_id = $("#product_selected").val();
      const supplier_id = $("#supplier_selected").val();
      const product_amount = $("input[name='product_amount']").val();
      const import_product_price = $("input[name='product_price']").val();

      $.ajax({
        type: "POST",
        url: "../includes/admin.inc.php",
        data: {
          product_id: product_id,
          supplier_id: supplier_id,
          product_amount: product_amount,
          import_product_price: import_product_price,
          saveimportinvoice: "saveimportinvoice",
        },
        success: function (response) {
          alert("Saved");

          // Refresh input fields
          $("input[name='product_amount']").val("");
          $("input[name='product_price']").val("");
        },
      });
    });
  }
  save_product_temp();

  // Search import invoice
  const search_import_invoice_input = $("#searchimportinvoiceinput");
  search_import_invoice_input.on("keypress", function (e) {
    const searchImportInvoiceValue = $("#searchimportinvoicevalue");
    const importInvoiceContainer = $("#bodyimportinvoice");

    if (e.which == 13) {
      if ($(this).val().trim() !== "") {
        handleSearch("import_invoice", $(this), searchImportInvoiceValue, importInvoiceContainer, null, del_input_invoice);
      } else {
        window.location.reload();
      }
    }
  });

  // Search order by date
  const search_input_invoice_btn = $(".btn-searchbydate-input-invoice");
  search_input_invoice_btn.click(function (e) {
    e.preventDefault();

    const fromDate = new Date($("#searchfromdateinput-inputinvoice").val());
    const toDate = new Date($("#searchtodateinput-inputinvoice").val());

    if ($("#searchfromdateinput-inputinvoice").val() == "" || $("#searchtodateinput-inputinvoice").val() == "") {
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
      data: { fromDate: formatFromDate, toDate: formatToDate, searchType: "search_input_invoice_date" },
      success: function (response) {
        $("#bodyimportinvoice").html(response);

        // Delete import invoice
        del_input_invoice();

        // Show import invoice details
        show_import_invoice_details();
      },
      error: function () {
        alert("Date is invalid");
      },
    });
  });

  // Disable when being selected a supplier
  $("select[name='supplier_selected']").change(function () {
    $(this).attr("disabled", "disabled");
  });

  // Validate input fields
  $("button[name='addproduct']")
    .unbind("click")
    .click(function () {
      const inputFields = {
        product_amount: "number",
        product_price: "number",
      };
      if (handleValidInput(inputFields)) {
        $(this).attr("type", "submit").trigger("click");
      }
    });

  // ========================================================== CONTACT ==========================================================

  // Delete contact
  function del_contact() {
    $(".del-contactbtn").each(function () {
      $(this).click(function (e) {
        e.stopPropagation();
        const question = confirm("Bạn có chắc chắn muốn xóa liên lạc này?");
        if (question) {
          const contact_id = $(this).closest("tr").data("contactid");
          console.log(contact_id);

          $.ajax({
            type: "POST",
            url: "../includes/admin.inc.php",
            data: {
              contact_id: contact_id,
              type: "del_contact",
            },
            success: function (response) {
              console.log(response);
              if (response == 1) {
                alert("Delete successfully");
                window.location.reload();
              } else {
                alert("Delete failed");
              }
            },
          });
        }
      });
    });
  }
  del_contact();

  // Search contacts
  const seach_contact_input = $("#searchcontactinput");
  seach_contact_input.on("keypress", function (e) {
    const searchContactValue = $("#searchcontactvalue");
    const contactContainer = $("#bodycontact");

    console.log(searchContactValue.val());
    console.log($(this).val());

    if (e.which == 13) {
      if ($(this).val().trim() !== "") {
        handleSearch("contact", $(this), searchContactValue, contactContainer, null, del_contact);
      } else {
        window.location.reload();
      }
    }
  });

  // Show content
  function showContent() {
    $("#bodycontact tr").click(function () {
      const contactId = $(this).data("contactid");

      $.ajax({
        type: "POST",
        url: "../includes/admin.inc.php",
        data: {
          contactId: contactId,
          type: "showContent",
        },
        success: function (response) {
          $(".contact-main").prepend(response);

          hideContent();
        },
      });
    });
  }
  showContent();

  // Hide content when clicking on the overlay
  function hideContent() {
    $(".overlay").click(function () {
      $(this).remove();
      $(".content-popup").remove();
    });
  }
  hideContent();
});
