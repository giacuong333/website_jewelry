<div class="overlay d-none"></div>
<div class="popupcart bg-white p-5 d-none">
    <div class="popuppanel">
        <div class="popuppanel__header mb-3">
            <i class="fa-solid fa-check" style="color: #7fcbc9; font-weight: 900; font-size: 20px"></i>
            <span id="popuppanel__header_title" style="font-weight: 900; font-size: 18px">Bạn đã thêm <span style="color: #7fcbc9;"></span> vào giỏ hàng</span>
        </div>
        <div class="popuppanel__subheader mb-2">
            <i class="fa-solid fa-cart-shopping" style="color: #7fcbc9; font-weight: 900; font-size: 20px"></i>
            <a href="./SanPham.php" id="popuppanel__subheader_cart"></a>
        </div>
        <div style="max-height: 250px; overflow-y: scroll;" class="mb-3">
            <table class="popuppanel__table table border">
                <thead class="sticky-top">
                    <tr style="background-color: #f7f7f7;">
                        <th style="font-size: 14px;" class="border">SẢN PHẨM</th>
                        <th style="font-size: 14px;" class="border text-center">ĐƠN GIÁ</th>
                        <th style="font-size: 14px;" class="border text-center">SỐ LƯỢNG</th>
                        <th style="font-size: 14px;" class="border text-center">THÀNH TIỀN</th>
                    </tr>
                </thead>
                <tbody class="product_in_cart">
                    <!-- <tr class="productid-1">
                        <td class="d-flex align-items-start">
                            <img src="../assets/imgs/Nhẫn vòng ADV.png" alt="" class="img-responsive border" style="width: 80px">
                            <div class="d-inline-flex flex-column justify-content-start align-items-start ms-2">
                                <span style="font-size: 14px; font-weight: 600; color: #7fcbc9;" class="mb-2">Vòng tay cao cấp</span>
                                <span style="font-size: 12px; font-weight: 500; color: #aaa; cursor: pointer"><i class="fa-solid fa-close me-1 mb-2" style="font-weight: 900; font-size: 14px"></i>Bỏ sản phẩm</span>
                            </div>
                        </td>
                        <td class="text-center" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">
                            500.000đ
                        </td>
                        <td class="text-center">
                            <div>
                                <button type="button" class="minus">-</button>
                                <input type="number" name="quantity" value="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </td>
                        <td class="text-center" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">1.500.000đ</td>
                    </tr>

                    <tr class="productid-2">
                        <td class="d-flex align-items-start">
                            <img src="../assets/imgs/Nhẫn vòng ADV.png" alt="" class="img-responsive border" style="width: 80px">
                            <div class="d-inline-flex flex-column justify-content-start align-items-start ms-2">
                                <span style="font-size: 14px; font-weight: 600; color: #7fcbc9;" class="mb-2">Vòng tay cao cấp</span>
                                <span style="font-size: 12px; font-weight: 500; color: #aaa; cursor: pointer"><i class="fa-solid fa-close me-1 mb-2" style="font-weight: 900; font-size: 14px"></i>Bỏ sản phẩm</span>
                                <span style=" color: #898989; font-size: 14px"><i class="fa-solid fa-check me-1" style="color: #7fcbc9; font-weight: 900; font-size: 14px"></i>Sản phẩm vừa thêm!</span>
                            </div>
                        </td>
                        <td class="text-center" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">
                            500.000đ
                        </td>
                        <td class="text-center">
                            <div>
                                <button type="button" class="minus">-</button>
                                <input type="number" name="quantity" value="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </td>
                        <td class="text-center" style="font-size: 14px; font-weight: 600; color: #7fcbc9;">1.500.000đ</td>
                    </tr> -->
                </tbody>
            </table>
        </div>

        <div class="popuppanel__bottom d-flex align-items-center justify-content-between">
            <div class="popuppanel__bottom-left" style="font-size: 14px;">
                <p class="mb-0">Giao hàng trên toàn quốc</p>
                <a href="SanPham.php" style="font-size: 12px;">Tiếp tục mua hàng</a>
            </div>
            <div class="popuppanel__bottom-right">
                <p>Thành tiền: <span style="color: #7fcbc9; font-weight: 600" id="total_or_order"></span></p>
            </div>
        </div>

        <button type="button" name="btn-placeorder" class="btn btn-primary rounded-0">TIẾN HÀNH ĐẶT HÀNG</button>

        <!-- Close icon -->
        <button type="button" class="fa-solid fa-close popupcart_close"></button>
    </div>
</div>