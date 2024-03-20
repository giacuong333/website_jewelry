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
            $pass_code = $password_object->generateRandomPassword();

            // Send email with the passcode
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
                $mail->Subject = 'Reset password';
                $mail->Body    = "Your code is: $pass_code";

                $mail->send();

                // Save pass code into database
                $password_object->savePassCode($pass_code, $user_email);

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

if (isset($_POST["forgot_email"]) && isset($_POST["pass_code"])) {
    $email = $_POST["forgot_email"];
    $pass_code = $_POST["pass_code"];

    $check_passcode = new ForgetPassWordContr();

    $id_of_passcode = $check_passcode->getPassCodeAndExpiry($pass_code, $email);

    if (!empty($id_of_passcode)) {
        $expiry = strtotime($id_of_passcode["token_expiry"]);
        $code = $id_of_passcode["reset_token"];


        if ($code == $pass_code) {
            if ($expiry < time()) {
                echo "codeexpired";
            } else {
                echo '
                <div class="overlay"></div>
                <div class="change-password-container">
                    <form action="../includes/forgetpassword.inc.php" method="post">
                        <div class="form-group">
                            <label for=""></label>

                            <input type="text" class="" placeholder="Enter your new password" name="newpassword">

                            <button type="submit" class="btn btn--active" name="submit-newpassword" value="submit-newpassword">Change</button>
                        </div>
                    </form>
                </div>
                ';
            }
        }
    } else {
        echo "codedoesnotexist";
    }
}
