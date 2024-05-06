<?php

class PwdChangingModel extends Database
{
      protected function changePwd($oldPwd, $newPwd, $id)
      {
            try {
                  if (!$this->checkPwd($oldPwd, $id)) {
                        return false;
                  }

                  $newPwdHashed = password_hash($newPwd, PASSWORD_DEFAULT);

                  $sql = "UPDATE `user` SET `user`.`password` = ? WHERE `user`.`id` = ?";
                  $statement = $this->connect()->prepare($sql);
                  return $statement->execute([$newPwdHashed, $id]);
            } catch (Exception $e) {
                  $e->getMessage();
                  return false;
            }
      }

      private function checkPwd($pwd, $id)
      {
            try {
                  $sql = "SELECT `user`.`password` FROM `user` WHERE `user`.`id` = ?";
                  $statement = $this->connect()->prepare($sql);
                  $statement->execute([$id]);
                  $row = $statement->fetch(PDO::FETCH_ASSOC);
                  return password_verify($pwd, $row['password']);
            } catch (Exception $e) {
                  $e->getMessage();
                  return false;
            }
      }
}
