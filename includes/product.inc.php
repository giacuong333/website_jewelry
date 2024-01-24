<?php

include("../server/connection/connect.s.php");
include("../server/models/productmodel.s.php");
include("../server/controllers/productcontr.s.php");

$product = new ProductController();
$products = $product->getProducts();

print_r($products);

echo "<br>";
print_r($product->getProductId(4));