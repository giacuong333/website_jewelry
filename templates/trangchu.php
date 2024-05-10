<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang Chủ</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/config.css">
    <!-- ICON -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">
    <!-- SCRIPT -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>
    <script src="../js/header.js"></script>
</head>

<body>
    <div id="wrapper">
        <!--Start Header-->
        <?php include_once 'header.php'; ?>
       
        <!-- End Header -->
        <!-- Banner -->
        <div class="banner">
            <div class="banner-item">
                <img src="../assets/imgs/banner/img1.jpg" alt="" />

            </div>
            <div class="banner-item">
                <img src="../assets/imgs/banner/img2.jpg" alt="" />

            </div>
            <div class="banner-item">
                <img src="../assets/imgs/banner/img3.jpg" alt="" />

            </div>
        </div>
        <script>
            const images = document.querySelectorAll(".banner img");
            let currentIndex = 0;

            function showImage(index) {
                images.forEach((img, i) => {
                    if (i === index) {
                        img.classList.add("active");
                    } else {
                        img.classList.remove("active");
                    }
                });
            }

            // Hiển thị hình ảnh đầu tiên ngay từ đầu
            showImage(currentIndex);

            function rotateImages() {
                currentIndex = (currentIndex + 1) % images.length;
                showImage(currentIndex);
            }

            // Thay đổi hình ảnh sau mỗi vài giây
            setInterval(rotateImages, 3000); // Đổi hình ảnh mỗi 3 giây (3000ms)
        </script>
        <!-- End Banner -->
        <!-- Start Section -->
        <section class="section-top-60">
            <div class="shell">
                <div class="range">
                    <div class="cell">
                        <a href="#"><img src="../assets/imgs/section/section1.jpg" alt="Trang suc" /></a>
                    </div>
                    <div class="cell">
                        <div class="range">
                            <div class="cell-child">
                                <a href="#"><img src="../assets/imgs/section/section2.jpg" alt="Trang suc" /></a>
                            </div>
                            <div class="cell-child cell-padding-top-20">
                                <a href="#"><img src="../assets/imgs/section/section3.jpg" alt="Trang suc" /></a>
                            </div>
                        </div>
                    </div>
                    <div class="cell">
                        <a href="#"><img src="../assets/imgs/section/section4.jpg" alt="Trang suc" /></a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Section -->
        <!-- Start list-product -->
        <section class="section-top-60">
            <div class="shell">
                <h1>Danh mục sản phẩm</h1>
                <hr class="divider divider-base divider-bold">
                <div class="range">
                    <div class="offset">
                        <a href="#" class="thumbnail-variant-1">
                            <img src="../assets/imgs/section/lsprd1.jpg" alt="">
                            <div class="caption">
                                <h2 class="caption-title">Trâm cài</h2>
                                <p class="caption-descr">4 sản phẩm</p>
                            </div>
                        </a>
                    </div>
                    <div class="offset">
                        <a href="#" class="thumbnail-variant-1">
                            <img src="../assets/imgs/section/lsprd2.jpg" alt="">
                            <div class="caption">
                                <h2 class="caption-title">Nhẫn</h2>
                                <p class="caption-descr">4 sản phẩm</p>
                            </div>
                        </a>
                    </div>
                    <div class="offset">
                        <a href="#" class="thumbnail-variant-1">
                            <img src="../assets/imgs/section/lsprd3.jpg" alt="">
                            <div class="caption">
                                <h2 class="caption-title">Bông tai</h2>
                                <p class="caption-descr">4 sản phẩm</p>
                            </div>
                        </a>
                    </div>
                    <div class="offset">
                        <a href="#" class="thumbnail-variant-1">
                            <img src="../assets/imgs/section/lsprd4.jpg" alt="">
                            <div class="caption">
                                <h2 class="caption-title">Vòng cổ</h2>
                                <p class="caption-descr">4 sản phẩm</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <!-- End list-product -->
        <!-- Start Hot Deal -->
        <section class="section-top-60">
            <div class="shell">
                <h3>
                    <a href="">HOT DEAL</a>
                </h3>
                <hr class="divider divider-base divider-bold">

                <div class="hot-deal-prd">
                    <div class="product">
                        <div class="product-img">
                            <a href="#">
                                <img class="img-prd" src="../assets/imgs/section/hotdealprd1.jpg" alt="">
                            </a>


                        </div>
                        <div class="product-name">
                            <p class="big"><a href="#">Nhẫn vòng ADV
                                </a></p>
                        </div>
                        <div class="product-price">
                            700.000₫
                        </div>
                    </div>
                    <div class="product">
                        <div class="product-img">
                            <a href="#">
                                <img src="../assets/imgs/section/hotdealprd2.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name">
                            <p class="big"><a href="#">Nhẫn vòng ADV
                                </a></p>
                        </div>
                        <div class="product-price">
                            700.000₫
                        </div>
                    </div>
                    <div class="product">
                        <div class="product-img">
                            <a href="#">
                                <img src="../assets/imgs/section/hotdealprd3.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name">
                            <p class="big"><a href="#">Nhẫn vòng ADV
                                </a></p>
                        </div>
                        <div class="product-price">
                            700.000₫
                        </div>
                    </div>
                    <div class="product">
                        <div class="product-img">
                            <a href="#">
                                <img src="../assets/imgs/section/hotdealprd4.jpg" alt="">
                            </a>
                        </div>
                        <div class="product-name">
                            <p class="big"><a href="#">Nhẫn vòng ADV
                                </a></p>
                        </div>
                        <div class="product-price">
                            700.000₫
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Hot Deal -->
        <!-- Start About -->
        <section class="section-top-60">
            <div class="shell about-img">
                <h4>
                    Giới thiệu cửa hàng
                </h4>
                <hr class="divider divider-base divider-bold">
                <div class="about">

                    <div class="about-content">
                        <p> CHÚNG TÔI CUNG CẤP BẠN CÁC HÀNG HÓA UNIQUE VỀ SẢN PHẨM CỦA CHÚNG TÔI LÀ BẢO QUẢN REAL.</p>
                        <p>
                            Với kinh nghiệm 100 năm sản xuất trang sức thủ công, chúng tôi tin rằng bạn sẽ hài lòng với
                            sản phẩm của chúng tôi. Giá cả phải chăng, mẫu mã đẹp mắt, màu sắc đa dạng, chúng tôi cam
                            kết sẽ làm bạn hài lòng.
                        </p>
                    </div>
                </div>
            </div>
            <!-- End About-->
            <!-- Start product -->
            <section class="section-top-60">
                <div class="shell">
                    <div class="range">
                        <div class="cell-product">
                            <h5><a href="#">Mới nhất</a></h5>
                            <hr class="divider divider-base divider-bold divider-left">
                            <div class="range-product">
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Nhẫn</a></div>
                                            <div class="big"><a href="" class="text-base">Nhẫn vòng ADV</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn Bạc ME Đính Đá Tráng Men Trắng.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Bông tai</a></div>
                                            <div class="big"><a href="" class="text-base">Bông tai cao cấp Biz</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Nhẫn</a></div>
                                            <div class="big"><a href="" class="text-base">Nhẫn vòng ADV</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cell-product">
                            <h5><a href="#">Mới nhất</a></h5>
                            <hr class="divider divider-base divider-bold divider-left">
                            <div class="range-product">
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Nhẫn</a></div>
                                            <div class="big"><a href="" class="text-base">Nhẫn vòng ADV</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Nhẫn</a></div>
                                            <div class="big"><a href="" class="text-base">Nhẫn vòng ADV</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Nhẫn</a></div>
                                            <div class="big"><a href="" class="text-base">Nhẫn vòng ADV</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cell-product">
                            <h5><a href="#">Mới nhất</a></h5>
                            <hr class="divider divider-base divider-bold divider-left">
                            <div class="range-product">
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Nhẫn</a></div>
                                            <div class="big"><a href="" class="text-base">Nhẫn vòng ADV</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Nhẫn</a></div>
                                            <div class="big"><a href="" class="text-base">Nhẫn vòng ADV</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell-product">
                                    <div class="unit">
                                        <div class="unit-left">
                                            <a href=""><img src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                        </div>
                                        <div class="unit-body">
                                            <div class="p"><a href="#">Nhẫn</a></div>
                                            <div class="big"><a href="" class="text-base">Nhẫn vòng ADV</a></div>
                                            <div class="product-price">700.000₫</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End product -->
            <!-- Footer -->
            <?php include_once('footer.php'); ?>
            <!-- End Footer -->
    </div>
</body>

</html>