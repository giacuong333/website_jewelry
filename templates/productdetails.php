<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/config.css">
    <link rel="stylesheet" href="../assets/css/sanpham.css">

    <!-- ICON -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">
    <!-- SCRIPT -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>
    <script src="../js/header.js"></script>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>

<body>
    <div class="page">
        <!--Start Header-->
        <?php include('header.php'); ?>
        <!-- End Header -->
        <!--Start bread-crumb -->
        <div class="main-bread-crumb">
            <?php
           // Giả sử bạn có một mảng chứa các phần của breadcrumb
           $breadcrumb_parts = [
            ['name' => 'Trang chủ', 'url' => 'trangchu.php'],
            ['name' => 'Sản phẩm', 'url' => 'SanPham.php'],
            ['name' => 'Chi Tiết Sản phẩm', 'url' => 'productdetails.php'],
            
        ];

        // Tạo một chuỗi HTML từ mảng này
        $breadcrumb_html = array_map(function($part) {
            // Kiểm tra xem URL của phần này có phải là URL của trang hiện tại không
            $is_current_page = (parse_url(str_replace('/website_jewelry/templates/', '', $_SERVER['REQUEST_URI']), PHP_URL_PATH) == $part['url']);
            
            // Nếu đúng, thêm lớp 'current' vào phần tử này
            $class = $is_current_page ? ' class="current"' : '';
        
            return '<a href="' . $part['url'] . '"' . $class . '>' . $part['name'] . '</a>';
        }, $breadcrumb_parts);
        
        // Chuyển mảng thành chuỗi, phân tách bởi ' > '
        $breadcrumb_html = implode(' > ', $breadcrumb_html);
        
        // Hiển thị breadcrumb
        echo '<div class="breadcrumb">' . $breadcrumb_html . '</div>';
        
            ?>
        </div>
        <!-- End bread-crumb -->
        <div class="container">
            <div class="col-xs-12">
                <div class="row">
                    <div class="col-xs-12 col-lg-12 details-product">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 relative product-image-block" >
                                <div class="large-image featured-image">
                                    <a href="">
                                        <img class="img-pro-details" src="../assets/imgs/Dây Chuyền Bạc  Mặt Trái Tim Nhiều Màu.png" alt="">
                                    </a> 
                                </div>

                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 details-pro">
                                <h1 class="title-head">Nhẫn vòng ADV</h1>
                                <div class="product-price">
                                    <span class="price">1.000.000đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <?php include('footer.php'); ?>
        <!-- End Footer -->
    </div>
</body>

</html>