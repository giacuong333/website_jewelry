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

</head>

<body>
	<?php include("../admin/common.php"); ?>

	<main>

		<div class="dashboard-header">
			<input type="text" placeholder="Search" name="searchproductinput" id="searchproductinput" />

			<select class="btn- btn--hover" name="searchproductvalue" id="searchproductvalue">
				<option value="id">Id</option>
				<option value="category">Category</option>
				<option value="title">Title</option>
			</select>

			<button id="addproduct" class="btn- btn--hover" type="button">
				<span class="fa-solid fa-plus"></span>
				Add new
			</button>
		</div>

		<!-- Product -->
		<div class="dashboard-body">
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Category</th>
						<th>Title</th>
						<th>Image</th>
						<th>Price</th>
						<th>Outstanding</th>
						<th>New</th>
						<th>Show</th>
						<th>Action</th>
					</tr>
				</thead>

				<tbody id="bodyproduct">
					<?php
					include("../includes/admin.inc.php");

					if (is_array($products)) {
						foreach ($products as $product) {
					?>
							<tr data-productid="<?php echo $product["id"]; ?>">
								<td> <?php echo $product["id"]; ?></td>
								<td> <?php echo $product["name"]; ?></td>
								<td> <?php echo $product["title"]; ?></td>
								<td><img src="<?php echo $product["thumbnail"]; ?>" alt="" /></td>
								<td>
									<p><?php echo $product["price"]; ?></p>
								</td>
								<td><input type="checkbox" disabled <?php echo $product["isOutstanding"] ? "checked" : ""; ?> name="outstanding" id="" /></td>
								<td><input type="checkbox" disabled <?php echo $product["isNew"] ? "checked" : ""; ?> name="isNew" id="" /></td>
								<td><input type="checkbox" disabled <?php echo $product["isShow"] ? "checked" : ""; ?> name="isShow" id="" /></td>
								<td>
									<span class="fa-solid fa-pen-to-square edit-productbtn"></span>
									<span class="fa-solid fa-trash del-productbtn" name="del-product" value="del-product"></span>
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