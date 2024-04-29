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

$results_per_page = 9;
// Find out the number of results stored in database
$sql='SELECT * FROM product';
$result = mysqli_query($conn, $sql);
$number_of_results = mysqli_num_rows($result);

// Determine the total number of pages available
$number_of_pages = ceil($number_of_results/$results_per_page);

// Determine which page number visitor is currently on
if (isset($_GET['page'])) {
    $pages = intval($_GET['page']);
} else {
    $pages = 1;
}
$current_page = $pages;

// Determine the sql LIMIT starting number for the results on the displaying page
$this_page_first_result = ($pages-1)*$results_per_page;

// Retrieve selected results from database and display them on page
$sql='SELECT * FROM product LIMIT ' . $this_page_first_result . ',' .  $results_per_page;
$query = mysqli_query($conn, $sql);

// Display the links to the pages
for ($page=2;$page<=$number_of_pages;$page++) {
    echo '<a href="SanPham.php?page=' . $page . '">' . $page . '</a> ';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sản Phẩm</title>
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
        <?php include 'header.php'; ?>
        <script>
        handleScroll();
        </script>
        <!-- End Header -->
        <!--Start bread-crumb -->
        <div class="main-bread-crumb">
            <?php
        // Giả sử bạn có một mảng chứa các phần của breadcrumb
            $breadcrumb_parts = [
                ['name' => 'Trang chủ', 'url' => 'trangchu.php'],
                ['name' => 'Sản phẩm', 'url' => 'SanPham.php'],
                
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
            <div class="main-container">
                <div class="row">
                    <div id="sort-by ">

                        <div class="sort-product mb-4">
                            <label for="sort" class="form-label "></label>
                            <select class="form-select " id="sort" name="sort">
                                <option value="default">Mặc định</option>
                                <option value="price-asc">Giá: Thấp đến Cao</option>
                                <option value="price-desc">Giá: Cao đến Thấp</option>
                                <option value="name-asc">Tên: A-Z</option>
                                <option value="name-desc">Tên: Z-A</option>
                            </select>
                        </div>


                        <div class="title-prod mb-4">
                            <span>
                                Hiển thị 1 - 18 trong tổng số 22 sản phẩm</span>
                        </div>

                    </div>
                </div>

                <div class="product-view">
                    <div class="row">
                        <?php
                        while ($row = mysqli_fetch_array($query)) {

                        ?>

                        <div class="product-item">
                            <div class="product">
                                <div class="product-img">
                                    <a href="#">
                                        <img class="img-prd" src="<?php echo $row['thumbnail'] ?>" alt="anh san pham ">
                                    </a>
                                </div>
                                <div class="product-name">
                                    <p class="big"><a href="#"><?php echo $row['title'] ?>
                                        </a></p>
                                </div>
                                <div class="product-price">
                                    <?php echo $row['price'] . "đ" ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                    <!-- pagination  -->
                    <?php 
                   echo '<nav aria-label="Page navigation example">';
                   echo '<ul class="pagination">';
                   if ($current_page > 1 ) {
                       echo '<li class="page-item  "><a class="page-link" href="SanPham.php?page=' . ($pages - 1) . '">Previous</a></li>';
                   }
                   for ($pages = 1; $pages <= $number_of_pages; $pages++) {
                    if ($pages == $current_page) {
                        echo '<li class="page-item active"><a class="page-link" href="SanPham.php?page=' . $pages . '">' . $pages . '</a></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="SanPham.php?page=' . $pages . '">' . $pages . '</a></li>';
                    }
                }
                if ($current_page < $number_of_pages) {
                    echo '<li class="page-item"><a class="page-link" href="SanPham.php?page=' . ($current_page + 1) . '">Next</a></li>';
                }
                   echo '</ul>';
                   echo '</nav>';
                   
                   ?>
                    <!-- End pagination -->
                </div>
            </div>
            <aside class="side-bar">
                <aside class="aside-item">
                    <div class="aside-title">
                        <h2><span>Danh Mục</span></h2>
                    </div>
                </aside>
            </aside>
        </div>

        <!-- Footer -->
        <?php include('footer.php'); ?>
        <!-- End Footer -->
    </div>
</body>

</html>