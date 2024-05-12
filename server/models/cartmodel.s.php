<?php

class CartModel extends Database
{
      protected function getProductById($productId)
      {
            try {
                  $sql = "SELECT * FROM `product` WHERE `product`.`id` = ? AND `product`.`deleted` = 0";

                  $statement = $this->connect()->prepare($sql);
                  $statement->execute([$productId]);

                  return $statement->fetch(PDO::FETCH_ASSOC) ?? [];
            } catch (Exception $e) {
                  $e->getMessage();
            }
      }
}
