<?php
require_once("../server/connection/connect.s.php");
require_once("../server/models/forgetpassword.s.php");
require_once("../server/controllers/forgetpassword.s.php");

require_once("../assets/libs/PHPMailer-master/PHPMailer-master/src/PHPMailer.php");
require_once("../assets/libs/PHPMailer-master/PHPMailer-master/src/SMTP.php");
require_once("../assets/libs/PHPMailer-master/PHPMailer-master/src/Exception.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function sendMail($subject, $msg, $emailAddr, $username, $password, $host)
{
    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('legiacuong789@gmail.com');
        $mail->addAddress($emailAddr);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $msg;

        $mail->send();
    } catch (Exception $e) {
        // Handle any exceptions here
        echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
    }
}

// Send code to email
if (isset($_POST["getformerpassword"])) {
    $user_email = $_POST["forgotuseremail"] ?? "";

    // Used for resending password
    session_start();
    $_SESSION["user_email"] = $user_email;

    if (!empty($user_email)) {
        $password_object = new ForgetPassWordContr();

        // check whether the user exists
        $user = $password_object->getPasswordByEmail($user_email);

        if (!empty($user)) {
            $pass_code = $password_object->generateRandomPassword();

            // Send email with the passcode
            try {

                sendMail('Reset password', 'Your code is: ' . $pass_code, $user_email, 'legiacuong789@gmail.com', 'qbxh bwml qgvw hgpd', 'smtp.gmail.com');

                // Save pass code into database
                $password_object->savePassCode($pass_code, $user_email);

                // Redirect user after sending email
                header("Location: ../templates/login.php?success=newpasswordsent");
                exit();
            } catch (Exception $e) {
                echo "<script>alert('Failed to send email: {'" . $e->getMessage() . "')</script>";
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

// Send code to email again
if (isset($_POST["sendcode"])) {

    session_start();

    if (isset($_SESSION["user_email"])) {

        $user_email = $_SESSION["user_email"];

        $password_object = new ForgetPassWordContr();

        $pass_code = $password_object->generateRandomPassword();

        // Send email with the passcode
        try {

            sendMail('Reset password', 'Your code is: ' . $pass_code, $user_email, 'legiacuong789@gmail.com', 'qbxh bwml qgvw hgpd', 'smtp.gmail.com');

            // Save pass code into database
            $password_object->savePassCode($pass_code, $user_email);

            unset($_SESSION["user_email"]);

            // Redirect user after sending email
            header("Location: ../templates/login.php?success=newpasswordsent");
            exit();
        } catch (Exception $e) {
            $e->getMessage();
            exit();
        }
    } else {
        echo 'User not found';
        exit();
    }
}

// Clicking on `Xác nhận` 
if (isset($_POST["forgot_email"]) && isset($_POST["pass_code"])) {
    $email = $_POST["forgot_email"];
    $pass_code = $_POST["pass_code"];

    $check_passcode = new ForgetPassWordContr();

    $id_of_passcode = $check_passcode->getPassCodeAndExpiry($pass_code, $email);

    if (!empty($id_of_passcode)) {
        $expiry = $id_of_passcode["token_expiry"];
        $code = $id_of_passcode["reset_token"];

        date_default_timezone_set('Asia/Ho_Chi_Minh'); // Set timezone to Vietnam (Indochina Time)

        $current_datetime = date('Y-m-d H:i:s');

        if ($code == $pass_code) {
            if ($expiry < $current_datetime) {
                echo "codeexpired";
            } else {
                echo '
                <div class="overlay"></div>
                <div class="change-password-container">
                    <form action="../includes/forgetpassword.inc.php" method="post">
                        <div class="form-group">
                            <label for=""></label>

                            <input type="text" class="" placeholder="Enter your new password" name="newpassword" required>

                            <button type="button" class="btn btn--active" name="submit-newpassword">Change</button>
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

// Clicking on the `confirm` change password
if (isset($_POST["user_email"]) && isset($_POST["new_password"])) {
    $user_email = $_POST["user_email"];

    $new_password = $_POST["new_password"];

    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

    $forgotPassObj = new ForgetPassWordContr();

    $is_updated = $forgotPassObj->updatePasswordByEmail($user_email, $new_password_hashed);

    if ($is_updated) {
        echo 1;
    } else {
        echo 0;
    }
}
