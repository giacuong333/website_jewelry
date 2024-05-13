<?php
include_once("../server/connection/connect.s.php");
include_once("../server/models/paymentmodel.s.php");
include_once("../server/controllers/paymentcontr.s.php");

session_start();

if (!isset($_POST["place-order"])) {
      header("Location: ../templates/trangchu.php?notsubmitted");
      exit();
}

if (!isset($_SESSION["id"], $_SESSION["useremail"], $_SESSION["fullname"], $_SESSION["phone_number"], $_POST["address"], $_POST["district"], $_POST["province"], $_POST["note"])) {
      header("Location: ../templates/trangchu.php?missingdata");
      exit();
}

$userId = $_SESSION["id"];
$userEmail = $_SESSION["useremail"];
$userFullName = $_SESSION["fullname"];
$userPhoneNumber = $_SESSION["phone_number"];
$userAddress = $_POST["address"] . ", " . $_POST["district"] . ", " . $_POST["province"];
$userNote = $_POST["note"];

$userInfo = [
      "id" => $userId,
      "email" => $userEmail,
      "fullname" => $userFullName,
      "phone_number" => $userPhoneNumber,
      "address" => $userAddress,
      "note" => $userNote
];

$userProducts = $_SESSION["cart"];

$paymentObj = new PaymentController();
$isPlaced = $paymentObj->placeOrder($userInfo, $userProducts);

if ($isPlaced) {
      unset($_SESSION['cart']);
      $redirectUrl = $isPlaced ? "../templates/trangchu.php?success" : "../templates/trangchu.php?failed";
      header("Location: $redirectUrl");
      exit();
}
