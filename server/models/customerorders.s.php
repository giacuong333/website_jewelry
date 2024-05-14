<?php

class CustomerOrdersModel extends Database
{
      protected function getOrdersById($userid)
      {
            try {
                  $sql = "SELECT * FROM `order` WHERE `user_id` = ?";
                  $statement = $this->connect()->prepare($sql);
                  $statement->execute([$userid]);

                  return $statement->fetchAll(PDO::FETCH_ASSOC) ?? [];
            } catch (Exception $e) {
                  $e->getMessage();
                  exit();
            }
      }

      protected function getOrderDetailsById($orderid, $userid)
      {
            try {
                  $sql = "SELECT *, `orderdetail`.`price` AS `orderdetail_price` FROM `order` 
                  JOIN `orderdetail` ON `order`.`id` = `orderdetail`.`order_id` 
                  JOIN `product` ON `orderdetail`.`product_id` = `product`.`id` 
                  WHERE `order`.`id` = ? 
                  AND `order`.`user_id` = ?";
                  $statement = $this->connect()->prepare($sql);
                  $statement->execute([$orderid, $userid]);

                  return $statement->fetchAll(PDO::FETCH_ASSOC) ?? [];
            } catch (Exception $e) {
                  $e->getMessage();
                  exit();
            }
      }
}
