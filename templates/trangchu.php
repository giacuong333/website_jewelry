<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Trang Chủ</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/config.css">
    <link rel="stylesheet" href="../assets/css/sanpham.css">
    <link rel="stylesheet" href="../assets/css/homepage.css">

    <!-- SCRIPT -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>
    <script src="../js/cart.js" defer></script>
    <script src="../js/homepage.js" defer></script>

    <!-- ICON -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <?php
    if (isset($_SESSION['order_placed'])) {
        if ($_SESSION['order_placed']) {
            echo '<script>alert("Order placed successfully")</script>';
        } else {
            echo '<script>alert("Order placed failed")</script>';
        }
        unset($_SESSION['order_placed']);
    }
    ?>
    <?php include_once 'header.php'; ?>

    <main class="homepage" style="margin-top:135px">
        <div id="wrapper" class="container-fluid">
            <div class="row">
                <!--Start Header-->

                <!-- End Header -->
                <!-- Banner -->
                <div class="banner m-0" style="height: 470px;">
                    <div class="banner-item">
                        <img class="img-responsive w-100 h-100" style="object-fit:cover; object-position:center;" src="../assets/imgs/banner/img1.jpg" alt="" />

                    </div>
                    <div class="banner-item">
                        <img class="img-responsive w-100 h-100" style="object-fit:cover; object-position:center;" src="../assets/imgs/banner/img2.jpg" alt="" />

                    </div>
                    <div class="banner-item">
                        <img class="img-responsive w-100 h-100" style="object-fit:cover; object-position:center;" src="../assets/imgs/banner/img3.jpg" alt="" />

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
                        <div class="range row">
                            <div class="col-lg-4 col-md-4 col-12">
                                <a href="#"><img class="img-responsive w-100 h-100" src="../assets/imgs/section/section1.jpg" alt="Trang suc" /></a>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="range row h-100">
                                    <div class="col-lg-12 col-md-12">
                                        <a href="#"><img class="img-responsive w-100 h-100" src="../assets/imgs/section/section2.jpg" alt="Trang suc" /></a>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <a href="#"><img class="img-responsive w-100 h-100" src="../assets/imgs/section/section3.jpg" alt="Trang suc" /></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-12">
                                <a href="#"><img class="img-responsive w-100 h-100" src="../assets/imgs/section/section4.jpg" alt="Trang suc" /></a>
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
                        <div class="range row">
                            <div class="offset mb-4 mb-lg-0 mb-md-0 col-lg-3 col-md-3 col-6">
                                <a href="#" class="thumbnail-variant-1">
                                    <img class="img-responsive" style="object-fit:cover; object-position:center;" src="../assets/imgs/section/lsprd1.jpg" alt="">
                                    <div class="caption">
                                        <h2 class="caption-title">Trâm cài</h2>
                                        <p class="caption-descr">4 sản phẩm</p>
                                    </div>
                                </a>
                            </div>
                            <div class="offset mb-4 mb-lg-0 mb-md-0 col-lg-3 col-md-3 col-6">
                                <a href="#" class="thumbnail-variant-1">
                                    <img class="img-responsive" style="object-fit:cover; object-position:center;" src="../assets/imgs/section/lsprd2.jpg" alt="">
                                    <div class="caption">
                                        <h2 class="caption-title">Nhẫn</h2>
                                        <p class="caption-descr">4 sản phẩm</p>
                                    </div>
                                </a>
                            </div>
                            <div class="offset mb-4 mb-lg-0 mb-md-0 col-lg-3 col-md-3 col-6">
                                <a href="#" class="thumbnail-variant-1">
                                    <img class="img-responsive" style="object-fit:cover; object-position:center;" src="../assets/imgs/section/lsprd3.jpg" alt="">
                                    <div class="caption">
                                        <h2 class="caption-title">Bông tai</h2>
                                        <p class="caption-descr">4 sản phẩm</p>
                                    </div>
                                </a>
                            </div>
                            <div class="offset mb-4 mb-lg-0 mb-md-0 col-lg-3 col-md-3 col-6">
                                <a href="#" class="thumbnail-variant-1">
                                    <img class="img-responsive" style="object-fit:cover; object-position:center;" src="../assets/imgs/section/lsprd4.jpg" alt="">
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
                    <div class="shell position-relative">
                        <h3>
                            <a href="">HOT DEAL</a>
                        </h3>

                        <hr class="divider divider-base divider-bold">

                        <div class="hot-deal-prd row flex-nowrap">
                            <!-- <div class="product">
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
                            </div> -->
                        </div>

                        <!-- Next and Previous buttons -->
                        <button type="button" title="next" class="position-absolute btn btn-primary rounded-circle next" style="top:180px; right:-24px; background-color:#7fcbc9;">
                            <i class="fa-solid fa-caret-right text-center m-0" style="font-size: 20px; vertical-align:middle"></i>
                        </button>
                        <button type="button" title="previous" class="position-absolute btn btn-primary rounded-circle prev" style="top:180px; left:-24px; background-color:#7fcbc9;">
                            <i class="fa-solid fa-caret-left text-center m-0" style="font-size: 20px; vertical-align:middle"></i>
                        </button>
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
                                <!-- New -->
                                <div class="cell-product new-products">
                                    <h5><a href="#">Mới nhất</a></h5>
                                    <hr class="divider divider-base divider-bold divider-left">
                                    <div class="range-product">
                                        <!-- <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-inline-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Nhẫn</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Nhẫn vòng ADV</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn Bạc ME Đính Đá Tráng Men Trắng.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Bông tai</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Bông tai cao cấp Biz</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Nhẫn</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Nhẫn vòng ADV</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="cell-product outstanding-products">
                                    <h5><a href="#">Nổi bật</a></h5>
                                    <hr class="divider divider-base divider-bold divider-left">
                                    <div class="range-product">
                                        <!-- <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Nhẫn</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Nhẫn vòng ADV</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Nhẫn</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Nhẫn vòng ADV</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Nhẫn</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Nhẫn vòng ADV</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                                <div class="cell-product bestsellers">
                                    <h5><a href="#">Bán chạy</a></h5>
                                    <hr class="divider divider-base divider-bold divider-left">
                                    <div class="range-product">
                                        <!-- <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Nhẫn</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Nhẫn vòng ADV</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Nhẫn</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Nhẫn vòng ADV</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="cell-product">
                                            <div class="unit">
                                                <div class="unit-left d-inline-block">
                                                    <a href=""><img style="width:100px; height:100px;" src="../assets/imgs/Nhẫn vòng ADV.png" alt=""></a>
                                                </div>
                                                <div class="unit-body text-start me-auto d-flex flex-column justify-content-center align-items-start">
                                                    <div class="p"><a href="#">Nhẫn</a></div>
                                                    <div class="w-100"><a href="" class="text-base d-block">Nhẫn vòng ADV</a></div>
                                                    <div class="product-price" style="font-size:20px;">700.000₫</div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End product -->
            </div>
        </div>
    </main>

    <?php include_once('footer.php'); ?>
    <?php include_once("./cart.php"); ?>
</body>

</html>