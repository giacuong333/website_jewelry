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
				$sql .= "`category`.`id` = ?;";
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

	protected function getFeedbacks()
	{
		$sql = "SELECT * FROM `feedback`;";
		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../templates/login.php?error=feedbacksnotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	protected function getGalleries()
	{
		$sql = "SELECT * FROM `gallery`;";
		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../templates/login.php?error=galleriesnotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// ================================================ ORDER ================================================

	protected function getAllOrders()
	{
		$sql = "SELECT *, `order`.`id` AS `orderid`, `product`.`id` AS `productid`, `user`.`id` AS `userid` FROM `order` 
		JOIN `orderdetail` ON `orderdetail`.`order_id` = `order`.`id`
		JOIN `product` ON `orderdetail`.`product_id` = `product`.`id`
		JOIN `user` ON `user`.`id` = `order`.`id` WHERE `order`.`isDeleted` != 1;";

		try {
			$stmt = $this->connect()->query($sql);
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
				$sql .= "`order`.`id` = ?;";
				break;
			case "fullname":
				$sql .= "`order`.`fullname` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "email":
				$sql .= "`order`.`email` LIKE ?;";
				$searchInput = "%$searchInput%";
				break;
			case "phonenumber":
				$sql .= "`order`.`phone_number` LIKE ?;";
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

	protected function searchAllOrdersByDate($fromDate, $toDate)
	{
		$sql = "SELECT *, `order`.`id` AS `orderid`, `product`.`id` AS `productid`, `user`.`id` AS `userid`, 
		`order`.`phone_number` AS `orderphone`, `order`.`email` AS `orderemail`, `order`.`fullname` AS `orderfullname`, 
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

	// ================================================ PRODUCT ================================================

	protected function getProducts()
	{
		try {
			$sql = "SELECT `product`.`id`, `product`.`category_id`, `category`.`name`, `product`.`title`, `product`.`thumbnail`, 
			`product`.`price`, `product`.`isOutstanding`, `product`.`isNew`, `product`.`isShow`
			FROM `product` JOIN `category` ON `category`.`id` = `product`.`category_id` WHERE `product`.`deleted` != 1;";
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
				$sql .= "`product`.`id` = ?;";
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
				$sql .= "`user`.`id` = ?;";
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
				$sql .= "DATE(`user`.`created_at`) = ?;";
				break;
			case "updated_at":
				$sql .= "DATE(`user`.`updated_at`) = ?;";
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

	protected function getPermissionsByRoleId($id)
	{
		$sql = "SELECT `permission`.`id` AS `permissionId`, `permission`.`description` FROM `permission` 
		JOIN `role_permission` ON `role_permission`.`permission_id` = `permissionId` 
		JOIN `role` ON `role`.`id` = `role_permission`.`role_id`
		WHERE `role`.`id` = ? AND `role_permission`.`isAllowed` != 0;";

		try {
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$id]);
			$permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $permissions ?? [];
		} catch (Exception $e) {
			exit();
		}
	}

	protected function setPrivilegeByRoleId($roleId, $permissionDescription, $isAllowed)
	{
		// First, check if the permission already exists for the role
		$sql = "SELECT * FROM `permission` WHERE `description` = ?;";
		$stmt = $this->connect()->prepare($sql);
		$stmt->execute([$permissionDescription]);
		$permission = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($permission) {
			// Permission exists, update the recod
			$permissionId = $permission["id"];
			$sql = "INSERT INTO `role_permission` (`role_id`, `permission_id`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `isAllowed` = VALUES (?);";
			$stmt = $this->connect()->prepare($sql);
			$stmt->execute([$roleId, $permissionId, $isAllowed]);
			return true; // Save the permissions successfully
		} else {
			return false;
		}
	}
}
