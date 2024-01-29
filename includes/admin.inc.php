<?php

include("../server/connection/connect.s.php");
include("../server/models/adminmodel.s.php");
include("../server/controllers/admincontr.s.php");

$admin = new AdminController();

$products = $admin->getAllProducts();
$users = $admin->getAllUsers();

// Handling when admin adds a new user
if (isset($_POST["saveuser"])) {
          $fullname = $_POST["fullname"];
          $email = $_POST["email"];
          $phonenumber = $_POST["phonenumber"];
          $password = $_POST["password"];
          $verifypassword = $_POST["verifypassword"];
          $roleid = $_POST["roleid"];

          $isSaved = $admin->setUser($fullname, $email, $phonenumber, $password, $verifypassword, $roleid);
          if ($isSaved) {
                    echo "<script>alert('Save a user successfully')</script>";
          } else {
                    echo "<script>alert('Save a user failed')</script>";
          }
}

// Handling when admin edits a new user
if (isset($_GET["upduser_id"])) {
          $user = $admin->getUserById($_GET["upduser_id"]);
}

// Update user
if (isset($_POST["updateuser"])) {
          $id = $_POST["user_id"];
          $fullname = $_POST["fullname"];
          $email = $_POST["email"];
          $phonenumber = $_POST["phonenumber"];
          $roleid = $_POST["roleid"];
          $isUpdated = $admin->updateUser($id, $fullname, $email, $phonenumber, $roleid);

          if ($isUpdated) {
                    echo "<script>alert('Update successfully')</script>";
                    echo "<script>window.location.href='../admin/usermanager.php'</script>";
          } else {
                    echo "<script>alert('Update failed')</script>";
          }
}



// Handling when admin deletes an user
if (isset($_GET["deluser_id"])) {
          $admin->deleteUserById($_GET["deluser_id"]);
          echo "<script>window.location.href='../admin/usermanager.php'</script>";
}
