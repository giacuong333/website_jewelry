<?php

include_once("../connection/connect.s.php");

class Revenue extends Database
{
      public function getStatisticMonth()
      {
            try {
                  $thisYear = Date("Y");

                  $sql = "SELECT SUM(`total_money`) AS `revenue`, `order_date` 
                  FROM `order` 
                  WHERE `status` = 1 AND YEAR(`order_date`) = $thisYear 
                  GROUP BY MONTH(`order_date`)
                  ORDER BY DATE(`order_date`);";

                  $stmt = $this->connect()->query($sql);

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
echo $revenue->getStatisticMonth();
