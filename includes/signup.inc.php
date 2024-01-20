<?php

if (isset($_POST["signup"])) {

          // Grab data
          $fullname = trim($_POST["fullname"]);
          $email = trim($_POST["email"]);
          $phone_number = trim($_POST["phone_number"]);
          $password = trim($_POST["password"]);
          $role_id = trim($_POST["role"]);

          include("../server/connection/connect.s.php");
          include("../server/models/signupmodel.s.php");
          include("../server/controllers/signupcontr.s.php");

          $signup = new SignupController($fullname, $email, $phone_number, $password, $role_id);
          $signup->signupUser();

          header("location: ../templates/login.php?error=none");
}
