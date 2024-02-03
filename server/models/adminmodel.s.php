<?php

class Admin extends Database
{
	protected function getCategories()
	{
		$sql = "SELECT * FROM `category`;";
		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../templates/login.php?error=categorynotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
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

	protected function getOrders()
	{
		$sql = "SELECT * FROM `order`;";
		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../templates/login.php?error=ordersnotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	protected function getOrderDetails()
	{
		$sql = "SELECT * FROM `orderdetail`;";
		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../templates/login.php?error=orderdetailsnotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// ================================================ PRODUCT ================================================

	protected function getProducts()
	{
		try {
			$sql = "SELECT `product`.`id`, `category`.`name`, `product`.`title`, `product`.`thumbnail`, `product`.`isOutstanding`, `product`.`isNew`, `product`.`isShow`
                              FROM `product` JOIN `category` ON `category`.`id` = `product`.`category_id` WHERE `product`.`deleted` != 1;";
			$stmt = $this->connect()->query($sql);

			if ($stmt->rowCount() == 0) {
				// header("location: ../templates/login.php?error=productnotfound");
				exit();
			}

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOException $e) {
			// header("location: ../templates/login.php?error=stmtfailed");
			exit();
		}
	}

	protected function setAProduct($image, $title, $categoryid, $price, $discount, $description, $show, $outstanding, $new)
	{
		$sql = "INSERT INTO `product` (`thumbnail`, `title`,`category_id`,`price`,`discount`, `description`, `isShow`, `isOutstanding`, `isNew`)
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

	protected function getRoles()
	{
		$sql = "SELECT * FROM `role`;";
		$stmt = $this->connect()->query($sql);

		if ($stmt->rowCount() == 0) {
			// header("location: ../templates/login.php?error=rolesnotfound");
			exit();
		}

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// ================================================ USER ================================================

	protected function getUsers()
	{
		$sql = "SELECT 
                    `user`.`id`, `user`.`fullname`, `user`.`email`, `user`.`phone_number`, `user`.`created_at`,
                    `user`.`updated_at`, `role`.`name`
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

			return $stmt->fetch(PDO::FETCH_ASSOC);
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
		$sql = "UPDATE `user` SET `fullname`=?, `email`=?, `phone_number`=?, `role_id`=? WHERE `id`=?;";

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
		$sql = "SELECT `user`.`id`, `fullname`, `email`, `phone_number`, `name`, `created_at`, `updated_at`
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
}
