<?php
session_start();

include_once("../server/connection/connect.s.php");
include_once("../server/models/cartmodel.s.php");
include_once("../server/controllers/cartcontr.s.php");

if (isset($_POST["type"]) && $_POST["type"] === "addToCart") {
      $productId = $_POST["productId"];

      $cartObj = new CartController();
      $product = $cartObj->getProductById($productId);

      if ($product) {
            // If the cart is not initialized
            if (!isset($_SESSION["cart"])) {
                  $_SESSION["cart"] = array();
            }

            if (isset($_SESSION["cart"][$productId])) {
                  $_SESSION["cart"][$productId]["customer_quantity"] += 1;
            } else {
                  $product["customer_quantity"] = 1;
                  $_SESSION["cart"][$productId] = $product;
            }

            // return to js
            echo json_encode($_SESSION["cart"]);
      }
}

if (isset($_POST["type"]) && $_POST["type"] === "removeFromCart") {
      $productId = $_POST["productId"];

      // If the product is existing
      if (isset($_SESSION["cart"][$productId])) {
            // Remove the product from the session
            unset($_SESSION["cart"][$productId]);
      }

      echo json_encode($_SESSION["cart"]);
}

if (isset($_POST["type"]) && $_POST["type"] === "changeQuantity") {
      $productId = $_POST["productId"];
      $customer_quantity = $_POST["customer_quantity"];

      if ($customer_quantity != 0) {
            $_SESSION["cart"][$productId]["customer_quantity"] = $customer_quantity;
      } else {
            unset($_SESSION["cart"][$productId]);
      }

      echo json_encode($_SESSION["cart"]);
}
