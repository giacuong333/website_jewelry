<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Jquery -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>

    <!-- Fontawesome -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">

    <!-- Css -->
    <link rel="stylesheet" href="../assets/css/signup.css">
    <link rel="stylesheet" href="../assets/css/cart.css">

    <!-- Js -->
    <script src="../js/signup.js" type="module"></script>
    <script src="../js/cart.js"></script>

    <title>Sign up</title>
</head>

<body>
    <?php include_once("../templates/header.php") ?>

    <div class="container">
        <div class="row">
            <main id="register-main" class="mt-xs-5">
                <div class="header my-0">
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
                            <p class="mt-4">Nếu chưa có tài khoản vui lòng đăng ký tại đây</p>
                        </div>
                    </div>
                    <div class="content-right">
                        <form action="../includes/signup.inc.php" method="post" class="d-md-grid d-block">
                            <div class="left">
                                <div class="form-group">
                                    <label for="fullname" style="font-weight: 600;">Họ tên
                                        <span style="color:red;">*</span>
                                    </label>
                                    <input type="text" id="fullname" name="fullname" placeholder="Fullname" required />
                                    <span class="error-message"></span>
                                </div>

                                <div class="form-group">
                                    <label for="email" style="font-weight: 600;">Email
                                        <span style="color:red;">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" placeholder="Email" required />
                                    <span class="error-message"></span>
                                </div>

                                <div class="form-group">
                                    <label for="phone_number" style="font-weight: 600;">Số điện thoại
                                        <span style="color:red;">*</span>
                                    </label>
                                    <input type="text" id="phone_number" name="phone_number" placeholder="Phone number" required />
                                    <span class="error-message"></span>
                                </div>

                                <div class="btn-gr d-md-block d-none">
                                    <button type="button" class="btn btn--active btn-signup" name="signup" value="signup" style="color: #fff !important;">ĐĂNG KÝ</button>
                                    <a style="margin-left: 12px;" href="./login.php">Đăng nhập</a>
                                </div>
                            </div>

                            <div class="right">
                                <div class="form-group">
                                    <label for="password" style="font-weight: 600;">Mật
                                        khẩu
                                        <span style="color:red;">*</span>
                                    </label>
                                    <input type="password" id="password" name="password" placeholder="Password" required />
                                    <span class="error-message"></span>
                                </div>

                                <div class="form-group">
                                    <label for="verifyPass" style="font-weight: 600;">Xác nhận mật khẩu
                                        <span style="color:red;">*</span>
                                    </label>
                                    <input type="password" id="verifyPass" name="verifyPass" placeholder="Verify password" required />
                                    <span class="error-message"></span>
                                </div>

                                <!-- Small screen -->
                                <div class="btn-gr d-block d-md-none">
                                    <button type="button" class="btn btn--active btn-signup" name="signup" value="signup" style="color: #fff !important;">ĐĂNG KÝ</button>
                                    <a style="margin-left: 12px;" href="./login.php">Đăng nhập</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <?php include_once("../templates/footer.php") ?>

    <!-- Cart -->
    <?php include_once("./cart.php"); ?>
</body>

</html>