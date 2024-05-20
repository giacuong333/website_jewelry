<?php

include_once("../connection/connect.s.php");

class GetBestSellers extends Database
{
      public function getBestSellers()
      {
            try {
                  $query = "SELECT SUM(`num`) AS `sold_amount`, `title`, `product_id`, `product`.`thumbnail`, `product`.`price`, `category`.`name`
                  FROM `orderdetail` 
                  JOIN `product` ON `product_id` = `product`.`id`
                  JOIN `category` ON `product`.`category_id` = `category`.`id`
                  GROUP BY `product_id`
                  ORDER BY SUM(`num`) DESC
                  LIMIT 3;";

                  $statement = $this->connect()->query($query);

                  return json_encode($statement->fetchAll(PDO::FETCH_ASSOC) ?? []);
            } catch (Exception $e) {
                  error_log($e->getMessage());
                  exit();
            }
      }
}

$hotDealObj = new GetBestSellers();

echo $hotDealObj->getBestSellers();
