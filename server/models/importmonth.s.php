<?php

include_once("../connection/connect.s.php");

class Revenue extends Database
{
      public function getImportMonth()
      {
            try {
                  $thisYear = Date("Y"); // Get current year

                  $sql = "SELECT SUM(`total_import_order`) AS `revenue`, `created_at` AS `order_date` 
                  FROM `import` 
                  WHERE `isDeleted` != 1 AND YEAR(`created_at`) = $thisYear 
                  GROUP BY MONTH(`created_at`)
                  ORDER BY DATE(`created_at`);";

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
echo $revenue->getImportMonth();
