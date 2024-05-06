<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Thông tin khách hàng</title>


      <!-- Fontawesome -->
      <link rel="stylesheet" href="../assets/icons/css/all.min.css">

      <!-- CDN Boostrap Css -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

      <!-- CDN Boostrap Js  -->
      <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

      <!-- CSS -->
      <link rel="stylesheet" href="../assets/css/config.css">
      <link rel="stylesheet" href="../assets/css/customerinfo.css">

      <!-- JQUERY -->
      <script src="../assets/libs/jquery-3.7.1.min.js"></script>

      <!-- Js -->
      <script src="../js/customerinfo.js" type="module"></script>
</head>

<body>
      <?php include_once("./header.php") ?>

      <div class="container customerinfo-wrap">
            <div class="row">
                  <div class="header my-5">
                        <a href="../templates/trangchu.php">Trang chủ</a> >
                        <span style="color: #7fcbc9; font-weight: 600;"> Thông tin khách hàng</span>
                  </div>
            </div>
            <!-- Content -->
            <section class="mt-3">
                  <div class="row">
                        <div class="col-md-3">
                              <h5 class="customerinfo-header" style="letter-spacing: 2px;">
                                    TRANG TÀI KHOẢN
                              </h5>
                              <p style="font-weight: 600; font-size: 14px;"><?php echo 'Xin chào, ' . $_SESSION["fullname"] . '!'; ?></p>
                              <div class="btns-group">
                                    <button type="button" class="btn" data-customerinfo__info>Thông tin tài khoản</button>
                                    <button type="button" class="btn" data-customerinfo__orders>Đơn hàng của bạn</button>
                                    <button type="button" class="btn" data-customerinfo__changepwd>Đổi mật khẩu</button>
                                    <button type="button" class="btn" data-customerinfo_address>Sổ địa chỉ (0)</button>
                              </div>
                        </div>
                        <div class="col-md-9 ps-md-5">
                              <h5 class="customerinfo-header" style="letter-spacing: 2px;">
                                    THÔNG TIN TÀI KHOẢN
                              </h5>
                              <div class="customerinfo-content">
                                    <div class="customerinfo__info d-none">
                                          <span style="font-weight: 600; font-size: 16px;">Họ tên: </span><span style="font-size: 14px;"><?php echo $_SESSION["fullname"]; ?></span>
                                          <br />
                                          <span style="font-weight: 600; font-size: 16px;">Email: </span><span style="font-size: 14px;"><?php echo $_SESSION["useremail"]; ?></span>
                                    </div>

                                    <div class="customerinfo__orders d-none">
                                          <table class="table table-striped">
                                                <thead style="background-color: #7fcbc9; color: #fff;">
                                                      <tr class="text-center">
                                                            <th>Đơn hàng</th>
                                                            <th>Ngày</th>
                                                            <th>Địa chỉ</th>
                                                            <th>Giá trị đơn hàng</th>
                                                            <th>TT thanh toán</th>
                                                            <th>TT vận chuyển</th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                      <tr>
                                                            Không có đơn hàng nào
                                                      </tr>
                                                </tbody>
                                          </table>
                                    </div>

                                    <div class="customerinfo__changepwd d-none">
                                          <div class="form-group">
                                                <label for="oldpwd" style="font-weight: 600;">Mật khẩu cũ<span class="text-danger"> *</span></label>
                                                <input type="password" id="oldpwd" class="w-50">
                                                <div class="error-message"></div>
                                          </div>
                                          <div class="form-group">
                                                <label for="newpwd" style="font-weight: 600;">Mật khẩu mới<span class="text-danger"> *</span></label>
                                                <input type="password" id="newpwd" class=" w-50">
                                                <div class="error-message"></div>
                                          </div>
                                          <div class="form-group">
                                                <label for="verifypwd" style="font-weight: 600;">Xác nhận lại mật khẩu<span class="text-danger"> *</span></label>
                                                <input type="password" id="verifypwd" class=" w-50">
                                                <div class="error-message"></div>
                                          </div>
                                          <button type="button" class="btn btn-outline-none resetpwd-btn" style="color: #fff; background-color: #7fcbc9;">Đặt lại mật khẩu</button>
                                    </div>

                                    <div class="customerinfo_address d-none">
                                          <button type="button" class="btn btn-outline-none" style="color: #fff; background-color: #7fcbc9;">Thêm địa chỉ</button>
                                    </div>
                              </div>
                        </div>
                  </div>
            </section>
      </div>

      <?php include_once("./footer.php") ?>
</body>

</html>