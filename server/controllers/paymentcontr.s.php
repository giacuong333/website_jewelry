<?php

class PaymentController extends PaymentModel
{
      public function placeOrder($userInfo, $userProducts)
      {
            return PaymentModel::placeOrder($userInfo, $userProducts);
      }
}
