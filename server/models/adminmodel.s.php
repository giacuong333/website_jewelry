<?php

class Admin extends Database
{
	// ================================================ CATEGORY ================================================
	protected function getAllCategories()
	{
		$sql = "SELECT * FROM `category` WHERE `category`.`isDeleted` != 1;";

		try {
			$stmt = $this->connect()->query($sql);
			$categoryList = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $categoryList ?? [];
		} catch (Exception $ex) {
			exit();
		}
	}

	protected function addNewCategory($name)
	{
		$sql = "INSERT INTO `category` (`name`) VALUES (?);";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$name]);
			return true;
		} catch (Exception $e) {
			exit();
		}
	}

	protected function deleteACategoryById($id)
	{
		$sql = "UPDATE `category` SET `category`.`isDeleted` = 1 WHERE `category`.`id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			return true;
		} catch (Exception $e) {
			exit();
		}
	}

	protected function getACategoryById($id)
	{
		$sql = "SELECT * FROM `category` WHERE `category`.`isDeleted` != 1 AND `category`.`id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			$category = $stmt->fetch(PDO::FETCH_ASSOC);
			return $category ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function searchAllCategories($searchInput, $searchValue)
	{
		$sql = "SELECT * FROM `category` WHERE `category`.`isDeleted` != 1 AND ";

		switch ($searchValue) {
			case "id":
				$sql .= "CAST(`category`.`id` AS CHAR) LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "name":
				$sql .= "`category`.`name` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
		}

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$searchInput]);
			$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $orders ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function updateAnCategory($id, $name)
	{
		$sql = "UPDATE `category` SET `category`.`name` = ? WHERE `category`.`id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$name, $id]);
			return true;
		} catch (Exception $e) {
			exit();
		}
	}

	// ================================================ CONTACT ================================================

	protected function getFeedbacks()
	{
		$sql = "SELECT * FROM `contact`;";
		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../templates/login.php?error=feedbacksnotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// ================================================ ORDER ================================================

	protected function getAllOrders()
	{
		$sql = "SELECT *, `order`.`phone_number` AS `orderphonenumber`, `order`.`email` AS `orderemail`, `order`.`id` AS `orderid`, 
		`product`.`id` AS `productid`, `user`.`id` AS `userid` 
		FROM `order` 
		JOIN `orderdetail` ON `orderdetail`.`order_id` = `order`.`id` 
		JOIN `product` ON `orderdetail`.`product_id` = `product`.`id` 
		JOIN `user` ON `user`.`id` = `order`.`user_id` WHERE `order`.`isDeleted` != 1
		GROUP BY `order`.`id`;";

		try {
			$stmt = $this->connect()->query($sql);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results ?? [];
		} catch (Exception $e) {
			// header("location: ../templates/login.php?error=ordersnotfound");
			exit();
		}
	}

	protected function saveOrderStatus($id)
	{
		$sql = "UPDATE `order` SET `order`.`status` = 1 WHERE `order`.`id` = ?";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);

			return true;
		} catch (Exception $e) {
			exit();
		}
	}

	protected function deleteAnOrderById($id)
	{
		$sql = "UPDATE `order` SET `order`.`isDeleted` = 1 WHERE `order`.`id` = ?";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);

			return true;
		} catch (Exception $e) {
			exit();
		}
	}

	protected function searchAllOrders($searchInput, $searchValue)
	{
		$sql = "SELECT *, `order`.`id` AS `orderid`, `product`.`id` AS `productid`, `user`.`id` AS `userid`, 
		`order`.`phone_number` AS `orderphone`, `order`.`email` AS `orderemail`, `order`.`fullname` AS `orderfullname`, 
		`order`.`status` AS `orderstatus` 
		FROM `order` 
		JOIN `orderdetail` ON `orderdetail`.`order_id` = `order`.`id`
		JOIN `product` ON `orderdetail`.`product_id` = `product`.`id`
		JOIN `user` ON `user`.`id` = `order`.`id` 
		WHERE `order`.`isDeleted` != 1 AND ";

		switch ($searchValue) {
			case "id":
				$sql .= "CAST(`order`.`id` AS CHAR) LIKE ? ";
				$searchInput = "%$searchInput%";
				break;
			case "fullname":
				$sql .= "`order`.`fullname` LIKE ? ";
				$searchInput = "%$searchInput%";
				break;
			case "email":
				$sql .= "`order`.`email` LIKE ? ";
				$searchInput = "%$searchInput%";
				break;
			case "phonenumber":
				$sql .= "`order`.`phone_number` LIKE ? ";
				$searchInput = "%$searchInput%";
				break;
		}

		$sql .= "GROUP BY `order`.`id`;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$searchInput]);
			$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $orders ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function searchAllOrdersByDate($fromDate, $toDate)
	{
		$sql = "SELECT *, `order`.`id` AS `orderid`, `product`.`id` AS `productid`, `user`.`id` AS `userid`, 
		`order`.`phone_number` AS `orderphonenumber`, `order`.`email` AS `orderemail`, `order`.`fullname` AS `orderfullname`, 
		`order`.`status` AS `orderstatus` 
		FROM `order` 
		JOIN `orderdetail` ON `orderdetail`.`order_id` = `order`.`id`
		JOIN `product` ON `orderdetail`.`product_id` = `product`.`id`
		JOIN `user` ON `user`.`id` = `order`.`id` 
		WHERE `order`.`isDeleted` != 1 AND `order`.`order_date` BETWEEN ? AND ?;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$fromDate, $toDate]);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function getOrdersByUserId($user_id)
	{
		try {
			$sql = "SELECT *, `product`.`id` AS `productId` 
			FROM `order`
			JOIN `orderdetail` ON `order`.`id` = `orderdetail`.`order_id`
			JOIN `product` ON `orderdetail`.`product_id` = `product`.`id`
			WHERE `order`.`user_id` = ? AND `order`.`isDeleted` != 1";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$user_id]);
			$order = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $order ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function calculateTotalMoneyByUerId($user_id)
	{
		try {
			$sql = "SELECT SUM(`total_money`) as `total_of_order`
			FROM `order` 
			WHERE `order`.`user_id` = ? AND `order`.`isDeleted` != 1 
			GROUP BY `order`.`user_id`;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$user_id]);
			return $stmt->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			exit();
		}
	}

	// ================================================ PRODUCT ================================================

	protected function getProducts()
	{
		try {
			$sql = "SELECT `product`.`id`, `product`.`category_id`, `category`.`name`, `product`.`title`, `product`.`thumbnail`, 
			`product`.`price`, `product`.`isOutstanding`, `product`.`isNew`, `product`.`isShow`, `product`.`quantity` 
			FROM `product` JOIN `category` ON `category`.`id` = `product`.`category_id` WHERE `product`.`deleted` != 1 
			ORDER BY `product`.`id` ASC;";
			$stmt = $this->connect()->query($sql);
			$productLIst = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $productLIst ?? [];
		} catch (PDOException $e) {
			// header("location: ../templates/login.php?error=stmtfailed");
			exit();
		}
	}

	protected function setAProduct($image, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new)
	{
		$sql = "INSERT INTO `product` (`thumbnail`, `title`, `category_id`, `price`, `discount`, `description`, `isShow`, `isOutstanding`, `isNew`)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$image, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new]);
			return true;
		} catch (Exception $e) {
			header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	protected function deleteAProductById($id)
	{
		$sql = "UPDATE `product` SET `product`.`deleted` = 1 WHERE `product`.`id` = ?";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			return true;
		} catch (Exception $e) {
			header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	protected function getAProductById($id)
	{
		$sql = "SELECT `product`.`id`, `product`.`category_id`, `product`.`price`, `product`.`discount`, 
		`category`.`name`, `product`.`title`, `product`.`description`, `product`.`thumbnail`, 
		`product`.`isOutstanding`, `product`.`isNew`, `product`.`isShow`
		FROM `product` JOIN `category` ON `category`.`id` = `product`.`category_id` WHERE `product`.`deleted` != 1 AND `product`.`id` = ?;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			$productList = $stmt->fetch(PDO::FETCH_ASSOC);
			return $productList ?? [];
		} catch (Exception $e) {
			header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	protected function updateAProductById($id, $imagepath, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new)
	{
		$sql = "UPDATE `product` SET `thumbnail` = ?, `title` = ?, `category_id` = ?, `price` = ?, `discount` = ?, `description` = ?, 
		`isShow` = ?, `isOutstanding` = ?, `isNew` = ? 
		WHERE `product`.`id` = ?;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$imagepath, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new, $id]);
			return true;
		} catch (Exception $e) {
			header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	protected function searchAllProducts($searchInput, $searchValue)
	{
		$sql = "SELECT `product`.`id`, `title`, `category`.`name`, `price`, `product`.`category_id`, `discount`, `thumbnail`, `description`, `isShow`, `isOutstanding`, `isNew`
                FROM `product` JOIN `category` ON `product`.`category_id` = `category`.`id` WHERE `product`.`deleted` != 1 AND ";

		switch ($searchValue) {
			case "id":
				$sql .= "CAST(`product`.`id` AS CHAR) LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "category":
				$sql .= "`category`.`name` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "title":
				$sql .= "`product`.`title` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
		}

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$searchInput]);
			$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $products ?? [];
		} catch (Exception $e) {
			// header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	// ================================================ ROLE ================================================

	protected function getAllRoles()
	{
		$sql = "SELECT * FROM `role` WHERE `role`.`isDeleted` != 1;";
		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../templates/login.php?error=rolesnotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	protected function addNewRole($name)
	{
		$sql = "INSERT INTO `role` (`name`) VALUES (?);";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$name]);
			return true;
		} catch (Exception $e) {
			exit();
		}
	}

	protected function deleteARole($id)
	{
		$sql = "UPDATE `role` SET `role`.`isDeleted` = 1 WHERE `role`.`id` = ?";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			return true;
		} catch (Exception $e) {
			exit();
		}
	}

	protected function updateARole($id, $name)
	{
		$sql = "UPDATE `role` SET `role`.`name` = ? WHERE `role`.`id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$name, $id]);
			return true;
		} catch (Exception $e) {
			exit();
		}
	}

	protected function getARoleById($id)
	{
		$sql = "SELECT * FROM `role` WHERE `role`.`id` = ?;";
		$stmt = $this->connect()->prepare($sql);

		try {
			$stmt->execute([$id]);
			$category = $stmt->fetch(PDO::FETCH_ASSOC);

			return $category ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function searchAllRoles($searchInput, $searchValue)
	{
		$sql = "SELECT * FROM `role` WHERE `role`.`isDeleted` != 1 AND ";

		switch ($searchValue) {
			case "id":
				$sql .= "`role`.`id` = ?;";
				break;
			case "name":
				$sql .= "`role`.`name` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
		}

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$searchInput]);
			$roles = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $roles ?? [];
		} catch (Exception $e) {
			// header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	// ================================================ USER ================================================

	protected function getUsers()
	{
		$sql = "SELECT 
		`user`.`id`, `user`.`fullname`, `user`.`email`, `user`.`phone_number`, `user`.`created_at`, `user`.`role_id`,
		`user`.`updated_at`, `role`.`name`, `role`.`id` AS `roleid`
		FROM `user` JOIN `role` ON `user`.`role_id` = `role`.`id` WHERE `user`.`deleted` != 1;";

		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../admin/usermanager.php?usernotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	protected function setAnUser($fullname, $email, $phoneNumber, $password, $role_id)
	{
		$sql = "INSERT INTO `user` (`fullname`, `email`,`phone_number`,`password`,`role_id`)
                    VALUES (?, ?, ?, ?, ?)";

		try {
			$hasedPassword = password_hash($password, PASSWORD_DEFAULT);
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$fullname, $email, $phoneNumber, $hasedPassword, $role_id]);
		} catch (Exception $e) {
			// header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	protected function getAnUserById($id)
	{
		$sql = "SELECT * FROM `user` WHERE `user`.`id` = ?";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			$userList = $stmt->fetch(PDO::FETCH_ASSOC);
			return $userList ?? [];
		} catch (Exception $e) {
			// header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	protected function deleteAnUserById($id)
	{
		$sql = "UPDATE `user` SET `deleted`= 1 WHERE `user`.`id` = ?";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			return true;
		} catch (Exception $e) {
			// header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	protected function updateAnUser($id, $fullname, $email, $phoneNumber, $role_id)
	{
		$sql = "UPDATE `user` SET `fullname` = ?, `email` = ?, `phone_number` = ?, `role_id` = ? WHERE `id` = ?;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$fullname, $email, $phoneNumber, $role_id, $id]);
			return true;
		} catch (Exception $e) {
			// header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	protected function searchAllUsers($searchInput, $searchValue)
	{
		$sql = "SELECT `user`.`id`, `user`.`fullname`, `user`.`email`, `user`.`phone_number`, `role`.`name`, 
		`user`.`created_at`, `user`.`updated_at`, `user`.`role_id`
		FROM `user` JOIN `role` ON `user`.`role_id` = `role`.`id` WHERE `user`.`deleted` != 1 AND ";

		switch ($searchValue) {
			case "id":
				$sql .= "CAST(`user`.`id` AS CHAR) LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "fullname":
				$sql .= "`user`.`fullname` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "email":
				$sql .= "`user`.`email` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "phone_number":
				$sql .= "`user`.`phone_number` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "role":
				$sql .= "`role`.`name` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "created_at":
				$sql .= "CAST(`user`.`created_at` AS CHAR) LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
		}

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$searchInput]);
			$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $users ?? [];
		} catch (Exception $e) {
			// header("location: ../index.php?error=stmtfailed");
			exit();
		}
	}

	// ================================================ PERMISSION ================================================

	protected function getAllPermissions()
	{
		$sql = "SELECT * FROM `permission` 
		JOIN `role_permission` ON `role_permission`.`permission_id` = `permission`.`id` 
		JOIN `role` ON `role`.`id` = `role_permission`.`role_id`;";

		try {
			$stmt = $this->connect()->query($sql);
			$permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $permissions ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function getPermissionsByRoleId($role_id)
	{
		$sql = "SELECT `permission`.`id` AS `permissionId`, `permission`.`description` 
		FROM `permission` 
		JOIN `role_permission` ON `role_permission`.`permission_id` = `permission`.`id` 
		JOIN `role` ON `role`.`id` = `role_permission`.`role_id`
		WHERE `role_permission`.`role_id` = ? AND `role_permission`.`isAllowed` != 0;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$role_id]);
			$permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $permissions ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function setPrivilegeByRoleId($role_id, $permissionDescription, $isAllowed)
	{
		try {
			// First, check if the permission already exists for the role
			$sql = "SELECT * FROM `permission` WHERE `description` = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$permissionDescription]);
			$permission = $stmt->fetch(PDO::FETCH_ASSOC);

			if ($permission) {
				$permission_id = $permission["id"];
				$sql = "UPDATE `role_permission` SET `isAllowed` = ? WHERE `role_id` = ? AND `permission_id` = ?;";
				$stmt = $this->connect()->prepare($sql);
				$stmt->execute([$isAllowed, $role_id, $permission_id]);
				return true;
			}
		} catch (Exception $e) {
			exit();
		}
	}

	protected function hasPermission($role_id, $permission_description)
	{
		try {
			$sql = "SELECT 1 FROM `role_permission`
			JOIN `permission` ON `permission`.`id` = `role_permission`.`permission_id`
			JOIN `role` ON `role`.`id` = `role_permission`.`role_id` 
			WHERE `role_permission`.`role_id` = ? 
			AND `permission`.`description` = ? 
			AND `role_permission`.`isAllowed` = 1 
			LIMIT 1;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$role_id, $permission_description]);
			return $stmt->rowCount() > 0;
		} catch (Exception $e) {
			exit();
		}
	}

	protected function getMenuItems($role_id)
	{
		try {
			$sql = "SELECT `description` FROM `role_permission`
			JOIN `permission` ON `role_permission`.`permission_id` = `permission`.`id`
			JOIN `role` ON `role_permission`.`role_id` = `role`.`id`
			WHERE `role_id` = ? AND `isAllowed` != 0";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$role_id]);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	// ================================================ GALLERY ================================================
	protected function getGalleries()
	{
		$start = 0;
		$rows_per_page = 9;

		$sql = "SELECT * FROM `gallery`;";
		$stmt = $this->connect()->query($sql);

		$nr_of_rows = $stmt->rowCount(); // Get the total of rows

		$pages = ceil($nr_of_rows / $rows_per_page); // Calculate the total of pages

		if (isset($_GET["page-nr"])) {
			$page = (int)$_GET["page-nr"] - 1;
			$start = $page * $rows_per_page; // Update the start
		}

		try {
			$sql = "SELECT * FROM `gallery` LIMIT $start, $rows_per_page;";
			$stmt = $this->connect()->query($sql);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return ['results' => $results, 'pages' => $pages];
		} catch (Exception $e) {
			$e->getMessage();
			exit();
		}
	}

	protected function getGalleryById($id)
	{
		try {
			$sql = "SELECT * FROM `gallery` WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result ?? "";
		} catch (Exception $e) {
			$e->getMessage();
			exit();
		}
	}

	protected function addGallery($title, $thumbnail)
	{
		try {
			$sql = "INSERT INTO `gallery` (`title`, `thumbnail`) VALUES (?, ?);";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$title, $thumbnail]);

			return true;
		} catch (Exception $e) {
			$e->getMessage();
			exit();
		}
	}

	protected function editGalleryById($title, $thumbnail)
	{
		try {
			$sql = "UPDATE `gallery` SET `title` = ?, `thumbnail` = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$title, $thumbnail]);

			return true;
		} catch (Exception $e) {
			$e->getMessage();
			exit();
		}
	}

	protected function deleteGalleryById($id)
	{
		try {
			$sql = "DELETE FROM `gallery` WHERE `id` = ?;";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);

			return true;
		} catch (Exception $e) {
			$e->getMessage();
			exit();
		}
	}

	protected function searchGalleries($searchInput, $searchValue)
	{
		$start = 0;
		$rows_per_page = 9;

		$sql = "SELECT * FROM `gallery` ";

		switch ($searchValue) {
			case "title":
				$sql .= "`gallery`.`title` LIKE ? ";
				$searchInput = "%$searchInput%";
				break;
		}

		$sql .= "LIMIT $start, $rows_per_page;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$searchInput]);
		} catch (Exception $e) {
			$e->getMessage();
		}

		$nr_of_rows = $stmt->rowCount(); // Get the total of rows

		$pages = ceil($nr_of_rows / $rows_per_page); // Calculate the total of pages

		if (isset($_GET["page-nr"])) {
			$page = (int)$_GET["page-nr"] - 1;
			$start = $page * $rows_per_page; // Update the start
		}

		$sql = "SELECT * FROM `gallery` WHERE ";

		switch ($searchValue) {
			case "title":
				$sql .= "`gallery`.`title` LIKE ? ";
				$searchInput = "%$searchInput%";
				break;
		}

		$sql .= "LIMIT $start, $rows_per_page;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$searchInput]);
			$gallery_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return ["gallery_list" => $gallery_list, "pages" => $pages];
		} catch (Exception $e) {
			// header("location: ../index.php?error=stmtfailed");
			$e->getMessage();
			exit();
		}
	}

	// ================================================ INPUT INVOICE ================================================

	protected function getInputInvoices()
	{
		try {
			$sql = "SELECT `import`.`id`, `user`.`fullname`, `import`.`total_import_order`, `import`.`created_at`
			FROM `import` 
			JOIN `user` ON `user`.`id` = `import`.`user_id`
			WHERE `import`.`isDeleted` != 1;";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results ?? [];
		} catch (PDOException $e) {
			echo $e->getMessage();
			return [];
		}
	}


	protected function getInputInvoiceById($id)
	{
		try {
			$sql = "SELECT `import`.`id`, `product`.`title`, `user`.`fullname`, `importdetail`.`amount`,
			`importdetail`.`price`, `importdetail`.`total_price`, `import`.`total_import_order`, 
			`import`.`created_at`, `supplier`.`name` 
			FROM `import` 
			JOIN `importdetail` ON `import`.`id` = `importdetail`.`import_id` 
			JOIN `product` ON `importdetail`.`product_id` = `product`.`id` 
			JOIN `user` ON `import`.`user_id` = `user`.`id` 
			JOIN `supplier` ON `import`.`supplier_id` = `supplier`.`id` 
			WHERE `import`.`id` = ?;";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			$results = $stmt->fetch(PDO::FETCH_ASSOC);

			return $results ?? [];
		} catch (Exception $e) {
			$e->getMessage();
			return [];
		}
	}

	protected function getImportProductInvoiceById($id)
	{
		try {
			$sql = "SELECT `product`.`title`, `importdetail`.`amount`, `importdetail`.`total_price`, `import`.`total_import_order`, `importdetail`.`price`
        FROM `import` 
        JOIN `importdetail` ON `import`.`id` = `importdetail`.`import_id` 
        JOIN `product` ON `importdetail`.`product_id` = `product`.`id` 
        WHERE `import`.`id` = ?;";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results ?? [];
		} catch (Exception $e) {
			$e->getMessage();
			return [];
		}
	}

	protected function deleteInputInvoiceById($id)
	{
		try {
			$sql = "UPDATE `import` SET `import`.`isDeleted` = 1 WHERE `import`.`id` = ?;";

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);

			return true;
		} catch (Exception $e) {
			$e->getMessage();
			exit();
		}
	}

	protected function addImportInvoice($user_id, $import_product_list, $supplier_id)
	{
		try {
			$pdo = $this->connect(); // to make sure that we're using the same connection instance throughout the method 
			// Start the transaction
			$pdo->beginTransaction();

			$sql_import = "INSERT INTO `import` (`user_id`, `supplier_id`) VALUES (?, ?);";
			$stmt_import = $pdo->prepare($sql_import);
			$stmt_import->execute([$user_id, $supplier_id]);

			$import_id = $pdo->lastInsertId();

			foreach ($import_product_list as $product_item) {
				$product_id = $product_item['product_id'];
				$product_amount = $product_item['product_amount'];
				$import_product_price = $product_item['import_product_price'];

				$sql_importdetail = "INSERT INTO `importdetail` (`import_id`, `product_id`, `amount`, `price`) VALUES (?, ?, ?, ?);";
				$stmt_importdetail = $pdo->prepare($sql_importdetail);
				$stmt_importdetail->execute([$import_id, $product_id, $product_amount, $import_product_price]);
			}

			$pdo->commit(); // commit 
			return true;
		} catch (Exception $e) {
			// Log or display the exception message
			echo "Error: " . $e->getMessage();
			// Roll back the transaction
			$pdo->rollBack();
			// Exit gracefully or handle the error as needed
			// exit(); // Consider more graceful error handling
			return false;
		}
	}

	protected function searchInputInvoices($searchInput, $searchValue)
	{
		try {
			$sql = "SELECT *, `import`.`id` AS `import_id` 
			FROM `import` 
			JOIN `user` ON `user`.`id` = `import`.`user_id` 
			WHERE `import`.`isDeleted` != 1 AND ";

			switch ($searchValue) {
				case "id":
					$sql .= "CAST(`import`.`id` AS CHAR) LIKE ?;";
					$searchInput = "%$searchInput%";
					break;
				case "employee-name":
					$sql .= "`user`.`fullname` LIKE ?;";
					$searchInput = "%$searchInput%";
					break;
				case "import-create-time":
					$sql .= "CAST(`import`.`created_at` AS CHAR) LIKE ?;";
					$searchInput = "%$searchInput%";
					break;
			}

			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$searchInput]);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results ?? [];
		} catch (Exception $e) {
			$e->getMessage();
		}
	}

	protected function search_input_invoice_by_date($fromDate, $toDate)
	{
		$sql = "SELECT *, `import`.`id` AS `import_id` 
		FROM `import` 
		JOIN `user` ON `user`.`id` = `import`.`user_id` 
		WHERE `import`.`isDeleted` != 1 AND `import`.`created_at` BETWEEN ? AND ?;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$fromDate, $toDate]);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $results ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	// ======================================================================= SUPPLIER =======================================================

	protected function getSuppliers()
	{
		$sql = "SELECT * FROM `supplier`;";

		try {
			$stmt = $this->connect()->query($sql);
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $results ?? [];
		} catch (Exception $e) {
			$e->getMessage();
			exit();
		}
	}
}
