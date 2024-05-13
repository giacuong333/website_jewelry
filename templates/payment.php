<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Login</title>

      <!-- CSS -->
      <link rel="stylesheet" href="../assets/css/config.css">
      <link rel="stylesheet" href="../assets/css/payment.css">

      <!-- JQUERY -->
      <script src="../assets/libs/jquery-3.7.1.min.js"></script>

      <!-- Js -->
      <script src="../js/payment.js" type="module" defer></script>

      <!-- Fontawesome -->
      <link rel="stylesheet" href="../assets/icons/css/all.min.css">

      <!-- CDN Boostrap Css -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

      <!-- CDN Boostrap Js  -->
      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

      <?php
      session_start();
      $productList = $_SESSION["cart"];
      $totalOfOrder = 0;
      foreach ($productList as $product) {
            $totalOfOrder += (intval($product['customer_quantity']) * intval($product['price']));
      }
      $totalOfOrderHasFee = $totalOfOrder +  intval(40000);

      // User info 
      if (isset($_SESSION['id'], $_SESSION['fullname'], $_SESSION['email'], $_SESSION['phone_number'])) {
            $userid = $_SESSION['id'];
            $userFullName = $_SESSION['fullname'];
            $userEmail =  $_SESSION['email'];
            $userPhoneNumber = $_SESSION['phone_number'];
      }
      ?>
</head>

<body>
      <input type="text" name="userid" data-userid="<?php echo isset($_SESSION['id']) ? $_SESSION['id'] : 'none'; ?>" hidden>
      <form action="../includes/payment.inc.php" method="POST" class="main">
            <div class="container-fluid">
                  <div class="row ps-5" style=" height: 100vh;">
                        <div class="col-lg-8 col-md-8 mt-4">
                              <div class="row mb-4" style="width: 24%; cursor:pointer">
                                    <img src="../assets/imgs/brand/logo.png" id="homepage" alt="" class="w-100 h-100">
                              </div>
                              <div class="row">
                                    <div class="col-lg-6 col-md-6 me-4">
                                          <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span style="font-size: 18px; font-weight: 600;">Thông tin nhận hàng</span>
                                                <a href="../templates/login.php" style="color: #7fcbc9;"><i class="fa-solid fa-user"></i> Đăng nhập</a>
                                          </div>
                                          <div class="row">
                                                <input type="text" hidden name="userid" value="<?php echo $userId; ?>">
                                                <div class="form-group">
                                                      <input type="email" name="email" class="form-control" placeholder="Email *" value="<?php echo isset($userEmail) ? $userEmail : ""; ?>">
                                                      <div class="error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                      <input type="text" name="fullname" class="form-control" placeholder="Full name *" value="<?php echo isset($userFullName) ? $userFullName : ""; ?>">
                                                      <div class="error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                      <input type="text" name="phonenumber" class="form-control" placeholder="Phone number *" value="<?php echo isset($userPhoneNumber) ? $userPhoneNumber :  ""; ?>">
                                                      <div class="error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                      <input type="text" name="province" class="form-control" placeholder="Province *">
                                                      <div class="error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                      <input type="text" name="district" class="form-control" placeholder="District *">
                                                      <div class="error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                      <input type="text" name="address" class="form-control" placeholder="Address *">
                                                      <div class="error-message"></div>
                                                </div>
                                                <div class="form-group">
                                                      <textarea name="note" class="form-control" placeholder="Note (Optional)"></textarea>
                                                      <div class="error-message"></div>
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5">
                                          <div class="row mb-4">
                                                <p style="font-size: 18px; font-weight: 600;" class="mb-2 p-0">Vận chuyển</p>
                                                <div class="form-control p-3 d-flex align-items-center justify-content-between">
                                                      <span class="d-flex align-items-center"><input type="radio" checked style="width: 20px; height: 18px;" id="delivery" /><label for="delivery" class="ms-2">Delivery to your doorstep</label></span>
                                                      <span>40000</span>
                                                </div>
                                          </div>

                                          <div class="row">
                                                <p style="font-size: 18px; font-weight: 600;" class="mb-2 p-0">Thanh toán</p>
                                                <div class="form-control p-3 d-flex align-items-center justify-content-between">
                                                      <span class="d-flex align-items-center"><input type="radio" checked style="width: 20px; height: 18px;" id="cash_on_delivery" /><label for="cash_on_delivery" class="ms-2">Cash on delivery (COD)</label></span>
                                                      <i class="fa-solid fa-money-bill-1-wave" style="color:#7fcbc9; font-size: 20px;"></i>
                                                </div>
                                          </div>
                                    </div>

                              </div>
                        </div>

                        <div class="col-lg-4 col-md-4 border-start pe-5" style="background-color: #fafafa;">
                              <div class="row border-bottom ps-4 py-3" style="font-size: 20px; font-weight: 700">Order (<?php echo count($productList); ?> product(s))</div>
                              <div class="ps-4">
                                    <div class="row py-3 border-bottom mb-3" style="max-height: calc(100vh - 480px); overflow-y: scroll;">
                                          <!-- Products -->
                                          <?php
                                          foreach ($productList as $product) {
                                          ?>
                                                <div class="p-0 d-flex justify-content-between align-items-center mb-2" data-productid="<?php echo $product['id']; ?>">
                                                      <div class="">
                                                            <img src="<?php echo $product['thumbnail']; ?>" class="border rounded-3" alt="" width="50" height="50">
                                                            <span><?php echo $product['title']; ?></span>
                                                            <span>(<?php echo $product['customer_quantity']; ?>)</span>
                                                      </div>
                                                      <div class=""><?php echo $product['price']; ?></div>
                                                </div>
                                          <?php
                                          }
                                          ?>
                                    </div>
                                    <div class="row pb-3 border-bottom mb-3">
                                          <input type="text" class="form-control" placeholder="Enter discount code" style="width: 68%" />
                                          <button type="button" class="btn btn-primary p-2 mb-0 ms-auto" style="width: 30%; background-color: #7fcbc9; border: none;">Apply</button>
                                    </div>
                                    <div class="row pb-3 border-bottom mb-3">
                                          <div class="calculate_temp d-flex justify-content-between align-items-center mb-1 text-muted">
                                                <span>Provisional</span>
                                                <span><?php echo $totalOfOrder; ?></span>
                                          </div>
                                          <div class="delivery_fee d-flex justify-content-between align-items-center text-muted">
                                                <span>Delivery fee</span>
                                                <span>40000</span>
                                          </div>
                                    </div>
                                    <div class="row">
                                          <div class="total_order  d-flex justify-content-between align-items-center text-muted">
                                                <span style="font-size: 18px;">Total</span>
                                                <span style="color: #7fcbc9; font-size: 22px; font-weight: 600"><?php echo $totalOfOrderHasFee; ?></span>
                                          </div>
                                    </div>
                                    <div class="row pb-3 mb-3">
                                          <div class="back_to_cart d-flex justify-content-between align-items-center">
                                                <a href="#" style="color: #7fcbc9;">Back to cart</a>
                                                <button type="button" name="place-order" value="place-order" class="btn btn-primary" style="background-color: #7fcbc9; border: none; padding: 12px 16px;">PLACE ORDER</button>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </form>

</body>

</html>