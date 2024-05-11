<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Thanh toán</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/config.css"> <!-- Đường dẫn tới tập tin CSS của bạn -->
    <link rel="stylesheet" href="../assets/css/checkout.css"> <!-- CSS cho trang phản hồi -->
    <!-- JQUERY -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script> <!-- Đường dẫn tới jQuery -->
    <!-- JavaScript -->
    <script src="../js/checkout.js" type="module"></script> <!-- JavaScript cho trang phản hồi -->
</head>

<body>
    <?php
        include_once("../templates/header.php"); // tieu de
    ?>
    <div class="checkout-body">
        <!-- Phan thong tin thanh toan -->
        <div class="checkout-body__main">
            <h5>THANH TOÁN</h5>
            <div class="checkout-body__main__info">
                <div class="checkout-body__main__info__header">Thông tin nhận hàng</div>

                <div class="checkout-body__main__info__name">
                    <label for="name" style="padding-left: 10px;">Họ và tên<span style="color: red;">*</span></label>
                    <input type="text" id="checkout-name" name="checkout-name" placeholder="Họ và tên">
                    <div class="error-message"></div>
                </div>

                <div class="checkout-body__main__info__phoneNum">
                    <label for="phoneNum" style="padding-left: 10px;">Số điện thoại
                        <span style="color: red;">*</span></label>
                    <input type="text" id="checkout-phoneNum" name="checkout-phoneNum" placeholder="Số điện thoại">
                    <div class="error-message"></div>
                </div>

                <div class="checkout-body__main__info__city">
                    <label for="city" style="padding-left: 10px;">Thành phố/ tỉnh
                        <span style="color: red;">*</span></label>
                    <input type="text" id="checkout-city" name="checkout-city" placeholder="Thành phố/ tỉnh">
                    <div class="error-message"></div>
                </div>

                <div class="checkout-body__main__info__ward">
                    <label for="ward" style="padding-left: 10px;">Quận/ huyện <span style="color: red;">*</span></label>
                    <input type="text" id="checkout-ward" name="checkout-ward" placeholder="Quận/ huyện">
                    <div class="error-message"></div>
                </div>

                <div class="checkout-body__main__info__address">
                    <label for="name" style="padding-left: 10px;">Địa chỉ chi tiết <span
                            style="color: red;">*</span></label>
                    <input type="text" id="checkout-address" name="checkout-address"
                        placeholder="Địa chỉ chi tiết (số nhà, đường/ Xóm, thôn)">
                    <div class="error-message"></div>
                </div>
                <div class="checkout-body__main__info__note">
                    <label for="checkout-note" style="padding-left: 10px;">Ghi chú cho đơn hàng</label>
                    <textarea name="checkout-note" id="checkout-note"
                        placeholder="Ghi chú cho shop (tùy chọn)"></textarea>
                </div>

            </div>
        </div>
        <div class="delivery">
            <div class="delivery__delivery" style="padding-left: 10px;">
                <input type="radio" name="shippingMethod" id="shippingMethod" value="" />

                <label for="shippingMethod" class="shippingMethod">Giao hàng tận nơi</label>
            </div>
            <div class="delivery__checkoutMethod" style="padding-left: 10px;">
                <input type="radio" name="checkoutMethod" id="checkoutMethod" value="" />

                <label for="checkoutMethod" class="checkoutMethod">Thanh toán khi giao hàng</label>
            </div>
        </div>
        <!-- //Phan checkout -->
        <div class="checkout-body__aside">
            <div class="checkout-body__aside__sideContent">
                <label for="" style="font-weight: bold; padding-left: 10px;">Đơn hàng</label>
                <hr style="width:100%;">

                <!-- render san pham da dat  -->
                <div class="product-ordered">
                    <tr>
                        <th>Sản phẩm</th>
                        <td>Giá</td>
                    </tr> <br>
                    <tr>
                        <th>Sản phẩm</th>
                        <td>Giá</td>
                    </tr>
                </div>
                <div class="discountCode">
                    <input type="text" placeholder="Nhập mã giảm giá">
                    <button class="btn-discountCode">Áp dụng</button>
                    <hr style="width:100%;">
                </div>
                <div class="estimate">
                    <tr>
                        <th>Tạm tính</th>
                        <td>Giá</td>
                    </tr> <br>
                    <tr>
                        <th>Phí vận chuyển</th>
                        <td>Giá</td>
                    </tr>
                    <hr style="width:100%;">
                </div>
                <div class="total">
                    <tr>
                        <th>Tổng cộng</th>
                        <td>Giá</td>
                    </tr>
                </div>
                <div class="final">
                    <a>
                        <pre> < Quay về giỏ hàng</pre>
                    </a>
                    <button class="btn-order">ĐẶT HÀNG</button>
                </div>
            </div>
        </div>

    </div>

</body>

</html>