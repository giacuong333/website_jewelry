<?php
class Login extends Database
{

    protected function getUser($useremail, $password)
    {
        $sql = "SELECT `id`, `email`, `password`, `fullname`, `phone_number`, `role_id` 
        FROM `user` WHERE `email` = ?;";

        try {
            $stmt = $this->connect()->prepare($sql);
            $stmt->execute([$useremail]);
            // The account does not exist
            if ($stmt->rowCount() == 0) :
                echo "usernotfound";
                exit();
            endif;

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $checkPassword = password_verify($password, $user["password"]);
            // Wrong password
            if (!$checkPassword) :
                echo "wrongpassword";
                exit();
            endif;

            // Success
            $_SESSION["id"] = $user["id"];
            $_SESSION["useremail"] = $user["email"];
            $_SESSION["fullname"] = $user["fullname"];
            $_SESSION["phone_number"] = $user["phone_number"];
            $_SESSION["role_id"] = $user["role_id"];
        } catch (PDOException $e) {
            header("location: ../templates/login.php?error=stmtfailed");
            exit();
        }
    }
}
