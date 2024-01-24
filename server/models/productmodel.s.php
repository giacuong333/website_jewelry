<?php

class Product extends Database
{

          protected function getAllProducts()
          {
                    try {
                              $stmt = $this->connect()->query("SELECT * FROM `product`;");

                              if ($stmt->rowCount() == 0) {
                                        header("location: ../templates/login.php?error=productnotfound");
                                        exit();
                              }

                              return $stmt->fetchAll(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                              header("location: ../templates/login.php?error=stmtfailed");
                              exit();
                    }
          }

          protected function getProductById($id)
          {
                    try {
                              $stmt = $this->connect()->prepare("SELECT * FROM `product` WHERE `id` = ?;");
                              $stmt->execute([$id]);

                              if ($stmt->rowCount() == 0) {
                                        header("location: ../templates/login.php?error=productnotfound");
                                        exit();
                              }

                              return $stmt->fetch(PDO::FETCH_ASSOC);
                    } catch (PDOException $e) {
                              header("location: ../templates/login.php?error=stmtfailed");
                              exit();
                    }
          }

          protected function updateProduct($id)
          {
          }

          protected function setNewProduct($title, $price, $category_id, $discount, $thumbail, $description)
          {
                    try {
                              $stmt = $this->connect()->prepare("INSERT INTO `product` (`title`, `price`, `category_id`, `discount`, `thumbnail`, `description`) VALUES (?, ?, ?, ?, ?, ?);");
                              return $stmt->execute([$title, $price, $category_id, $discount, $thumbail, $description]);
                    } catch (PDOException $e) {
                              header("location: ../templates/login.php?error=stmtfailed");
                              exit();
                    }
          }
}
