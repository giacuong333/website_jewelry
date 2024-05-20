<?php

include_once("../connection/connect.s.php");

class GetHotDeals extends Database
{
      public function getHotDeals()
      {
            try {
                  $query = "SELECT * FROM `product` WHERE `product`.`isOutstanding` = 1 AND `product`.`deleted` != 1";

                  $statement = $this->connect()->query($query);

                  return json_encode($statement->fetchAll(PDO::FETCH_ASSOC) ?? []);
            } catch (Exception $e) {
                  $e->getMessage();
                  exit();
            }
      }
}

$hotDealObj = new GetHotDeals();

echo $hotDealObj->getHotDeals();
