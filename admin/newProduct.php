<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Manage Product</title>
	<!-- Style -->
	<link rel="stylesheet" href="../assets/css/admin.css" />
	<!-- Icon -->
	<link rel="stylesheet" href="../assets/icons/css/all.min.css">
	<!-- JQuery -->
	<script src="../assets/libs/jquery-3.7.1.min.js"></script>
	<!-- JS -->
	<script src="../js/admin.js"></script>

</head>

<body>
	<?php include("../admin/common.php"); ?>

	<main>
		<!-- Add new -->
		<form action="../includes/admin.inc.php" method="post" enctype="multipart/form-data">
			<div class="dashboard-body">
				<div class="header">PRODUCT INFORMATION</div>

				<div class="wrapper">
					<table>
						<tbody>
							<tr>
								<td>Image</td>
								<td>
									<input type="file" required name="imagepath" class="btn- btn--hover" id="productinputimg" accept="image/*">
								</td>
								<td rowspan="8">
									<img id="productimg" src="" alt="Product Image" />

								</td>
							</tr>
							<tr>
								<td>Title</td>
								<td><input type="text" required name="title" /></td>
							</tr>
							<tr>
								<td>Category</td>
								<?php include("../includes/admin.inc.php"); ?>
								<td>
									<select class="btn- btn--hover" name="categoryid" id="">
										<?php
										foreach ($categories as $category) {
											echo "<option value='{$category['id']}'>{$category['name']}</option>";
										}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td>Price</td>
								<td><input type="text" required name="price" /></td>
							</tr>
							<tr>
								<td>Discount</td>
								<td><input type="text" name="discount" /></td>
							</tr>
							<tr>
								<td>Description</td>
								<td><textarea name="description" id="" cols="64" rows="1"></textarea></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<label for="show">
										<input name="show" id="show" type="checkbox" />Show
									</label>
									<label for="outstanding">
										<input name="outstanding" id="outstanding" type="checkbox" />Outstanding
									</label>
									<label for="new">
										<input name="new" id="new" type="checkbox" />New
									</label>
								</td>
							</tr>
							<tr>
								<td>Action</td>
								<td>
									<button class="btn- btn--hover" name="saveproduct" value="saveproduct" id="saveproduct" type="submit">Save</button>
									<button class="btn- btn--hover" id="exitproduct" type="button">Exit</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</form>
	</main>
</body>

</html>