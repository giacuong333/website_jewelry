<?php

include_once("../connection/connect.s.php");

class GetNew extends Database
{
      public function getNewProducts()
      {
            try {
                  $query = "SELECT *, `product`.`id` AS `product_id` FROM `product` 
                  JOIN `category` ON `product`.`category_id` = `category`.`id` 
                  WHERE `product`.`isNew` = 1 AND `product`.`deleted` != 1 LIMIT 3";

                  $statement = $this->connect()->query($query);

                  return json_encode($statement->fetchAll(PDO::FETCH_ASSOC) ?? []);
            } catch (Exception $e) {
                  $e->getMessage();
                  exit();
            }
      }
}

$hotDealObj = new GetNew();

echo $hotDealObj->getNewProducts();
