<?php

if (isset($_POST["login"])) {

          session_start();

          // Check if user logged in

          if (!isset($_SESSION["id"]) && !isset($_SESSION["useremail"])) {
                    // Grab the data
                    $useremail = trim($_POST["useremail"]);
                    $password = trim($_POST["password"]);

                    // Instatiate LoginController class
                    include("../server/connection/connect.s.php");
                    include("../server/models/loginmodel.s.php");
                    include("../server/controllers/logincontr.s.php");

                    $login = new LoginController($useremail, $password);
                    $login->loginUser();

                    // Go back to the home page
                    header("location: ../index.php?error=none");
          } else {
                    header("location: ../index.php?error=none");
          }
}
