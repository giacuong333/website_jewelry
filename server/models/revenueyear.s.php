<?php

include_once("../connection/connect.s.php");

class Revenue extends Database
{
      public function getStatisticYear()
      {

            try {
                  $sql = "SELECT SUM(`total_money`) AS `revenue`, YEAR(`order_date`) AS `order_date`  
                  FROM `order` 
                  WHERE `status` = 1 
                  GROUP BY YEAR(`order_date`);";

                  $stmt = $this->connect()->prepare($sql);
                  $stmt->execute();

                  $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  // Check if data is empty
                  if (empty($data)) {
                        throw new Exception("No data found");
                  }

                  return json_encode($data);
            } catch (Exception $e) {
                  $e->getMessage();
                  exit();
            }
      }
}

$revenue = new Revenue();
echo $revenue->getStatisticYear();
