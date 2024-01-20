<?php
class Database
{
          private const USERNAME = "root";
          private const PASSWORD = "";
          private const DTBNAME = "web_trang_suc";

          protected function connect()
          {
                    try {
                              $dtb = new PDO('mysql:host=localhost;dbname=' . self::DTBNAME, self::USERNAME, self::PASSWORD);

                              return $dtb;
                    } catch (PDOException $e) {
                              $e->getMessage();
                              die();
                    }
          }
}
