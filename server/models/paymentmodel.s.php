<?php

class PaymentModel extends Database
{
      protected function placeOrder($userInfo, $userProducts)
      {
            try {
                  $pdo = $this->connect();

                  $pdo->beginTransaction();

                  $sqlOrder = "INSERT INTO `order` (`fullname`, `email`, `phone_number`, `address`, `note`, `user_id`) 
                  VALUES (?, ?, ?, ?, ?, ?)";
                  $statementOrder = $pdo->prepare($sqlOrder);
                  $statementOrder->execute(
                        [
                              $userInfo['fullname'],
                              $userInfo['email'],
                              $userInfo['phone_number'],
                              $userInfo['address'],
                              $userInfo['note'],
                              $userInfo["id"]
                        ]
                  );

                  $orderId = $pdo->lastInsertId();

                  foreach ($userProducts as $product) {
                        $productId = $product["id"];
                        $productQuantity = $product["customer_quantity"];

                        $sqlOrderDetails = "INSERT INTO `orderdetail` (`order_id`, `product_id`, `num`) 
                        VALUES (?, ?, ?)";
                        $statementOrderDetails = $pdo->prepare($sqlOrderDetails);
                        $statementOrderDetails->execute(
                              [
                                    $orderId,
                                    $productId,
                                    $productQuantity
                              ]
                        );
                  }

                  $pdo->commit();
                  return true;
            } catch (Exception $e) {
                  $e->getMessage();

                  $pdo->rollBack();

                  return false;
            }
      }
}
