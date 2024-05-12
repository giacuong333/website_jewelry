<?php
session_start();
$total_price = 0;
$total_items = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cart</title>

    <!-- JQUERY -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>

    <!-- Js -->
    <script src="../js/login.js" type="module"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/cart.css">
</head>

<body>
    <header></header>
    <!-- header -->
    <?php
    include_once("../templates/header.php")
    ?>
    <!-- Nội dung của trang Giỏ hàng -->
    </header>
    <main>
        <section class="cart">
            <div class="breadcrumb">
                <a href="./trangchu.php" class="breadcrumb-item" style="padding-left: 20px;">Trang chủ</a>
                <span class="breadcrumb-separator">&gt;</span>
                <span class="breadcrumb-item">Giỏ hàng</span>

            </div>

            <div class="content">
                <div class="cart-content row">
                    <div class="cart-content-left">
                        <table>
                            <tr>
                                <th>Ảnh sản phẩm</th>
                                <th>Tên sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                                <th>Xóa</th>
                            </tr>
                            <?php
                            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $item) {
                                    $item_total = $item['price'] * $item['quantity'];
                                    $total_price += $item_total;
                                    $total_items += $item['quantity'];

                                    echo "<tr>";
                                    echo "<td><img src='" . $item['image'] . "' alt=''></td>";
                                    echo "<td><p>" . $item['name'] . "</p></td>";
                                    echo "<td>" . number_format($item['price'], 0, ',', '.') . " <sup>đ</sup></td>";
                                    echo "<td><input type='number' value='" . $item['quantity'] . "'></td>";
                                    echo "<td>" . number_format($item_total, 0, ',', '.') . "</td>";
                                    echo "<td><button>X</button></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>Giỏ hàng trống</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <div class="cart-content-right">
                        <table>
                            <tr>
                                <th colspan="2">TỔNG TIỀN GIỎ HÀNG</th>
                            </tr>
                            <tr>
                                <td>TỔNG SẢN PHẨM</td>
                                <td><?php echo $total_items; ?></td>
                            </tr>
                            <tr>
                                <td>TỔNG TIỀN HÀNG</td>
                                <td><?php echo number_format($total_price, 0, ',', '.'); ?><sup>đ</sup></td>
                            </tr>
                            <tr>
                                <td>TẠM TÍNH</td>
                                <td>
                                    <p style="color: #7fcbc9; font-weight: bold;">
                                        <?php echo number_format($total_price, 0, ',', '.'); ?> <sup>đ</sup>
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <div class="cart-content-right-button">
                            <button>TIẾP TỤC MUA HÀNG</button>
                            <button>TIẾN HÀNG ĐẶT HÀNG</button>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
    <!-- footer -->
    <?php include_once("../templates/footer.php")  ?>
</body>

</html>