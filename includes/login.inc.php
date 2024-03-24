<?php
if (isset($_POST["login"])) {
    session_start();

    // Check if user logged in
    if (!isset($_SESSION["id"]) && !isset($_SESSION["useremail"])) {

        // Instatiate LoginController class
        include_once("../server/connection/connect.s.php");
        include_once("../server/models/loginmodel.s.php");
        include_once("../server/controllers/logincontr.s.php");

        // Grab the data
        $useremail = $_POST["useremail"];
        $password = $_POST["password"];

        $login = new LoginController($useremail, $password);
        $login->loginUser();

        if ($_SESSION["role_id"] == 3) { // Customer
            echo 2;
            exit();
        } else { // Staff
            echo 1;
            exit();
        }
    } else {
        header("location: ../index.php?error=none");
        exit();
    }
}
