<?php

include_once("../connection/connect.s.php");

class GetOutstanding extends Database
{
      public function getOutstanding()
      {
            try {
                  $query = "SELECT *, `product`.`id` AS `product_id` FROM `product`
                  JOIN `category` ON `product`.`category_id` = `category`.`id`
                  WHERE `product`.`isOutstanding` = 1 AND `product`.`deleted` != 1 
                  LIMIT 3";

                  $statement = $this->connect()->query($query);

                  return json_encode($statement->fetchAll(PDO::FETCH_ASSOC) ?? []);
            } catch (Exception $e) {
                  $e->getMessage();
                  exit();
            }
      }
}

$hotDealObj = new GetOutstanding();

echo $hotDealObj->getOutstanding();
