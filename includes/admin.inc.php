<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include_once("../server/connection/connect.s.php");
include_once("../server/models/adminmodel.s.php");
include_once("../server/controllers/admincontr.s.php");

$admin = new AdminController();
$products = $admin->getAllProducts();
$users = $admin->getAllUsers();
$orders = $admin->getOrders();
$categories = $admin->getCategories();
$roles = $admin->getRoles();
$import_invoices = $admin->getInputInvoices();
$suppliers = $admin->getSuppliers();
$contacts = $admin->getContacts();

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
  // Handle the response from setUser method
  if ($isSaved == "existingemail") {
    echo "<script>alert('Email is existing')</script>";
    echo "<script>window.location.href='../admin/newUser.php'</script>";
  } elseif ($isSaved == "existingphonenumber") {
    echo "<script>alert('Phone number is existing')</script>";
    echo "<script>window.location.href='../admin/newUser.php'</script>";
  } else {
    echo "<script>alert('Save a user successfully')</script>";
    echo "<script>window.location.href='../admin/usermanager.php'</script>";
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
    if ($order["orderid"] == $orderId) {
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
                      <p>#{$orderDetails['orderid']}</p>
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

  $orderOfUser = $admin->getOrderByUserIdAndOrderId($userId, $orderId);
  echo "<script>console.log('" . json_encode($orderOfUser) . "')</script>";

  $totalOfOrder = 0;

  if (!empty($orderOfUser)) {
    foreach ($orderOfUser as $order) {
      $totalOfOrder = $order["order_totalmoney"];
      $html .= "
            <div class='content-body__middle-product' id={$order['productId']}>
              <div class='content-body__middle-product-image'><img src='{$order['thumbnail']}' alt='Product Image'></div>
              <div class='content-body__middle-product-info'>
                <div class='content-body__middle-product-name'>{$order['title']} <span>({$order['num']})</span></div>
                <div class='content-body__middle-product-price'>{$order["orderdetail_totalmoney"]}</div>
              </div>
            </div>";
    }
  }

  // $totalOfOrder = $admin->calculateTotalMoneyByUerId($userId);
  $html .= "</div>
        <div class='content-body__bottom'>
          <p style='display:inline-block; color: #1f7a77;'>Total</p>
          <p class='content-body__bottom-total'>{$totalOfOrder}</p>
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
if (isset($_POST["fromDate"]) && isset($_POST["toDate"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "order_invoice") {
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
    "Imports" => array("Add", "Edit", "Delete", "See"),
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
    "Imports" => array("Add", "Edit", "Delete", "See"),
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

// =============================================== GALLERY ===============================================

// View the image details
if (isset($_GET["img_id"]) && isset($_GET["type"]) && $_GET["type"] == "get_img") {
  $img_id = $_GET["img_id"];

  $img = $admin->getGalleryById($img_id);

  $trash_icon = checkPermission("Delete galleries", $admin) ? '<i class="fa-solid fa-trash"></i>' : "";

  $html = '
      <div class="overlay overlay--bold"></div>
      <div class="image-details" id="' . $img["id"] . '">
            <div class="image-details__title">' . $img["title"] . '</div>
            <div class="image-details__img">
                  <img src="' . $img["thumbnail"] . '" alt="' . $img["title"] . '">
            </div>
            ' . $trash_icon . '
      </div>
  ';

  echo $html;
}

// Delete an image
if (isset($_POST["img_id"]) && isset($_POST["type"]) && $_POST["type"] == "del_img") {
  $img_id = $_POST["img_id"];

  $is_deleted = $admin->deleteGalleryById($img_id);

  if ($is_deleted) {
    echo 1;
  } else {
    echo 0;
  }
}

// Show upload panel
if (isset($_GET["show_img_upload_panel"])) {
  $html = '
    <div class="overlay"></div>
    <div class="image-details">
          <form action="../includes/admin.inc.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="image_choosen">Choose image</label>
              <input type="file" name="image_path" class="btn- btn--hover image-path" id="image_choosen">
              <div class="error-message"></div>
            </div>
            <div class="form-group">
              <label for="image_title">Title</label>
              <input type="text" name="image-title" class="btn- image_title" placeholder="Image title">
              <div class="error-message"></div>
            </div>
            <div class="image-details__img-up" style="border: none;">
              <img src="" alt="">
            </div>
            <button id="uploadgallery" name="upload_img" value="upload_img" class="btn- btn--hover" type="submit">Upload</button>
          </form>
    </div>
  ';

  echo $html;
}

// Clicking on the upload
if (isset($_POST["upload_img"])) {
  $target_dir = "../assets/imgs/";
  $target_file = $target_dir . basename($_FILES["image_path"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

  $image_title = $_POST["image_title"];

  $check = getimagesize($_FILES["image_path"]["tmp_name"]);
  if ($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }

  // Kiểm tra kích thước file
  if ($_FILES["image_path"]["size"] > 500000) {
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

  if ($uploadOk != 0) {
    if (move_uploaded_file($_FILES["image_path"]["tmp_name"], $target_file)) {
      // Lưu đường dẫn vào cơ sở dữ liệu
      $image_path = $target_dir . basename($_FILES["image_path"]["name"]);

      $is_uploaded = $admin->addGallery($image_title, $image_path);

      if ($is_uploaded) {
        echo "
          <script>alert('Add successfully')
            window.location.href='../admin/gallerymanager.php'
          </script>;
        ";
      } else {
        echo "
        <script>alert('Add failed')
        window.location.href='../admin/gallerymanager.php'
      </script>;
        ";
      }
    }
  }
}

if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "gallery") {
  $searchInput = trim($_POST["searchInput"]);
  $searchValue = trim($_POST["searchValue"]);

  $gallery_list = $admin->searchGalleries($searchInput, $searchValue);

  $html = !empty($gallery_list["gallery_list"]) ? "" : "No gallery found";

  if (!empty($gallery_list["gallery_list"])) {

    $html .= '
      <div class="gallery-container">
    ';

    foreach ($gallery_list["gallery_list"] as $item) {

      $html .= '
        <div class="gallery-container__item" id="' . $item["id"] . '">
              <img src="' . $item["thumbnail"] . '" alt="' . $item["title"] . '" class="gallery-container__item-image">
        </div>';
    }
  }

  echo $html;
}

// =============================================== INPUT INVOICE ===============================================
// Delete
if (isset($_POST["input_invoice_id"]) && isset($_POST["type"]) && $_POST["type"] == "del_input_invoice") {
  $input_invoice_id = $_POST["input_invoice_id"];

  $is_deleted = $admin->deleteInputInvoiceById($input_invoice_id);

  if ($is_deleted) {
    echo 1;
  } else {
    echo 0;
  }
}

// Add new inport invoice
if (isset($_POST["addproduct"])) {
  $user_id = $_SESSION["id"];
  $import_product_list = $_SESSION["import_products"];
  $supplier_id = $_SESSION["supplier_id"];

  $is_saved = $admin->addImportInvoice($user_id, $import_product_list, $supplier_id);

  if ($is_saved) {
    echo "<script>
            alert('Add successfully');
            window.location.href = '../admin/importmanager.php';
          </script>";

    unset($_SESSION["import_products"]);
    unset($_SESSION["supplier_id"]);
  } else {
    echo "<script>
    alert('add failed');
    window.location.href = '../admin/importmanager.php';
    </script>";

    unset($_SESSION["import_products"]);
    unset($_SESSION["supplier_id"]);
  }
}

// Save import products temporarily 
if (isset($_POST["saveimportinvoice"])) {
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  $import_products = [];

  $product_id = $_POST["product_id"];
  $_SESSION["supplier_id"] = $_POST["supplier_id"];
  $product_amount = $_POST["product_amount"];
  $import_product_price = $_POST["product_price"];

  $import_products[] = ["product_id" => $product_id, "product_amount" => $product_amount, "import_product_price" => $import_product_price];

  if (!isset($_SESSION["import_products"])) {
    $_SESSION["import_products"] =  $import_products;
  } else {
    $_SESSION["import_products"] = array_merge($_SESSION["import_products"], $import_products);
  }
}

// Show import invoice details
if (isset($_GET["import_invoice_id"]) && isset($_SESSION["id"]) && isset($_GET["type"]) && $_GET["type"] == "get_import_invoice_details") {
  $import_invoice_id = $_GET["import_invoice_id"];

  $import_invoice_details = $admin->getInputInvoiceById($import_invoice_id);
  $import_products_invoice = $admin->getImportProductInvoiceById($import_invoice_id);

  $html = '
  <div class="overlay"></div>
      <div class="import-invoice-container">
            <div class="import-invoice-container__header">
                  <img src="../assets/imgs/brand/logo.png"></img>
                  <h1 class="import-invoice-container__title">INVOICE</h1>
                  <p class="import-invoice-container__sub-title">Submission</p>
            </div>

            <div class="import-invoice-container__body">
                  <div class="import-invoice-container__body-top">
                        <p>Invoice to: <span>' . $import_invoice_details["name"] . '</span></p>
                        <p>Employee name: <span>' . $import_invoice_details["fullname"] . '</span></p>
                        <p><span>' . $import_invoice_details["created_at"] . '</span></p>
                  </div>

                  <div class="import-invoice-container__body-bottom">
                        <table style="border-collapse: collapse;">
                              <thead>
                                    <th style="text-align: left; padding-left: 16px;">Product name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total price</th>
                              </thead>
                              <tbody>';

  if (!empty($import_products_invoice)) {
    foreach ($import_products_invoice as $import_product) {
      $html .= '
              <tr style="line-height: 3;">
                    <td style="padding-left: 16px;">' . $import_product["title"] . '</td>
                    <td style="text-align: center;">' . $import_product["amount"] . '</td>
                    <td style="text-align: center;">' . $import_product["price"] . '</td>
                    <td style="text-align: center;">' . $import_product["total_price"] . '</td>
              </tr>';
    }
  }

  $html .= '
              <tr style="line-height: 3; background-color: #1f7a77; color: #fff;">
                    <td colspan="3" style="padding-left: 16px;">Total</td>
                    <td style="text-align: center;">' . $import_invoice_details["total_import_order"] . '</td>
              </tr>
            </tbody>
      </table>
      </div>
      </div>

      <div class="import-invoice-container__footer">
        <p class="import-invoice-container__footer-payment">Payment Information: <span>Credit cards</span></p>
        <p class="import-invoice-container__footer-phonenumber">Phone number: <span>0948800917</span></p>
        <p class="import-invoice-container__footer-address">Address: <span>Đại học Sài Gòn, Quận 5, tp Hồ Chí Minh</span></p>
      </div>
    </div>';

  echo $html;
}

// Search input invoice
if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "import_invoice") {
  $searchInput = trim($_POST["searchInput"]);
  $searchValue = trim($_POST["searchValue"]);

  $import_invoice_list = $admin->searchInputInvoices($searchInput, $searchValue);

  $html = !empty($import_invoice_list) ? "" : "No import invoice found";

  $del_icon = checkPermission("Delete imports", $admin) ? '<span class="fa-solid fa-trash del-importbtn" name="del-import" value="del-import"></span>' : "";

  if (!empty($import_invoice_list)) {
    foreach ($import_invoice_list as $import_invoice) {
      $html .= '
      <tr class="row-import-invoice" data-import_invoiceid="' . $import_invoice["import_id"] . '">
        <td>' . $import_invoice["import_id"] . '</td>
        <td>' . $import_invoice["fullname"] . '</td>
        <td>' . $import_invoice["created_at"] . '</td>
        <td>' . $import_invoice["total_import_order"] . '</td>
        <td>' . $del_icon . '</td>
      </tr>
      ';
    }
  }

  echo $html;
}

if (isset($_POST["fromDate"]) && isset($_POST["toDate"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "search_input_invoice_date") {
  $fromDate = trim($_POST["fromDate"]);
  $toDate = trim($_POST["toDate"]);

  $import_invoice_list = $admin->search_input_invoice_by_date($fromDate, $toDate);

  $html = !empty($import_invoice_list) ? "" : "No import invoice found";

  $del_icon = checkPermission("Delete imports", $admin) ? '<span class="fa-solid fa-trash del-importbtn" name="del-import" value="del-import"></span>' : "";

  if (!empty($import_invoice_list)) {
    foreach ($import_invoice_list as $import_invoice) {
      $html .= '
      <tr class="row-import-invoice" data-import_invoiceid="' . $import_invoice["import_id"] . '">
        <td>' . $import_invoice["import_id"] . '</td>
        <td>' . $import_invoice["fullname"] . '</td>
        <td>' . $import_invoice["created_at"] . '</td>
        <td>' . $import_invoice["total_import_order"] . '</td>
        <td>' . $del_icon . '</td>
      </tr>
      ';
    }
  }

  echo $html;
}

// 
if (isset($_POST["exitnewimport"]) && isset($_SESSION["import_products"])) {
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }

  unset($_SESSION["import_products"]);
}

// =============================================== CONTACT ===============================================

// Delete
if (isset($_POST["contact_id"]) && isset($_POST["type"]) && $_POST["type"] == "del_contact") {
  $contactId = $_POST["contact_id"];

  $isDeleted = $admin->deleteContactById($contactId);

  if ($isDeleted) {
    echo 1;
  } else {
    echo 0;
  }
}

// Search 
if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "contact") {
  $searchInput = $_POST["searchInput"];
  $searchValue = $_POST["searchValue"];

  $searchedContacts = $admin->searchContacts($searchInput, $searchValue);

  $html = !empty($searchedContacts) ? "" : "No contact found";

  $delIcon = checkPermission("Delete contacts", $admin) ? '<span class="fa-solid fa-trash del-contactbtn" name="del-contact" value="del-contact"></span>' : "";

  if (!empty($searchedContacts)) {
    foreach ($searchedContacts as $contact) {
      $html .= '
      <tr data-contactid="' . $contact["contact_id"] . '">
            <td>' . $contact["contact_id"] . '</td>
            <td>' . $contact["fullname"] . '</td>
            <td>' . $contact["email"] . '</td>
            <td>' . $contact["phone_number"] . '</td>
            <td>' . $contact["content"] . '</td>
            <td>' . $delIcon . '</td>
      </tr>
      ';
    }
  }

  echo $html;
}

// Show content
if (isset($_POST["contactId"]) && isset($_POST["type"]) && $_POST["type"] == "showContent") {
  $contactId = $_POST["contactId"];

  $contact = $admin->getContactById($contactId);

  $html = '
    <div class="overlay"></div>
    <div class="content-popup">
          <div class="content-msg">
            ' . $contact["content"] . '
          </div>
    </div>
  ';

  echo $html;
}
