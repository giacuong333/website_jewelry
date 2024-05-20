<?php

include_once("../connection/connect.s.php");

class GetCategories extends Database
{
      public function getCategories()
      {
            try {
                  $query = "SELECT * FROM `category` WHERE `category`.`isDeleted` != 1";

                  $statement = $this->connect()->query($query);

                  return json_encode($statement->fetchAll(PDO::FETCH_ASSOC) ?? []);
            } catch (Exception $e) {
                  $e->getMessage();
                  exit();
            }
      }
}

$categoryObj = new GetCategories();

echo $categoryObj->getCategories();
