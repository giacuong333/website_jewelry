<?php

include_once("../server/connection/connect.s.php");
include_once("../server/models/changepwd.s.php");
include_once("../server/controllers/chanepwdcontr.s.php");

if (isset($_POST["type"]) && $_POST["type"] === "changepwd") {
      session_start();

      $changePwdObj = new PwdChangingContr();

      $id = $_SESSION["id"];
      $oldPwd = $_POST["oldPwd"];
      $newPwd = $_POST["newPwd"];

      $isChanged = $changePwdObj->changePwd($oldPwd, $newPwd, $id);

      echo $isChanged;
}
