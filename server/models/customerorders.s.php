<?php

class CustomerOrders extends Database
{
      protected function getOrdersById($userid)
      {
            try {
                  $sql = "SELECT * FROM `orders` WHERE `user_id` = ?";
                  $statement = $this->connect()->prepare($sql);
                  $statement->execute([$userid]);

                  return $statement->fetchAll(PDO::FETCH_ASSOC) ?? [];
            } catch (Exception $e) {
                  $e->getMessage();
                  exit();
            }
      }
}
