<?php

class ForgetPassWordModel extends Database
{
    protected function getPasswordByEmail($email)
    {
        $sql = "SELECT * FROM `user` WHERE `user`.`email` = ?;";
        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user ?? [];
        } catch (Exception $e) {
            exit($e);
        }
    }

    protected function generateRandomPassword($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';
        $characters_length = strlen($characters);
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $characters_length - 1)];
        }
        return $password;
    }

    protected function updatePasswordByEmail($email, $hashed_password)
    {
        $sql = "UPDATE `user` SET `password` = ? WHERE `email` = ?;";
        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$hashed_password, $email]);
        } catch (Exception $e) {
            exit();
        }
    }
}
