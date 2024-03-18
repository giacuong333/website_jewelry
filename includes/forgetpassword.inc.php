<?php
require_once("../server/connection/connect.s.php");
require_once("../server/models/forgetpassword.s.php");
require_once("../server/controllers/forgetpassword.s.php");

require_once("../assets/libs/PHPMailer-master/PHPMailer-master/src/PHPMailer.php");
require_once("../assets/libs/PHPMailer-master/PHPMailer-master/src/SMTP.php");
require_once("../assets/libs/PHPMailer-master/PHPMailer-master/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST["getformerpassword"])) {
    $user_email = $_POST["forgotuseremail"] ?? "";

    if (!empty($user_email)) {
        $password_object = new ForgetPassWordContr();

        // check whether the user exists
        $user = $password_object->getPasswordByEmail($user_email);

        if (!empty($user)) {
            $new_password = $password_object->generateRandomPassword();
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update user's password
            $password_object->updatePasswordByEmail($user_email, $hashed_password);

            // Send email with new password
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'legiacuong789@gmail.com';
                $mail->Password   = 'qbxh bwml qgvw hgpd';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port       = 587;

                $mail->setFrom('legiacuong789@gmail.com');
                $mail->addAddress($user_email);

                $mail->isHTML(true);
                $mail->Subject = 'Your new password';
                $mail->Body    = "Your new password is: $new_password";

                $mail->send();

                // Redirect user after sending email
                header("Location: ../templates/login.php?success=newpasswordsent");
                exit();
            } catch (Exception $e) {
                echo "<script>alert('Failed to send email: {$mail->ErrorInfo}')</script>";
            }
        } else {
            // Redirect if user does not exist
            header("Location: ../templates/login.php?error=wrongemail");
            exit();
        }
    } else {
        // Redirect if email field is empty
        header("Location: ../templates/login.php?error=emptyinput");
        exit();
    }
}
