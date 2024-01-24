<?php

class Signup extends Database
{

          protected function setUser($fullname, $email, $phone_number, $password)
          {
                    try {
                              $sql = "INSERT INTO `user` (`fullname`, `email`, `phone_number`, `password`) VALUES (?, ?, ?, ?);";
                              $stmt = $this->connect()->prepare($sql);

                              // Encode the password
                              $hashPassword = password_hash($password, PASSWORD_DEFAULT);

                              $stmt->execute([$fullname, $email, $phone_number, $hashPassword]);
                    } catch (PDOException $e) {
                              header("location: ../index.php?error=stmtfailer");
                              exit();
                    }
          }

          protected function checkUser($email)
          {
                    try {
                              $sql = "SELECT `email` FROM `user` WHERE `email` = ?";
                              $stmt = $this->connect()->prepare($sql);

                              $stmt->execute([$email]);

                              return $stmt->rowCount() > 0;
                    } catch (PDOException $e) {
                              header("location: ../index.php?error=stmtfailer");
                              exit();
                    }
          }
}
