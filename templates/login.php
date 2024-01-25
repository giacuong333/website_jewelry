<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <script src="../assets/libs/jquery-3.7.1.min.js"></script>
          <link rel="stylesheet" href="../assets/icons/css/all.min.css">
          <link rel="stylesheet" href="../assets/css/config.css">
          <link rel="stylesheet" href="../assets/css/login.css">
          <title>Log in</title>
</head>

<body>
          <?php include("../templates/header.php") ?>

          <main>
                    <div class="header">
                              <a href="../index.php">Trang chủ > </a>
                              <p> Đăng nhập tài khoản</p>
                    </div>

                    <div class="content">
                              <div class="content-left">
                                        <div class="top">
                                                  <h3>ĐĂNG NHẬP TÀI KHOẢN</h3>
                                                  <div class="loginby">
                                                            <i class="fa-brands fa-facebook-f"><span>Facebook</span></i>
                                                            <i class="fa-brands fa-google"><span>Google</span></i>
                                                  </div>
                                                  <p>Nếu bạn đã có tài khoản, đăng nhập tại đây.</p>
                                        </div>

                                        <div class="middle">
                                                  <form action="../includes/login.inc.php" method="post">
                                                            <div class="form-group">
                                                                      <label for="useremail" style="font-weight: 600;">Email
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <input type="email" id="useremail" name="useremail" placeholder="Email" required />
                                                            </div>

                                                            <div class="form-group">
                                                                      <label for="password" style="font-weight: 600;">Mật khẩu
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <input type="password" id="password" name="password" placeholder="Password" required />
                                                            </div>

                                                            <button type="submit" class="btn btn--active" name="login" value="login">ĐĂNG NHẬP</button>
                                                            <a href="./signup.php">Đăng ký</a>
                                                  </form>
                                        </div>

                              </div>
                              <div class="content-right">
                                        <div class="top">
                                                  <p>Bạn quên mật khẩu? Nhập địa chỉ email để lấy lại mật khẩu qua email</p>
                                                  <form action="" method="post">
                                                            <div class="form-group">
                                                                      <label for="useremail" style="font-weight: 600;">Email
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <input type="email" id="useremail" name="useremail" placeholder="Email" required />
                                                            </div>

                                                            <button type="submit" class="btn btn--active" name="getpassword" value="getpassword">LẤY LẠI MẬT KHẨU</button>
                                                  </form>
                                        </div>
                              </div>
                    </div>
          </main>

          <?php include("../templates/footer.php") ?>
          <!-- <script src="./js/login.js"></script> -->
</body>

</html>