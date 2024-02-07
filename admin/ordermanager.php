<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <!-- Icon -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">
    <!-- JQuery -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>

</head>

<body>
    <?php include("../admin/common.php"); ?>

    <main>
        <div class="dashboard-header">
            <input type="text" placeholder="Search" name="searchproductinput" id="searchproductinput" />

            <select class="btn- btn--hover" name="searchproductvalue" id="searchproductvalue">
                <option value="id">Id</option>
                <option value="fullname">Fullname</option>
                <option value="email">Email</option>
                <option value="phonenumber">Phone number</option>
            </select>
        </div>

        <!-- Product -->
        <div class="dashboard-body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Phone number</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="bodyorder">
                    <?php
                    include("../includes/admin.inc.php");

                    if (is_array($orders)) {
                        foreach ($orders as $order) {
                            $status = $order["status"] == 1 ? "Đã xử lý" : "Đang xử lý";
                    ?>
                            <tr class="row-order" data-orderid="<?php echo $order["id"]; ?>">
                                <td> <?php echo $order["id"]; ?></td>
                                <td> <?php echo $order["fullname"]; ?></td>
                                <td> <?php echo $order["email"]; ?></td>
                                <td><?php echo $order["phone_number"]; ?></td>
                                <td class="status">
                                    <button type="button" class=" btn- btn--hover"><?php echo $status; ?></button>
                                </td>
                                <td><?php echo $order["total_money"]; ?></td>
                                <td>
                                    <span class="fa-solid fa-pen-to-square edit-productbtn"></span>
                                    <span class="fa-solid fa-trash del-productbtn" name="del-product" value="del-product"></span>
                                </td>
                            </tr>

                            <!-- Order details -->
                            <div class="container">
                                <div class="overlay"></div>
                                <div class="content">
                                    <h2 class="content-header">
                                        Order details
                                    </h2>
                                    <div class="content-body">
                                        <div class="content-body__top">
                                            <div class="content-body__top-left">
                                                <h4>Date</h4>
                                                <p>10 October 2024</p>
                                            </div>
                                            <div class="content-body__top-right">
                                                <h4>Order ID</h4>
                                                <p>#1235</p>
                                            </div>
                                            <div class="content-body__top-bottom">
                                                <div class="content-body__top-address">
                                                    <h4>Address</h4>
                                                    <p>Xã Hòa Định Đông, thôn Định Thành, huyện Phú Hòa, tỉnh Phú Yên</p>
                                                </div>
                                                <div class="content-body__top-fullname">
                                                    <h4>Name</h4>
                                                    <p>Lê Gia Cường</p>
                                                </div>
                                                <div class="content-body__top-email">
                                                    <h4>Email</h4>
                                                    <p>lgcuong789@gmail.com</p>
                                                </div>
                                                <div class="content-body__top-phonenumber">
                                                    <h4>Phone nummber</h4>
                                                    <p>0956633258</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="content-body__middle">
                                            <div class="content-body__middle-product">
                                                <div class="content-body__middle-product-image"><img src="../assets/imgs/brooches/img1.png" alt="Product Image"></div>
                                                <div class="content-body__middle-product-name">BEATS Solo 3 Wireless Headphones <span>(3)</span></div>
                                                <div class="content-body__middle-product-price">1.300.000</div>
                                            </div>
                                            <div class="content-body__middle-product">
                                                <div class="content-body__middle-product-image"><img src="../assets/imgs/brooches/img1.png" alt="Product Image"></div>
                                                <div class="content-body__middle-product-name">BEATS Solo 3 Wireless Headphones <span>(3)</span></div>
                                                <div class="content-body__middle-product-price">1.300.000</div>
                                            </div>
                                            <div class="content-body__middle-product">
                                                <div class="content-body__middle-product-image"><img src="../assets/imgs/brooches/img1.png" alt="Product Image"></div>
                                                <div class="content-body__middle-product-name">BEATS Solo 3 Wireless Headphones <span>(3)</span></div>
                                                <div class="content-body__middle-product-price">1.300.000</div>
                                            </div>
                                            <div class="content-body__middle-product">
                                                <div class="content-body__middle-product-image"><img src="../assets/imgs/brooches/img1.png" alt="Product Image"></div>
                                                <div class="content-body__middle-product-name">BEATS Solo 3 Wireless Headphones <span>(3)</span></div>
                                                <div class="content-body__middle-product-price">1.300.000</div>
                                            </div>

                                            <div class="content-body__middle-shipping">
                                                <p class="content-body__middle-shipping-name">Shipping</p>
                                                <p class="content-body__middle-shipping-price">40.000</p>
                                            </div>
                                        </div>

                                        <div class="content-body__bottom">
                                            <p class="content-body__bottom-total">1.340.000</p>
                                        </div>
                                    </div>
                                    <div class="content-footer">
                                        <p class="content-footer__help">Want any help? Please contact us.</p>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>