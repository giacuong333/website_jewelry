<?php

if (isset($_POST["signup"])) {
    // Grab data
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone_number = trim($_POST["phone_number"]);
    $password = trim($_POST["password"]);

    include_once("../server/connection/connect.s.php");
    include_once("../server/models/signupmodel.s.php");
    include_once("../server/controllers/signupcontr.s.php");

    $signup = new SignupController($fullname, $email, $phone_number, $password);
    $signup->signupUser();
}
