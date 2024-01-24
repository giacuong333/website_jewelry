<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8" />
          <meta name="viewport" content="width=device-width, initial-scale=1.0" />
          <script src="../assets/libs/jquery-3.7.1.min.js"></script>
          <link rel="stylesheet" href="../assets/icons/css/all.min.css">
          <link rel="stylesheet" href="../assets/css/config.css">
          <link rel="stylesheet" href="../assets/css/signup.css">
          <title>Sign up</title>
</head>

<body>
          include()
          <main>
                    <div class="header">
                              <a href="../index.php">Trang chủ > </a>
                              <p> Đăng ký tài khoản</p>
                    </div>

                    <div class="content">
                              <div class="content-left">
                                        <div class="top">
                                                  <h3>ĐĂNG KÝ TÀI KHOẢN</h3>
                                                  <div class="loginby">
                                                            <i class="fa-brands fa-facebook-f"><span>Facebook</span></i>
                                                            <i class="fa-brands fa-google"><span>Google</span></i>
                                                  </div>
                                                  <p>Nếu chưa có tài khoản vui lòng đăng ký tại đây</p>
                                        </div>
                              </div>
                              <div class="content-right">
                                        <form action="../includes/signup.inc.php" method="post">
                                                  <div class="left">
                                                            <div class="form-group">
                                                                      <label for="fullname" style="font-weight: 600;">Họ tên
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <input type="text" id="fullname" name="fullname" placeholder="Fullname" required />
                                                            </div>

                                                            <div class="form-group">
                                                                      <label for="email" style="font-weight: 600;">Email
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <input type="email" id="email" name="email" placeholder="Email" required />
                                                            </div>

                                                            <div class="form-group">
                                                                      <label for="phone_number" style="font-weight: 600;">Số điện thoại
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <input type="text" id="phone_number" name="phone_number" placeholder="Phone number" required />
                                                            </div>
                                                            <button type="submit" class="btn btn--active" name="signup" value="signup">ĐĂNG KÝ</button>
                                                            <a href="./login.php">Đăng nhập</a>
                                                  </div>

                                                  <div class="right">
                                                            <div class="form-group">
                                                                      <label for="password" style="font-weight: 600;">Mật
                                                                                khẩu
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <input type="password" id="password" name="password" placeholder="Password" required />
                                                            </div>

                                                            <div class="form-group">
                                                                      <label for="verifyPass" style="font-weight: 600;">Xác nhận mật khẩu
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <input type="password" id="verifyPass" name="verifyPass" placeholder="Verify password" required />
                                                            </div>

                                                            <!-- <div class="form-group">
                                                                      <label for="selectRole" style="font-weight: 600;">Chọn quyền
                                                                                <span style="color:red;">*</span>
                                                                      </label>
                                                                      <select name="role" id="selectRole">
                                                                                <option value="1">Quản lý</option>
                                                                                <option value="2">Nhân viên</option>
                                                                      </select>
                                                            </div> -->

                                                  </div>
                                        </form>
                              </div>
                    </div>
          </main>
</body>

</html>