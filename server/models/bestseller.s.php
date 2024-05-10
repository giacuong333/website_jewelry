<?php

include_once("../connection/connect.s.php");

class BestSeller extends Database
{

      public function getBestSeller()
      {
            try {
                  $sql = "SELECT SUM(`num`) AS `sold_amount`, `title`, `product_id`
                  FROM `orderdetail` 
                  JOIN `product` ON `product_id` = `product`.`id`
                  GROUP BY `product_id`
                  ORDER BY SUM(`num`) DESC
                  LIMIT 3;";

                  $stmt = $this->connect()->query($sql);

                  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  return json_encode($data);
            } catch (Exception $e) {
                  error_log("Get best seller failed " + $e->getMessage());
                  exit();
            }
      }
}

$bestSeller = new BestSeller();
echo $bestSeller->getBestSeller();
