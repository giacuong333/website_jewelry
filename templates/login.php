<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Login</title>

	<!-- CSS -->
	<link rel="stylesheet" href="../assets/css/config.css">
	<link rel="stylesheet" href="../assets/css/login.css">

	<!-- JQUERY -->
	<script src="../assets/libs/jquery-3.7.1.min.js"></script>

	<!-- Js -->
	<script src="../js/login.js" type="module"></script>
</head>

<body>
	<?php
	include_once("../includes/login.inc.php");
	include_once("../templates/header.php");
	?>

	<main id="login-main" class="container mt-xs-5">
		<div class="row">
			<div class="header">
				<a href="../index.php">Trang chủ</a> >
				<p> Đăng nhập tài khoản</p>
			</div>

			<div class="content d-md-grid d-block">
				<div class="content-left">
					<div class="top">
						<h3>ĐĂNG NHẬP TÀI KHOẢN</h3>
						<div class="loginby">
							<i class="fa-brands fa-facebook-f mb-md-0 mb-2 "><span>Facebook</span></i>
							<i class="fa-brands fa-google"><span>Google</span></i>
						</div>
						<p class="mt-4">Nếu bạn đã có tài khoản, đăng nhập tại đây.</p>
					</div>

					<div class="middle">
						<form action="../includes/login.inc.php" method="post">
							<div class="form-group">
								<label for="useremail" style="font-weight: 600;">Email
									<span style="color:red;">*</span>
								</label>
								<input type="email" id="useremail" name="useremail" placeholder="Email" required />
								<span class="error-message"></span>
							</div>

							<div class="form-group">
								<label for="password" style="font-weight: 600;">Mật khẩu
									<span style="color:red;">*</span>
								</label>
								<input type="password" id="password" name="password" placeholder="Password" required />
								<span class="error-message"></span>
							</div>

							<button type="button" class="btn btn--active btn-login" name="login" value="login" style="color: #fff!important;">ĐĂNG NHẬP</button>
							<a href="./signup.php">Đăng ký</a>
						</form>
					</div>

				</div>
				<div class="content-right">
					<div class="top">

						<?php
						if (!isset($_GET["success"])) {
						?>

							<p>Bạn quên mật khẩu? Nhập địa chỉ email để lấy lại mật khẩu qua email</p>

						<?php
						} else {
						?>

							<p>Nhập code để đổi mật khẩu mới</p>

						<?php
						}
						?>

						<form action="../includes/forgetpassword.inc.php" method="post">

							<?php
							if (!isset($_GET["success"])) {
							?>

								<div class="form-group">
									<label for="useremail" style="font-weight: 600;">Email
										<span style="color:red;">*</span>
									</label>

									<input type="email" id="forgotuseremail" name="forgotuseremail" placeholder="Email" />

									<?php
									if (isset($_GET["error"]) && $_GET["error"] == "wrongemail") {
										echo '<span class="error-message">Email không tồn tại</span>';
									} else if (isset($_GET["error"]) && $_GET["error"] == "emptyinput") {
										echo '<span class="error-message">Vui lòng nhập email đã đăng ký</span>';
									} else {
										echo '<span class="error-message"></span>';
									}
									?>

								</div>

								<button type="submit" class="btn btn--active" name="getformerpassword" value="getformerpassword" style="color: #fff">LẤY LẠI MẬT KHẨU</button>

							<?php
							}
							?>

							<?php
							if (isset($_GET["success"]) && $_GET["success"] == "newpasswordsent") {
							?>

								<div class="form-group">
									<label for="useremail" style="font-weight: 600;">Code
										<span style="color:red;">*</span>
									</label>

									<input type="text" id="reset_token" name="reset_token" placeholder="Passcode" />

									<div class="error-message"></div>

									<button type="button" style="display: inline-block;" class="btn btn--active text-white" name="confirmpasscode" value="confirmpasscode">XÁC NHẬN</button>

									<button style="border:none; background-color: transparent; font-size: 16px; cursor: pointer;" type="submit" name="sendcode" value="sendcode">Send code again</button>
								</div>

							<?php
							}
							?>

						</form>
					</div>
				</div>
			</div>
		</div>
	</main>

	<?php include_once("../templates/footer.php") ?>
</body>

</html>