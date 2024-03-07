<?php
require_once("../server/connection/connect.s.php");
require_once("../server/models/forgetpassword.s.php");

if (isset($_POST["getformerpassword"])) {
    $user_email = $_POST["useremail"] ?? "";

    if (!empty($user_email)) {
        require_once("../server/controllers/forgetpassword.s.php");

        $password_object = new ForgetPassWordContr();

        $user = $password_object->getPasswordByEmail($user_email);

        if (!empty($user)) {
            $new_password = $password_object->generateRandomPassword();
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $password_object->updatePasswordByEmail($user_email, $hashed_password);

            $to = "$user_email";
            $subject = "Your new password";
            $message = "Your new password is: $hashed_password";
            $headers = "From: webtrangsuc@gmail.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            if (mail($to, $subject, $message, $headers)) {
                echo "<script>alert('A new password was sent to $user_email')</script>";
                header("Location: ../templates/login.php");
                exit();
            } else {
                echo "<script>alert('Failed to send email')</script>";
            }
        } else {
            header("Location: ../templates/login.php?error=wrongemail");
            exit();
        }
    } else {
        header("Location: ../templates/login.php?error=emptyinput");
        exit();
    }
}
