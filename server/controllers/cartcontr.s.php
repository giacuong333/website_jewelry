<?php

class CartController extends CartModel
{
      public function getProductById($productId)
      {
            return CartModel::getProductById($productId);
      }
}
