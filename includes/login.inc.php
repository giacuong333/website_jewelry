<?php
session_start();

// Instatiate LoginController class
include("../server/connection/connect.s.php");
include("../server/models/loginmodel.s.php");
include("../server/controllers/logincontr.s.php");

if (isset($_POST["login"])) {
    // Check if user logged in
    if (!isset($_SESSION["id"]) && !isset($_SESSION["useremail"])) {
        // Grab the data
        $useremail = $_POST["useremail"];
        $password = $_POST["password"];

        $login = new LoginController($useremail, $password);
        $login->loginUser();

        // If admin, staff, manager
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
