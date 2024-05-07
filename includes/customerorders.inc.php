<?php

include_once("../server/connection/connect.s.php");
include_once("../server/models/customerorders.s.php");
include_once("../server/controllers/customerorderscontr.s.php");
session_start();

$userid = $_SESSION["id"];
$customerOrdersObj = new CustomerOrdersContr();
echo json_encode($customerOrdersObj->getOrdersById($userid));
