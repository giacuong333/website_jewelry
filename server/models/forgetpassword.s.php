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

            return true;
        } catch (Exception $e) {
            $e->getMessage();
            return false;
        }
    }

    protected function getPassCodeAndExpiry($code, $email)
    {
        try {
            $sql = "SELECT `reset_token`, `id`, `token_expiry` FROM `user` WHERE `email` = ? AND `reset_token` = ?;";

            $stmt = $this->connect()->prepare($sql);

            $stmt->execute([$email, $code]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result ?? null;
        } catch (Exception $e) {
            $e->getMessage();
            exit();
        }
    }

    protected function savePassCode($code, $email)
    {
        try {
            $sql = "UPDATE `user` SET `reset_token` = ?WHERE `email` = ?;";

            $stmt = $this->connect()->prepare($sql);

            return $stmt->execute([$code, $email]);
        } catch (Exception $e) {
            $e->getMessage();
            exit();
        }
    }
}
