<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manage Orders</title>
	<!-- Style -->
	<link rel="stylesheet" href="../assets/css/admin.css" />
	<!-- Icon -->
	<link rel="stylesheet" href="../assets/icons/css/all.min.css">
	<!-- JQuery -->
	<script src="../assets/libs/jquery-3.7.1.min.js"></script>
	<!-- Boostrap -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
	<!-- Date Picker -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
	<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</head>

<body id="order-body">
	<?php
	include_once("../admin/common.php");
	include_once("../includes/admin.inc.php");
	?>
	<!-- Order details -->

	<main>
		<div class="dashboard-header">
			<input type="text" placeholder="Search" name="searchorderinput" id="searchorderinput" />

			<select class="btn- btn--hover" name="searchordervalue" id="searchordervalue">
				<option value="id">Id</option>
				<option value="fullname">Fullname</option>
				<option value="email">Email</option>
				<option value="phonenumber">Phone number</option>
			</select>

			<!-- Search for orders in a range date -->
			<input type="datetime-local" placeholder="From date" name="searchfromdateinput" id="searchfromdateinput" />
			<input type="datetime-local" placeholder="To date" name="searchtodateinput" id="searchtodateinput" />
			<button type="button" class="btn- btn--hover btn-searchbydate">Search by date</button>
		</div>

		<!-- Product -->
		<div class="dashboard-body">
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Fullname</th>
						<th>Email</th>
						<th>Phone number</th>
						<th>Status</th>
						<th>Total</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody id="bodyorder">
					<?php
					if (is_array($orders)) {
						foreach ($orders as $order) {
							$status = $order["status"] == 1 ? "Đã xử lý" : "Đang xử lý";
					?>
							<tr class="row-order" data-orderid="<?php echo $order["id"]; ?>" data-userid="<?php echo $order["userid"] ?>">
								<td> <?php echo $order["orderid"]; ?></td>
								<td> <?php echo $order["fullname"]; ?></td>
								<td> <?php echo $order["orderemail"]; ?></td>
								<td> <?php echo $order["orderphonenumber"]; ?></td>
								<?php
								if (checkPermission("Solve orders", $admin)) {
								?>
									<td class="status">
										<button type="button" name="statusBtn" value="<?php echo $order["status"]; ?>" class=" btn- btn--hover"><?php echo $status; ?></button>
									</td>
								<?php
								} else {
								?>
									<td class="status"><?php echo $status; ?></td>
								<?php
								}
								?>
								<td><?php echo $order["total_money"]; ?></td>
								<td>
									<?php
									if (checkPermission("Delete orders", $admin)) {
									?>
										<span class="fa-solid fa-trash del-orderbtn" name="del-order" value="del-order"></span>
									<?php
									}
									?>
								</td>
							</tr>
					<?php
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</main>
</body>

</html>