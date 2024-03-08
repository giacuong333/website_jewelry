<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
</head>

<body>
  <h1>This is the home page</h1>
  <form action="./includes/logout.inc.php">
    <input type="submit" name="logout" value="logout">
  </form>
  <form action="./templates/login.php">
    <input type="submit" value="log in page">
  </form>
  <form action="./templates/signup.php">
    <input type="submit" value="sign up page">
  </form>
</body>

</html>

<?php
session_start();

if (isset($_SESSION["id"]) && isset($_SESSION["useremail"])) {
  echo $_SESSION["id"] . " - " . $_SESSION["useremail"];
}
?>