<?php
if (isset($_POST["login"])) {
    // Check if user logged in
    session_start();

    if (!isset($_SESSION["id"]) && !isset($_SESSION["useremail"])) {

        // Instatiate LoginController class
        include("../server/connection/connect.s.php");
        include("../server/models/loginmodel.s.php");
        include("../server/controllers/logincontr.s.php");

        // Grab the data
        $useremail = $_POST["useremail"];
        $password = $_POST["password"];

        $login = new LoginController($useremail, $password);
        $login->loginUser();

        // Staff
        if ($_SESSION["role_id"] == 1 || $_SESSION["role_id"] == 2 || $_SESSION["role_id"] == 4) {
            echo 1;
            exit();
        } elseif ($_SESSION["role_id"] == 3) { // Customer
            echo 2;
            exit();
        }
    } else {
        header("location: ../index.php?error=none");
        exit();
    }
}
