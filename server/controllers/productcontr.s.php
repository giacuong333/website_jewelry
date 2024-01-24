<?php

class ProductController extends Product
{
          public function __construct()
          {
          }

          public function getProducts()
          {
                    return $this->getAllProducts();
          }

          public function getProductId($id)
          {
                    return $this->getProductById($id);
          }

          public function setProduct($title, $price, $category_id, $discount, $thumbnail, $description)
          {
                    return $this->setNewProduct($title, $price, $category_id, $discount, $thumbnail, $description);
          }
}
