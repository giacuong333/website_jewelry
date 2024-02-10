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

</head>

<body>
	<?php include("../admin/common.php"); ?>

	<main>
		<div class="dashboard-header">
			<input type="text" placeholder="Search" name="searchorderinput" id="searchorderinput" />

			<select class="btn- btn--hover" name="searchordervalue" id="searchordervalue">
				<option value="id">Id</option>
				<option value="fullname">Fullname</option>
				<option value="email">Email</option>
				<option value="phonenumber">Phone number</option>
			</select>
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
					include("../includes/admin.inc.php");

					if (is_array($orders)) {
						foreach ($orders as $order) {
							$status = $order["status"] == 1 ? "Đã xử lý" : "Đang xử lý";
					?>
							<tr class="row-order" data-orderid="<?php echo $order["id"]; ?>">
								<td> <?php echo $order["id"]; ?></td>
								<td> <?php echo $order["fullname"]; ?></td>
								<td> <?php echo $order["email"]; ?></td>
								<td> <?php echo $order["phone_number"]; ?></td>
								<td class="status">
									<button type="button" name="statusBtn" value="<?php echo $order["status"]; ?>" class=" btn- btn--hover"><?php echo $status; ?></button>
								</td>
								<td><?php echo $order["total_money"]; ?></td>
								<td>
									<span class="fa-solid fa-pen-to-square edit-orderbtn"></span>
									<span class="fa-solid fa-trash del-orderbtn" name="del-order" value="del-order"></span>
								</td>
							</tr>

							<!-- Order details -->
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