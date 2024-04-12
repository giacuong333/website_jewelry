<?php

include_once("../connection/connect.s.php");

class Revenue extends Database
{
      public function getImportYear()
      {

            try {
                  $sql = "SELECT SUM(`total_import_order`) AS `revenue`, YEAR(`created_at`) AS `order_date`  
                  FROM `import` 
                  WHERE `isDeleted` != 1 
                  GROUP BY YEAR(`created_at`);";

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
echo $revenue->getImportYear();
