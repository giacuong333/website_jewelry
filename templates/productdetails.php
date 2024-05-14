<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "web_trang_suc";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id = isset($_GET['data-productid']) ? $_GET['data-productid'] : "";
// Tạo truy vấn SQL
$sql = "SELECT * FROM `product` WHERE id = ?";
// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
// Lấy kết quả
$result = $stmt->get_result();
$productDetails = $result->fetch_assoc();
?>

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
    <!-- JQUERY -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- JS -->
    <script src="../js/cart.js"></script>
    <style>
        .product-info {
            margin-left: 100px;
        }

        .pro-price {
            font-size: 20px;
            font-weight: 400;
            color: #7fcbc9;
        }
    </style>
</head>

<body>
    <div class="page">
        <!--Start Header-->
        <?php include_once('header.php'); ?>
        <!-- End Header -->
        <!--Start bread-crumb -->
        <div class="main-bread-crumb">
            <?php
            // Giả sử bạn có một mảng chứa các phần của breadcrumb
            $breadcrumb_parts = [
                ['name' => 'Trang chủ', 'url' => 'trangchu.php'],
                ['name' => 'Sản phẩm', 'url' => 'SanPham.php'],
                ['name' => $productDetails['title'], 'url' => 'productdetails.php'],

            ];

            // Tạo một chuỗi HTML từ mảng này
            $breadcrumb_html = array_map(function ($part) {
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
            <div class="row productdetail-item" data-productquantity="<?php echo $row["quantity"]; ?>" data-productid="<?php echo $productDetails["id"]; ?>">
                <div class="col-md-6">
                    <div class="pro-image">
                        <img src="<?php echo $productDetails['thumbnail']; ?>" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-info">
                        <div class="border-item-bottom">
                            <h2 class="pro-name"><?php echo $productDetails['title']; ?></h2>
                            <div class="pro-price margin-bottom-20"> <?php echo $productDetails['price'] . "đ"; ?> </div>
                        </div>
                        <div class="pro-description border-item-bottom margin-bottom-20">
                            <p><?php echo $productDetails['description']; ?></p>
                        </div>
                        <div class="pro-quantity border-item-bottom ">
                            <div class="pro-action ms-0 margin-bottom-20">
                                <button class="btn btn-primary" type="button" name="add_product_to_cart"><i class="fa fa-shopping-cart"></i> Mua hàng</button>
                            </div>
                        </div>
                        <div class="top-left d-lg-flex d-md-flex d-none">
                            <label for="" class="share">Chia sẻ: </label>
                            <i class="fa-brands fa-facebook-f"></i>
                            <i class="fa-brands fa-pinterest"></i>
                            <i class="fa-brands fa-google"></i>
                            <i class="fa-brands fa-square-instagram"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="res-tab">
            <h2 class="mota border-item-bottom ">Mô tả sản phẩm</h2>
            <p><?php echo $productDetails['description']; ?></p>
            <img src="<?php echo $productDetails['thumbnail']; ?>" alt="">
        </div>
        <!-- Footer -->
        <?php include_once('footer.php'); ?>
        <!-- End Footer -->
    </div>

    <!-- Cart -->
    <?php include("./cart.php"); ?>

</body>

</html>