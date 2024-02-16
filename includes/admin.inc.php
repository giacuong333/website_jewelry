<?php

include("../server/connection/connect.s.php");
include("../server/models/adminmodel.s.php");
include("../server/controllers/admincontr.s.php");

$admin = new AdminController();
$products = $admin->getAllProducts();
$users = $admin->getAllUsers();
$orders = $admin->getOrders();
$categories = $admin->getCategories();

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

// Handling when admin searches
if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "user") {
  $searchValue = trim($_POST["searchValue"]);
  $searchInput = trim($_POST["searchInput"]);

  $userContainer = $admin->searchUsers($searchInput, $searchValue);

  $html = "";

  foreach ($userContainer as $user) {
    $html .= "
                              <tr data-userid='{$user['id']}'>
                                        <td>{$user['id']}</td>
                                        <td>{$user['fullname']}</td>
                                        <td>{$user['email']}</td>
                                        <td>{$user['phone_number']}</td>
                                        <td>{$user['name']}</td>
                                        <td>{$user['created_at']}</td>
                                        <td>{$user['updated_at']}</td>
                                        <td>
                                                  <span class='fa-solid fa-pen-to-square edit-userbtn' name='editbtn' value='editbtn'></span>
                                                  <span class='fa-solid fa-trash del-userbtn' name='delbtn' value='delbtn'></span>
                                        </td>
                              </tr>
                    ";
  }

  echo $html;
}

// =============================================== PRODUCT ===============================================

// Save a product
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
    $uploadDir = "../assets/imgs/";
    if ($categoryid == 1) {
      $uploadDir .= "rings/";
    } else if ($categoryid == 2) {
      $uploadDir .= "necklaces/";
    } else if ($categoryid == 3) {
      $uploadDir .= "brooches/";
    } else if ($categoryid == 4) {
      $uploadDir .= "earrings/";
    }
    $imagepath = $uploadDir . basename($_FILES["imagepath"]["name"]);
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
    $uploadDir = "../assets/imgs/";
    if ($categoryid == 1) {
      $uploadDir .= "rings/";
    } else if ($categoryid == 2) {
      $uploadDir .= "necklaces/";
    } else if ($categoryid == 3) {
      $uploadDir .= "brooches/";
    } else if ($categoryid == 4) {
      $uploadDir .= "earrings/";
    }
    $imagepath = $uploadDir . basename($_FILES["imagepath"]["name"]);
  }

  $isUpdated = $admin->updateProductById($productId, $imagepath, $title, $categoryid, $price, $discount, $description, $isShow, $isOutstanding, $isNew);

  if ($isUpdated) {
    echo "<script>alert('Update the product successfully')</script>";
    echo "<script>window.location.href='../admin/productmanager.php'</script>";
  } else {
    echo "<script>alert('Update the product failed')</script>";
  }
}

if (isset($_POST["searchInput"]) && isset($_POST["searchValue"]) && isset($_POST["searchType"]) && $_POST["searchType"] == "product") {
  $searchProductInput = trim($_POST["searchInput"]);
  $searchProductValue = trim($_POST["searchValue"]);

  $products = $admin->searchProducts($searchProductInput, $searchProductValue);

  $html = isset($products) ? "No product found" : "";

  foreach ($products as $product) {
    $isOutstanding = $product['isOutstanding'] == 1 ? "checked" : "";
    $isNew = $product['isNew'] == 1 ? "checked" : "";
    $isShow = $product['isShow'] == 1 ? "checked" : "";
    $html .= "
        <tr data-productid='{$product['id']}'>
            <td>{$product['id']}</td>
            <td>{$product['name']}</td>
            <td>{$product['title']}</td>
            <td><img src=' {$product['thumbnail']}' alt='Product image' /></td>
            <td><p> {$product['price']}</p></td>
            <td><input type='checkbox' disabled {$isOutstanding} name='outstanding'/></td>
            <td><input type='checkbox' disabled {$isNew} name='isNew'/></td>
            <td><input type='checkbox' disabled {$isShow} name='isShow'/></td>
            <td>
                <span class='fa-solid fa-pen-to-square edit-productbtn'></span>
                <span class='fa-solid fa-trash del-productbtn' name='del-product' value='del-product'></span>
            </td>
        </tr>
        ";
  }

  echo $html;
}

// =============================================== ORDER ===============================================
// Order details
if (isset($_GET["orderId"])) {
  $orderDetails = [];
  $orderId = $_GET["orderId"];

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

                <div class='content-body__middle'>
                  <div class='content-body__middle-product'>
                    <div class='content-body__middle-product-image'><img src='{$orderDetails['thumbnail']}' alt='Product Image'></div>
                    <div class='content-body__middle-product-info'>
                      <div class='content-body__middle-product-name'>{$orderDetails['title']} <span>({$orderDetails['num']})</span></div>
                      <div class='content-body__middle-product-price'>{$orderDetails['price']}</div>
                    </div>
                  </div>
                  <div class='content-body__middle-product'>
                    <div class='content-body__middle-product-image'><img src='{$orderDetails['thumbnail']}' alt='Product Image'></div>
                    <div class='content-body__middle-product-info'>
                      <div class='content-body__middle-product-name'>{$orderDetails['title']} <span>({$orderDetails['num']})</span></div>
                      <div class='content-body__middle-product-price'>{$orderDetails['price']}</div>
                    </div>
                  </div>
                  <div class='content-body__middle-product'>
                    <div class='content-body__middle-product-image'><img src='{$orderDetails['thumbnail']}' alt='Product Image'></div>
                    <div class='content-body__middle-product-info'>
                      <div class='content-body__middle-product-name'>{$orderDetails['title']} <span>({$orderDetails['num']})</span></div>
                      <div class='content-body__middle-product-price'>{$orderDetails['price']}</div>
                    </div>
                  </div>
                  <div class='content-body__middle-product'>
                    <div class='content-body__middle-product-image'><img src='{$orderDetails['thumbnail']}' alt='Product Image'></div>
                    <div class='content-body__middle-product-info'>
                      <div class='content-body__middle-product-name'>{$orderDetails['title']} <span>({$orderDetails['num']})</span></div>
                      <div class='content-body__middle-product-price'>{$orderDetails['price']}</div>
                    </div>
                  </div>

                  <div class='content-body__middle-shipping'>
                    <p class='content-body__middle-shipping-name'>Shipping</p>
                    <p class='content-body__middle-shipping-price'>40000</p>
                  </div>
                </div>

                <div class='content-body__bottom'>
                  <p class='content-body__bottom-total'>{$orderDetails['total_money']}</p>
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

// Status 
if (isset($_POST["orderId"]) && isset($_POST["orderStatus"])) {
  $orderId = $_POST["orderId"];
  $isSaved = $admin->saveStatus($orderId);

  echo $isSaved ? true : false;
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

  $orders = $admin->searchOrders($searchInput, $searchValue);
  $html = "";

  if (isset($orders)) {
    foreach ($orders as $order) {
      $status = $order["orderstatus"] == 1 ? "Đã xử lý" : "Đang xử lý";

      $html .= "
      <tr class='row-order' data-orderid='{$order['orderid']}'>
        <td>{$order['orderid']}</td>
        <td>{$order['fullname']}</td>
        <td>{$order['orderemail']}</td>
        <td>{$order['orderphone']}</td>
        <td class='status'>
          <button type='button' name='statusBtn' value='{$order['orderstatus']}' class='btn- btn--hover'>$status</button>
        </td>
        <td>{$order['total_money']}</td>
        <td>
          <span class='fa-solid fa-trash del-orderbtn' name='del-order' value='del-order'></span>
        </td>
      </tr>";
    }
  } else {
    $html .= "No order found";
  }

  echo $html;
}

// Search order by date
if (isset($_POST["fromDate"]) && isset($_POST["toDate"])) {
  $fromDate = $_POST["fromDate"];
  $toDate = $_POST["toDate"];

  $orders = $admin->searchOrdersByDate($fromDate, $toDate);

  $html = "";

  if (isset($orders)) {
    foreach ($orders as  $order) {
      $status = $order["orderstatus"] == 1 ? "Đã xử lý" : "Đang xử lý";

      $html .= "
        <tr class='row-order' data-orderid='{$order['orderid']}'>
          <td>{$order['orderid']}</td>
          <td>{$order['orderfullname']}</td>
          <td>{$order['orderemail']}</td>
          <td>{$order['orderphone']}</td>
          <td class='status'>
            <button type='button' name='statusBtn' value='{$order['orderstatus']}' class='btn- btn--hover'>$status</button>
          </td>
          <td>{$order['total_money']}</td>
          <td>
            <span class='fa-solid fa-trash del-orderbtn' name='del-order' value='del-order'></span>
          </td>
        </tr>";
    }
  } else {
    $html .= "No orders found";
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

// 
if (isset($_GET["editcategory_id"])) {
  $categoryId = $_GET["editcategory_id"];
  $categoriesId = $admin->getCategoryById($categoryId);
}
