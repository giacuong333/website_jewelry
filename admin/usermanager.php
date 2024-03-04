<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manage Users</title>
	<!-- Style -->
	<link rel="stylesheet" href="../assets/css/admin.css" />
	<!-- Icon -->
	<link rel="stylesheet" href="../assets/icons/css/all.min.css">
	<!-- JQuery -->
	<script src="../assets/libs/jquery-3.7.1.min.js"></script>

</head>

<body>
	<?php
	include_once("../admin/common.php");
	include_once("../includes/admin.inc.php"); ?>

	<main>

		<div class="dashboard-header">
			<input type="text" placeholder="Search" name="searchinput" id="searchinput" />

			<select class="btn- btn--hover" name="searchvalue" id="searchvalue">
				<option value="id">Id</option>
				<option value="fullname">Fullname</option>
				<option value="email">Email</option>
				<option value="phone_number">Phone number</option>
				<option value="role">Role</option>
				<option value="created_at">Create time</option>
			</select>

			<?php
			if (checkPermission("Add users", $admin)) {
			?>
				<button id="adduser" class="btn- btn--hover" type="button">
					<span class="fa-solid fa-plus"></span>
					Add new
				</button>
			<?php
			}
			?>
		</div>

		<!-- Product -->
		<div class="dashboard-body">
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Full name</th>
						<th>Email</th>
						<th>Phone number</th>
						<th>Role</th>
						<th>Create time</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody id="bodyuser">
					<?php
					if (is_array($users)) {
						foreach ($users as $user) {
					?>
							<tr data-userid="<?php echo $user["id"]; ?>" data-roleid="<?php echo $user["role_id"]; ?>">
								<td><?php echo $user["id"]; ?></td>
								<td><?php echo $user["fullname"]; ?></td>
								<td><?php echo $user["email"]; ?></td>
								<td><?php echo $user["phone_number"]; ?></td>
								<td><?php echo $user["name"]; ?></td>
								<td><?php echo $user["created_at"]; ?></td>
								<td>
									<?php
									if (checkPermission("Edit users", $admin)) {
									?>
										<span class="fa-solid fa-pen-to-square edit-userbtn" name="editbtn" value="editbtn"></span>
									<?php
									}
									if (checkPermission("Delete users", $admin)) {
									?>
										<span class="fa-solid fa-trash del-userbtn" name="delbtn" value="delbtn"></span>
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