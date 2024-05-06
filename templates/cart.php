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
    <!-- header -->
    <?php
    include_once("../templates/header.php")
    ?>
    <!-- Nội dung của trang Giỏ hàng -->

    <section class="cart">
        <div class="breadcrumb">
            <a href="#" class="breadcrumb-item" style="padding-left: 20px;">Trang chủ</a>
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
                        <tr>
                            <td> <img src="..\assets\imgs\Nhẫn tình yêu.png" alt=""></td>
                            <td><p>Nhẫn tình yêu</p></td>
                            <td>900.000 <sup>đ</sup></td>
                            <td><input type="number" value="1"></td>
                            <td>900.000</td>
                            <td><button>X</button></td>
                        </tr>
                        <tr>
                            <td> <img src="..\assets\imgs\Nhẫn vòng ADV.png" alt=""></td>
                            <td><p>Nhẫn vòng ADV</p></td>
                            <td>900.000 <sup>đ</sup></td>
                            <td><input type="number" value="1"></td>
                            <td>900.000</td>
                            <td><button>X</button></td>
                        </tr>
                    </table>
                </div>
                <div class="cart-content-right">
                    <table>
                        <tr> 
                            <th colspan="2"> TỔNG TIỀN GIỎ HÀNG</th> 
                        </tr>
                        <tr>
                            <td> TỔNG SẢN PHẨM </td>
                            <td>1</td>
                        </tr>
                        <tr>
                            <td> TỔNG TIỀN HÀNG </td>
                            <td>900.000<sup>đ</sup></td>
                        </tr>
                        <tr>
                            <td>TẠM TÍNH</td>
                            <td>
                                <p style="color: #7fcbc9; font-weight: bold;">900.000 <sup>đ</sup></p>
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
    <!-- footer -->
    <?php include_once("../templates/footer.php")  ?>
</body>

</html>