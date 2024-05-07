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
					<p style="font-weight: 600; font-size: 14px;">Xin chào, <span style="color: #7fcbc9; font-weight: 700"><?php echo '' . $_SESSION["fullname"] . '!'; ?></span></p>
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
										<th>Tổng tiền</th>
										<th>Trạng thái</th>
									</tr>
								</thead>
								<tbody class="customerinfo__orders-tbody">
									<!-- Using JavaScript to render -->
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

						<!-- Order details -->
						<div class="customerinfo_orderdetails">
							<!-- <div class="d-flex align-items-center justify-content-between">
								<h5>Chi tiết đơn hàng #001</h5>
								<p>Ngày tạo: 12-10-2003</p>
							</div>
							<div>
								<span class="me-5" style="font-size:14px">Trạng thái thanh toán: <i style="font-weight: 600; font-size: 16px; color:red">Chưa thanh toán</i></span>
								<span style="font-size:14px">Trạng thái vận chuyển: <i style="font-weight: 600; font-size: 16px; color:red">Chưa giao hàng</i></span>
							</div>
							<div class="container mt-4">
								<div class="row">
									<div class="col-lg-7 col-12 ps-0">
										<p class="m-0">ĐỊA CHỈ GIAO HÀNG</p>
										<div class="box">
											<p>NHUNG VY</p>
											<p>Địa chỉ: Phú Định, P16, Q8, TP HỒ CHÍ MINH</p>
											<p>Số điện thoại: +84948800917</p>
										</div>
									</div>
									<div class="col-lg-2 col-12">
										<p class="m-0">THANH TOÁN</p>
										<div class="box">
											<p>Thanh toán khi giao hàng (COD)</p>
										</div>
									</div>
									<div class="col-lg-3 col-12 pe-0">
										<p class="m-0">GHI CHÚ</p>
										<div class="box">
											<p>Không có ghi chú</p>
										</div>
									</div>
								</div>
								<div class="row mt-4" style="padding: 14px; border-radius: 4px; border: 1px solid #ccc">
									<table class="table productlist-table my-0">
										<thead>
											<tr>
												<th colspan="2">Sản phẩm</th>
												<th class="text-center">Đơn giá</th>
												<th class="text-center">Số lượng</th>
												<th class="text-center">Tổng</th>
											</tr>
										</thead>
										<tbody>
											<tr class="border-bottom">
												<td colspan="2">
													<img src="../assets/imgs/Nhẫn Bạc Dải Vô Cực.png" alt="" style="width: 90px">
													<span>Nhẫn bạc dải vô cực</span>
												</td>
												<td class="text-center" style="vertical-align:middle;">
													<p class="m-0">400.000</p>
												</td>
												<td class="text-center" style="vertical-align:middle;">
													<p class="m-0">1</p>
												</td>
												<td class="text-center" style="vertical-align:middle;">
													<p class="m-0">400.000</p>
												</td>
											</tr>
											<tr>
												<td>
													<span>Khuyến mại</span>
												</td>
												<td>
													<span>0</span>
												</td>
											</tr>
											<tr>
												<td>
													<span>Phí vận chuyển</span>
												</td>
												<td>
													<span>40.000 (Giao hàng tận nơi)</span>
												</td>
											</tr>
											<tr>
												<td>
													<span>Tổng tiền</span>
												</td>
												<td>440.000</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>

	<?php include_once("./footer.php") ?>
</body>

</html>