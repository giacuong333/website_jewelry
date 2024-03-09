<?php

session_start();

include_once("../server/connection/connect.s.php");
include_once("../server/models/adminmodel.s.php");
include_once("../server/controllers/admincontr.s.php");

$admin = new AdminController();
$products = $admin->getAllProducts();
$users = $admin->getAllUsers();
$orders = $admin->getOrders();
$categories = $admin->getCategories();
$roles = $admin->getRoles();

// =============================================== COMMON ===============================================

// Check the user's permission
if (!function_exists("checkPermission")) {
  function checkPermission($action_name, $admin)
  {
    $flag = false;
    if (isset($_SESSION["role_id"])) {
      $role_id = $_SESSION["role_id"];
      $flag = $admin->hasPermission($role_id, $action_name);
    }
    return $flag;
  }
}
// =============================================== USER ===============================================

// Handling when admin clicks on the `save` button
if (isset($_POST["saveuser"])) {
  $fullname = $_POST["fullname"];
  $email = $_POST["email"];
  $phonenumber = $_POST["phonenumber"];
  $password = $_POST["password"];
  $verifypassword = $_POST["verifypassword"];
  $roleid = $_POST["roleid"];

  $isSaved = $admin->setUser($fullname, $email, $phonenumber, $password, $verifypassword, $roleid);
  if ($isSaved) {
    echo "<script>alert('Save a user successfully')</script>";
    echo "<script>window.location.href='../admin/usermanager.php'</script>";
  } else {
    echo "<script>alert('Save a user failed')</script>";
  }
}

// Handling when admin clicks on the edit icon
if (isset($_GET["upduser_id"])) {
  $user = $admin->getUserById($_GET["upduser_id"]);
}

// Handling when admin clicks on the `update` button
if (isset($_POST["updateuser"])) {
  $id = $_POST["user_id"];
  $fullname = $_POST["fullname"];
  $email = $_POST["email"];
  $phonenumber = $_POST["phonenumber"];
  $roleid = $_POST["roleid"];
  $isUpdated = $admin->updateUser($id, $fullname, $email, $phonenumber, $roleid);

  if ($isUpdated) {
    echo "<script>alert('Update successfully')</script>";
    echo "<script>window.location.href='../admin/usermanager.php'</script>";
  } else {
    echo "<script>alert('Update failed')</script>";
  }
}

// Handling when admin deletes 
if (isset($_GET["deluser_id"])) {
  $admin->deleteUserById($_GET["deluser_id"]);
  echo "<script>window.location.href='../admin/usermanager.php'</script>";
}

// Search
if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "user") {
  $searchValue = trim($_POST["searchValue"]);
  $searchInput = trim($_POST["searchInput"]);

  $userContainer = $admin->searchUsers($searchInput, $searchValue);

  $html = !empty($userContainer) ? "" : "No user found";

  $editIcon = checkPermission("Edit users", $admin) ? "<span class='fa-solid fa-pen-to-square edit-userbtn' name='editbtn' value='editbtn'></span>" : "";
  $deleteIcon = checkPermission("Delete users", $admin) ? "<span class='fa-solid fa-trash del-userbtn' name='delbtn' value='delbtn'></span>" : "";

  if (!empty($userContainer)) {
    foreach ($userContainer as $user) {
      $html .= "
            <tr data-userid='{$user['id']}' data-roleid='{$user['role_id']}'>
              <td>{$user['id']}</td>
              <td>{$user['fullname']}</td>
              <td>{$user['email']}</td>
              <td>{$user['phone_number']}</td>
              <td>{$user['name']}</td>
              <td>{$user['created_at']}</td>
              <td>
                {$editIcon} 
                {$deleteIcon} 
              </td>
            </tr>
      ";
    }
  }

  echo $html;
}

// =============================================== PRODUCT ===============================================

// Add a new product
if (isset($_POST["saveproduct"])) {
  $title = $_POST["title"];
  $categoryid = $_POST["categoryid"];
  $price = $_POST["price"];
  $discount = $_POST["discount"];
  $description = $_POST["description"];
  $isShow = isset($_POST["show"]) ? 1 : 0;
  $isOutstanding = isset($_POST["outstanding"]) ? 1 : 0;
  $isNew = isset($_POST["new"]) ? 1 : 0;

  // Check if the file was uploaded without errors
  if (isset($_FILES["imagepath"]) && $_FILES["imagepath"]["error"] == 0) {
    $target_dir = "../assets/imgs/";
    $target_file = $target_dir . basename($_FILES["imagepath"]["name"]); // e.g. ../assets/imgs/img1.png
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["imagepath"]["tmp_name"]);
    if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }

    // Kiểm tra nếu file đã tồn tại
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Kiểm tra kích thước file
    if ($_FILES["imagepath"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Cho phép chỉ tải lên các loại file hình ảnh nhất định
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    $imagepath = $target_file;
  }

  $isSaved = $admin->setProduct($imagepath, $title, $categoryid, $price, $discount, $description, $isShow, $isOutstanding, $isNew);

  if ($isSaved) {
    echo "<script>alert('Save a product successfully')</script>";
    echo "<script>window.location.href='../admin/productmanager.php'</script>";
  } else {
    echo "<script>alert('Save a product failed')</script>";
  }
}

// Delete a product
if (isset($_GET["del-productid"])) {
  $productId = $_GET["del-productid"];
  $isDeleted = $admin->deleteProductById($productId);

  if ($isDeleted) {
    echo "<script>window.location.href='../admin/productmanager.php'</script>";
  } else {
    echo "<script>alert('Delete the product failed')</script>";
  }
}

// Set product information
if (isset($_GET["upd-productid"])) {
  $productId = $_GET["upd-productid"];
  $product = $admin->getProductById($productId);
}

// Update
if (isset($_POST["updateproduct"])) {
  $productId = $_POST["productid"];
  $title = $_POST["title"];
  $categoryid = $_POST["categoryid"];
  $price = $_POST["price"];
  $discount = $_POST["discount"];
  $description = $_POST["description"];
  $isShow = isset($_POST["show"]) ? 1 : 0;
  $isOutstanding = isset($_POST["outstanding"]) ? 1 : 0;
  $isNew = isset($_POST["new"]) ? 1 : 0;
  $imagepath = $_POST["thumbnail"];

  // Check if the file was uploaded without errors
  if (isset($_FILES["imagepath"]) && $_FILES["imagepath"]["error"] == 0) {
    $target_dir = "../assets/imgs/";
    $target_file = $target_dir . basename($_FILES["imagepath"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["imagepath"]["tmp_name"]);
    if ($check !== false) {
      echo "File is an image - " . $check["mime"] . ".";
      $uploadOk = 1;
    } else {
      echo "File is not an image.";
      $uploadOk = 0;
    }

    // Kiểm tra nếu file đã tồn tại
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Kiểm tra kích thước file
    if ($_FILES["imagepath"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Cho phép chỉ tải lên các loại file hình ảnh nhất định
    if (
      $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif"
    ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    $imagepath = $target_file;
  }

  $isUpdated = $admin->updateProductById($productId, $imagepath, $title, $categoryid, $price, $discount, $description, $isShow, $isOutstanding, $isNew);

  if ($isUpdated) {
    echo "<script>alert('Update the product successfully')</script>";
    echo "<script>window.location.href='../admin/productmanager.php'</script>";
  } else {
    echo "<script>alert('Update the product failed')</script>";
  }
}

// Search
if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "product") {
  $searchProductInput = trim($_POST["searchInput"]);
  $searchProductValue = trim($_POST["searchValue"]);

  $searchedProducts = $admin->searchProducts($searchProductInput, $searchProductValue);

  $html = !empty($searchedProducts) ? "" : "No product found";

  $editIcon = checkPermission("Edit products", $admin) ? "<span class='fa-solid fa-pen-to-square edit-productbtn'></span>" : "";
  $deleteIcon = checkPermission("Delete products", $admin) ? "<span class='fa-solid fa-trash del-productbtn' name='del-product' value='del-product'></span>" : "";

  if (!empty($searchedProducts)) {
    foreach ($searchedProducts as $product) {
      $isOutstanding = $product['isOutstanding'] == 1 ? "checked" : "";
      $isNew = $product['isNew'] == 1 ? "checked" : "";
      $isShow = $product['isShow'] == 1 ? "checked" : "";
      $html .= "
          <tr data-productid='{$product['id']}' data-categoryid='{$product['category_id']}'>
              <td>{$product['id']}</td>
              <td>{$product['name']}</td>
              <td>{$product['title']}</td>
              <td><img src=' {$product['thumbnail']}' alt='Product image' /></td>
              <td><p> {$product['price']}</p></td>
              <td><input type='checkbox' disabled {$isOutstanding} name='outstanding'/></td>
              <td><input type='checkbox' disabled {$isNew} name='isNew'/></td>
              <td><input type='checkbox' disabled {$isShow} name='isShow'/></td>
              <td>
                  {$editIcon}
                  {$deleteIcon}
              </td>
          </tr>
          ";
    }
  }

  echo $html;
}

// =============================================== ORDER ===============================================
// Order details
if (isset($_GET["orderId"]) && isset($_GET["userId"])) {
  $orderDetails = [];
  $orderId = $_GET["orderId"];
  $userId = $_GET["userId"];

  foreach ($orders as $order) {
    if ($order["id"] == $orderId) {
      $orderDetails = $order;
      break;
    }
  }

  $html = "
        <div class='container'>
            <div class='content'>
              <h2 class='content-header'>
                Order details
              </h2>
              <div class='content-body'>
                <div class='content-body__top'>
                  <div class='content-body__top-top'>
                    <div class='content-body__top-left'>
                      <h4>Date</h4>
                      <p>{$orderDetails['order_date']}</p>
                    </div>
                    <div class='content-body__top-right'>
                      <h4>Order ID</h4>
                      <p>#{$orderDetails['id']}</p>
                    </div>
                  </div>
                  <div class='content-body__top-bottom'>
                    <div class='content-body__top-address'>
                      <h4>Address</h4>
                      <p>{$orderDetails['address']}</p>
                    </div>
                    <div class='content-body__top-fullname'>
                      <h4>Name</h4>
                      <p>{$orderDetails['fullname']}</p>
                    </div>
                    <div class='content-body__top-email'>
                      <h4>Email</h4>
                      <p>{$orderDetails['email']}</p>
                    </div>
                    <div class='content-body__top-phonenumber'>
                      <h4>Phone nummber</h4>
                      <p>{$orderDetails['phone_number']}</p>
                    </div>
                  </div>
                </div>
                <div class='content-body__middle'>";

  $orderOfUser = $admin->getOrderByUserId($userId);
  if (!empty($orderOfUser)) {
    foreach ($orderOfUser as $order) {
      $orderPrice = $order["price"] * $order["num"];
      $html .= "
            <div class='content-body__middle-product' id={$order['productId']}>
              <div class='content-body__middle-product-image'><img src='{$order['thumbnail']}' alt='Product Image'></div>
              <div class='content-body__middle-product-info'>
                <div class='content-body__middle-product-name'>{$order['title']} <span>({$order['num']})</span></div>
                <div class='content-body__middle-product-price'>{$orderPrice}</div>
              </div>
            </div>";
    }
  }

  $totalOfOrder = $admin->calculateTotalMoneyByUerId($userId);
  $html .= "</div>
        <div class='content-body__bottom'>
          <p style='display:inline-block; color: #1f7a77;'>Total</p>
          <p class='content-body__bottom-total'>{$totalOfOrder["total_of_order"]}</p>
        </div>
        </div>
          <div class='content-footer'>
          <p class='content-footer__help'>Want any help? Please contact us.</p>
        </div>
      </div>
    </div>
    <div class='overlay'></div>
    ";

  echo $html;
}

// Delete
if (isset($_GET["delorder_id"])) {
  $orderId = $_GET["delorder_id"];
  $isDeleted = $admin->deleteOrder($orderId);

  if ($isDeleted) {
    echo "<script>window.location.href='../admin/ordermanager.php'</script>";
  } else {
    echo "<script>alert('Delete the order failed')</script>";
  }
}

// Search 
if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "order") {
  $searchInput = trim($_POST["searchInput"]);
  $searchValue = trim($_POST["searchValue"]);

  $ordersSearched = $admin->searchOrders($searchInput, $searchValue);

  $html = !empty($ordersSearched) ? "" : "No order found";

  $deleteIcon = checkPermission("Delete orders", $admin) ? "<span class='fa-solid fa-trash del-orderbtn' name='del-order' value='del-order'></span>" : "";

  if (!empty($ordersSearched)) {
    foreach ($ordersSearched as $order) {
      $status = $order["orderstatus"] == 1 ? "Đã xử lý" : "Đang xử lý";

      $solveBtn = checkPermission("Solve orders", $admin) ? "
      <button type='button' name='statusBtn' value='{$order['orderstatus']}' class='btn- btn--hover'>$status</button>" : "$status";

      $html .= "
      <tr class='row-order' data-orderid='{$order['orderid']}'>
        <td>{$order['orderid']}</td>
        <td>{$order['fullname']}</td>
        <td>{$order['orderemail']}</td>
        <td>{$order['orderphone']}</td>
        <td class='status'>{$solveBtn}</td>
        <td>{$order['total_money']}</td>
        <td>{$deleteIcon}</td>
      </tr>";
    }
  }

  echo $html;
}

// Status 
if (isset($_POST["orderId"]) && isset($_POST["orderStatus"])) {
  $orderId = $_POST["orderId"];
  $isSaved = $admin->saveStatus($orderId);
  echo $isSaved ? true : false;
}

// Search order by date
if (isset($_POST["fromDate"]) && isset($_POST["toDate"])) {
  $fromDate = $_POST["fromDate"];
  $toDate = $_POST["toDate"];

  $ordersSearchedDate = $admin->searchOrdersByDate($fromDate, $toDate);

  $html = !empty($ordersSearchedDate) ? "" : "No order found";

  $deleteIcon = checkPermission("Delete orders", $admin) ? "<span class='fa-solid fa-trash del-orderbtn' name='del-order' value='del-order'></span>" : "";

  if (!empty($ordersSearchedDate)) {
    foreach ($ordersSearchedDate as  $order) {
      $status = $order["orderstatus"] == 1 ? "Đã xử lý" : "Đang xử lý";

      $solveBtn = checkPermission("Solve orders", $admin) ? "
      <button type='button' name='statusBtn' value='{$order['orderstatus']}' class='btn- btn--hover'>$status</button>" : "$status";

      $html .= "
        <tr class='row-order' data-orderid='{$order['orderid']}'>
          <td>{$order['orderid']}</td>
          <td>{$order['orderfullname']}</td>
          <td>{$order['orderemail']}</td>
          <td>{$order['orderphonenumber']}</td>
          <td class='status'>{$solveBtn}</td>
          <td>{$order['total_money']}</td>
          <td>{$deleteIcon}</td>
        </tr>";
    }
  }
  echo $html;
}

// =============================================== CATEGORY ===============================================
// Delete
if (isset($_GET["delcategory_id"])) {
  $categoryId = $_GET["delcategory_id"];
  $isDeleted = $admin->deleteCategoryById($categoryId);

  if ($isDeleted) {
    echo "<script>window.location.href='../admin/categorymanager.php'</script>";
  } else {
    echo "<script>alert('Delete the category failed')</script>";
  }
}

// Add 
if (isset($_POST["savecategory"])) {
  $categoryName = trim($_POST["categoryname"]);

  $isSaved = $admin->addCategory($categoryName);

  if ($isSaved) {
    echo "<script>alert('Add the category successfully')</script>";
    echo "<script>window.location.href='../admin/categorymanager.php'</script>";
  } else {
    echo "<script>alert('Add the category failed')</script>";
  }
}

// Getting the category by id
if (isset($_GET["updcategory_id"])) {
  $categoryId = $_GET["updcategory_id"];
  $categoriesId = $admin->getCategoryById($categoryId);
}

// Search
if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "category") {
  $searchInput = $_POST["searchInput"];
  $searchValue = $_POST["searchValue"];

  $categoriesSearched = $admin->searchCategories($searchInput, $searchValue);

  $html = !empty($categoriesSearched) ? "" : "No category found";

  $editIcon = checkPermission("Edit categories", $admin) ? "<span class='fa-solid fa-pen-to-square edit-categorybtn'></span>" : "";
  $deleteIcon = checkPermission("Delete categories", $admin) ? "<span class='fa-solid fa-trash del-categorybtn' name='del-category' value='del-category'></span>" : "";

  if (!empty($categoriesSearched)) {
    foreach ($categoriesSearched as $category) {
      $html .= "
        <tr data-categoryid='{$category['id']}'>
          <td>{$category['id']}</td>
          <td>{$category['name']}</td>
          <td>
              {$editIcon}
              {$deleteIcon}
          </td>
        </tr>";
    }
  }

  echo $html;
}

// Update
if (isset($_POST["updatecategory"])) {
  $categoryName = trim($_POST["categoryname"]);
  $categoryId = $_POST["categoryid"];

  $isUpdated = $admin->updateCategory($categoryId, $categoryName);

  if ($isUpdated) {
    echo "<script>alert('Update the category successfully')</script>";
    echo "<script>window.location.href='../admin/categorymanager.php'</script>";
  } else {
    echo "<script>alert('Update the category failed')</script>";
  }
}

// =============================================== ROLE ===============================================
// Add
if (isset($_POST["saverole"])) {
  $roleName = $_POST["rolename"];

  $isSaved = $admin->addRole($roleName);

  if ($isSaved) {
    echo "<script>alert('Add the role successfully')</script>";
    echo "<script>window.location.href='../admin/rolemanager.php'</script>";
  } else {
    echo "<script>alert('Add the role failed')</script>";
  }
}

// Delete
if (isset($_GET["delrole_id"])) {
  $roleId = $_GET["delrole_id"];

  $isDeleted = $admin->deleteRole($roleId);

  if ($isDeleted) {
    echo "<script>window.location.href='../admin/rolemanager.php'</script>";
  } else {
    echo "<script>alert('Delete the role failed')</script>";
  }
}

// Update
if (isset($_GET["updrole_id"])) {
  $roleId = $_GET["updrole_id"];
  $rolesId = $admin->getRoleById($roleId);
}

if (isset($_GET["updaterole"])) {
  $roldId = $_GET["updrole_id"];

  $isUpdated = $admin->updateRole($id, $roleName);

  if ($isUpdated) {
    echo "<script>alert('Update the role successfully')</script>";
    echo "<script>window.location.href='../admin/rolemanager.php'</script>";
  } else {
    echo "<script>alert('Update the role failed')</script>";
  }
}

// Search 
if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "role") {
  $searchInput = $_POST["searchInput"];
  $searchValue = $_POST["searchValue"];

  $searchedRoles = $admin->searchRoles($searchInput, $searchValue);

  $html = isset($searchedRoles) ? "No role found" : "";

  if (isset($searchedRoles)) {
    foreach ($searchedRoles as $role) {
      $html .= "
      <tr data-roleid='{$role['id']}' >
        <td>{$role['id']}</td>
        <td>{$role['name']}</td>
        <td><button type='button' class='btn- btn--hover btn-privilege'>Phân quyền</button></td>
        <td>
            <span class='fa-solid fa-pen-to-square edit-rolebtn'></span>
            <span class='fa-solid fa-trash del-rolebtn' name='del-role' value='del-role'></span>
        </td>
    </tr>";
    }
  }
  echo $html;
}

// =============================================== PRIVILEGE ===============================================
// Render permissions based on the role id
if (isset($_GET["role_privilege_id"])) {
  $role_privilege_id = $_GET["role_privilege_id"];

  // Fetch all permissions associated with the role ID
  $permissions = $admin->getPermissionsByRoleId($role_privilege_id);

  // Convert the permissions array into a more efficient format for checking existence
  $permissionsMap = [];
  foreach ($permissions as $permission) {
    $permissionsMap[$permission['description']] = $permission['permissionId'];
  }

  // Define functions and actions
  $functions = array(
    "Categories" => array("Add", "Edit", "Delete", "See"),
    "Users" => array("Add", "Edit", "Delete", "See"),
    "Products" => array("Add", "Edit", "Delete", "See"),
    "Roles" => array("Add", "Edit", "Delete", "See"),
    "Galleries" => array("Add", "Edit", "Delete", "See"),
    "Orders" => array("Solve", "Delete", "See"),
    "Contacts" => array("Solve", "Delete", "See"),
    "Permissions" => array("Edit", "See"),
    "Statistics" => array("See")
  );

  // Start generating HTML
  $html = '
    <div class="overlay"></div>
      <form action="../includes/admin.inc.php?role_privilege_id=' . $role_privilege_id  . '" method="post" class="privilege-form">
          <div class="dashboard-body">
              <div class="header">FUNCTIONAL INFORMATION</div>
              <table style="border: none;">
                  <thead>
                      <tr>
                          <th>FUNCTION NAME</th>
                          <th colspan="4">ACTION</th>
                      </tr>
                  </thead>
                  <tbody id="bodyprivilege">';

  $saveBtn = checkPermission("Edit permissions", $admin) ? '<button type="submit" name="save-privilege" value="save-privilege" class="btn- btn--hover btn-save">Save</button>' : "";

  // Generate checkboxes for each function-action combination
  foreach ($functions as $function => $actions) {
    $html .= '<tr style="height: 40px; text-align: center;"><td>' . $function . '</td>';
    foreach ($actions as $action) {
      $permissionKey = $action . '-' . strtolower($function);
      $permissionDescription = $action . ' ' . strtolower($function);
      $checked = array_key_exists($permissionDescription, $permissionsMap) ? 'checked' : '';
      $html .= '<td><input style="display: inline-block;" type="checkbox" name="' . $permissionKey . '" ' . $checked . ' id="' . $permissionKey . '"> <label for="' . $permissionKey . '">' . $action . '</label></td>';
    }
    $html .= '</tr>';
  }

  // Close the HTML form
  $html .= '</tbody>
          </table>
          <button type="button" class="btn- btn--exit">Exit</button>
          ' . $saveBtn . '
          </div>
        </form>';

  // Display the generated HTML form
  echo $html;
}

// When clicking on the `save` privilege
if (isset($_POST["save-privilege"])) {
  if (isset($_GET["role_privilege_id"])) {
    $role_privilege_id = $_GET["role_privilege_id"];
  }

  // Define functions and actions
  $functions = array(
    "Categories" => array("Add", "Edit", "Delete", "See"),
    "Users" => array("Add", "Edit", "Delete", "See"),
    "Products" => array("Add", "Edit", "Delete", "See"),
    "Roles" => array("Add", "Edit", "Delete", "See"),
    "Galleries" => array("Add", "Edit", "Delete", "See"),
    "Orders" => array("Solve", "Delete", "See"),
    "Contacts" => array("Solve", "Delete", "See"),
    "Permissions" => array("Edit", "See"),
    "Statistics" => array("See")
  );

  foreach ($functions as $function => $actions) {
    foreach ($actions as $action) {
      $permissionDescription = $action . '-' . strtolower($function);
      $checked = isset($_POST[$permissionDescription]) ? 1 : 0;
      $permissionDescription = str_replace("-", " ", $permissionDescription);
      $admin->setPrivilegeByRoleId($role_privilege_id, $permissionDescription, $checked);
    }
  }

  echo "<script>window.location.href = '../admin/rolemanager.php';</script>";
}
