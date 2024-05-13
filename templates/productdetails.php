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
$id = $_GET['data-productid'];
// Tạo truy vấn SQL
$sql = "SELECT * FROM product WHERE id = ?";
// Chuẩn bị và thực thi truy vấn
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
// Lấy kết quả
$result = $stmt->get_result();
$product = $result->fetch_assoc();
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
    <!-- SCRIPT -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>
    <script src="../js/header.js"></script>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
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
        <?php include('header.php'); ?>
        <!-- End Header -->
        <!--Start bread-crumb -->
        <div class="main-bread-crumb">
            <?php
            // Giả sử bạn có một mảng chứa các phần của breadcrumb
            $breadcrumb_parts = [
                ['name' => 'Trang chủ', 'url' => 'trangchu.php'],
                ['name' => 'Sản phẩm', 'url' => 'SanPham.php'],
                ['name' => $product['title'], 'url' => 'productdetails.php'],

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
            <div class="row">
                <div class="col-md-6">
                    <div class="pro-image">
                        <img src="<?php echo $product['thumbnail']; ?>" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="product-info">
                        <div class="border-item-bottom">
                            <h2 class="pro-name"><?php echo $product['title']; ?></h2>
                            <div class="pro-price margin-bottom-20"> <?php echo $product['price'] . "đ"; ?> </div>
                        </div>
                        <div class="pro-description border-item-bottom margin-bottom-20">
                            <p><?php echo $product['description']; ?></p>
                        </div>
                        <div class="pro-quantity border-item-bottom ">
                            <button class="margin-bottom-20" onclick="handelMinus()"><i class="fa-solid fa-minus"></i></button>
                            <input type="number" size="4" name="quantity" data-zeros="true" value="1" min="1" max="10" class="form-control form-control-impressed stepper-input margin-bottom-20" id="amount">
                            <button class="margin-bottom-20" onclick=" handelPlus()"><i class="fa-solid fa-plus"></i></button>
                            <div class="pro-action margin-bottom-20">
                                <button class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Mua hàng</button>
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
            <p><?php echo $product['description']; ?></p>
            <img src="<?php echo $product['thumbnail']; ?>" alt="">
        </div>

        <script>
            let amountElement = document.getElementById('amount');
            let amount = amountElement.value;
            //Handel Plus
            let handelPlus = () => {
                amount++;
                amountElement.value = amount;
            }
            let handelMinus = () => {
                if (amount > 1) {
                    amount--;
                    amountElement.value = amount;
                }
            }
        </script>
        <!-- Footer -->
        <?php include('footer.php'); ?>
        <!-- End Footer -->
    </div>
</body>

</html>