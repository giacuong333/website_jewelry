$(document).ready(function () {
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

  // Move on to the add product page
  $("#addproduct").click((e) => {
    e.preventDefault();
    window.location.href = "../admin/newProduct.php";
  });

  // Move on to the add user page
  $("#adduser").click((e) => {
    e.preventDefault();
    window.location.href = "../admin/newUser.php";
  });

  // Exit add a new user
  if ($("#exituser")) {
    $("#exituser").click((e) => {
      e.preventDefault();
      window.location.href = "../admin/usermanager.php";
    });
  }

  // Move on to the edit user page
  let editBtns = $(".edit-userbtn");
  editBtns.each(function (editBtnIndex) {
    $(this).click((e) => {
      e.preventDefault();
      let userId = $(this).closest("tr").find("[name='user_id']").text();
      window.location.href = "../admin/edituser.php?upduser_id=" + userId;
    });
  });

  // Delete an user
  let delBtns = $(".fa-trash");
  delBtns.each(function (delBtnIndex) {
    $(this).click((e) => {
      e.preventDefault();
      let userId = $(this).closest("tr").find("[name='user_id']").text();
      window.location.href = "../includes/admin.inc.php?deluser_id=" + userId;
    });
  });
});
