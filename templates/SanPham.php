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

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Start with a base SQL query
$sql = "SELECT * FROM product WHERE 1=1";
$params = []; // Array to hold bound parameters
$types = ''; // String to hold parameter types


// Filter based on price range
if (isset($_GET["filter-product"], $_GET["input-min"], $_GET["input-max"])) {
    $fromPrice = $_GET["input-min"];
    $toPrice = $_GET["input-max"];
    $sql .= " AND price BETWEEN ? AND ?";
    $types .= 'dd'; // 'd' represents a double (decimal) parameter type
    array_push($params, $fromPrice, $toPrice);
}

// Filter based on search query
if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $sql .= " AND title LIKE ?";
    $types .= 's'; // 's' represents a string parameter type
    $params[] = $search;
}

// Filter based on category
if (isset($_GET["category_id"])) {
    $category_id = $_GET["category_id"];
    $sql .= " AND category_id = ?";
    $types .= 'i'; // 'i' represents an integer parameter type
    $params[] = $category_id;
}

// Sorting
if (isset($_GET["sort"])) {
    switch ($_GET["sort"]) {
        case 'price-asc':
            $sql .= ' ORDER BY price ASC';
            break;
        case 'price-desc':
            $sql .= ' ORDER BY price DESC';
            break;
        case 'name-asc':
            $sql .= ' ORDER BY title ASC';
            break;
        case 'name-desc':
            $sql .= ' ORDER BY title DESC';
            break;
    }
}

// Prepare the statement for pagination calculation
$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$number_of_results = $result->num_rows;

// Calculate number of pages
$number_of_pages = ceil($number_of_results / $results_per_page);

// Calculate the offset for the current page
$this_page_first_result = ($current_page - 1) * $results_per_page;

// Add LIMIT clause to the SQL query
$sql .= " LIMIT ?, ?";
$types .= 'ii';
array_push($params, $this_page_first_result, $results_per_page);

// Prepare the final statement with LIMIT
$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$query = $stmt->get_result();

// Giả sử $filters đã được khởi tạo trước đó

$filters = isset($filters) ? $filters : [];
unset($filters['page']);
// Lấy tất cả tham số từ URL
$paramsFromUrl = $_GET;

// Duyệt qua từng tham số trong URL
foreach ($paramsFromUrl as $key => $value) {
    // Chỉ thêm tham số vào $filters nếu nó chưa tồn tại
    if (!array_key_exists($key, $filters)) {
        $filters[$key] = $value;
    }
    // Nếu bạn muốn cập nhật giá trị cho khóa đã tồn tại với giá trị mới từ URL, bạn có thể bỏ qua điều kiện if hoặc xử lý cụ thể tại đây
}

// Bây giờ $filters sẽ chứa tất cả các tham số lọc hiện tại cùng với bất kỳ tham số mới nào từ URL mà không cập nhật lại các giá trị hiện có

// Loại bỏ tham số 'page'
print_r($filters);
$filter_query = http_build_query($filters); // Tạo chuỗi truy vấn từ các tham số lọc
// Display pagination links
for ($page = 1; $page <= $number_of_pages; $page++) {
    // Tạo liên kết với các tham số lọc và tham số 'page'
    $link = "SanPham.php?" . $filter_query . (!empty($filter_query) ? "&" : "") . "page=" . $page;
    echo '<a href="' . $link . '">' . $page . '</a> ';
}

$sql = "SELECT * FROM category";
$result = $conn->query($sql);

// Close the statement
$stmt->close();
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
    <!-- JQUERY -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- JS -->
    <script src="../js/cart.js"></script>
</head>

<body>
    <div class="page">
        <!--Start Header-->
        <?php include_once('./header.php'); ?>
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
            <div class="main-container">
                <div class="row">
                    <div id="sort-by ">

                        <form action="SanPham.php" method="get">
                            <div class="sort-product mb-4">
                                <label for="sort" class="form-label"></label>
                                <select class="form-select" id="sort" name="sort" onchange="this.form.submit()">
                                    <option value="default" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'default') echo 'selected'; ?>>
                                        Mặc định</option>
                                    <option value="price-asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price-asc') echo 'selected'; ?>>
                                        Giá: Thấp đến Cao</option>
                                    <option value="price-desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'price-desc') echo 'selected'; ?>>
                                        Giá: Cao đến Thấp</option>
                                    <option value="name-asc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'name-asc') echo 'selected'; ?>>
                                        Tên: A-Z</option>
                                    <option value="name-desc" <?php if (isset($_GET['sort']) && $_GET['sort'] == 'name-desc') echo 'selected'; ?>>
                                        Tên: Z-A</option>
                                </select>
                            </div>
                        </form>


                        <div class="title-prod mb-4">
                            <span>
                                <!-- 
                                    Vidu: page-1 -> 0 + 1 = 1, 9 + 0 = 9, min(9, 15) => 1-9
                                          page-2 -> 9 + 1 = 10, 9 + 9 = 18, min(18, 15) => 10-15 
                                 -->
                                Hiển thị
                                <?php echo $this_page_first_result + 1 . ' - ' . min($results_per_page + $this_page_first_result, $number_of_results); ?>
                                trong tổng số <?php echo $number_of_results ?> sản phẩm
                            </span>
                        </div>
                        <div class="search-pro">
                            <form action="SanPham.php" method="get">
                                <div class="input-group mb-5 width-50">
                                    <input type="text" class="form-control  " placeholder="Tìm kiếm sản phẩm" name="search" onchange="this.form.submit()">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

                <div class="product-view">
                    <div class="row">
                        <?php
                        while ($row = mysqli_fetch_array($query)) {

                        ?>

                            <div class="product-item" data-productid="<?php echo $row["id"] ?>">
                                <div class="product">
                                    <div class="product-img">
                                        <a href="#">
                                            <img class="img-prd" src="<?php echo $row['thumbnail'] ?>" alt="anh san pham ">
                                        </a>
                                        <div class="cart-icon " data-quantity="<?php echo $row['quantity']; ?>" style="<?php if ($row['quantity'] <= 0) {
                                                                                                                            echo 'display: block;   pointer-events: none; opacity: 0.5;';
                                                                                                                        }  ?>">
                                            <?php if ($row['quantity'] <= 0) { ?>
                                                <span class="out-of-stock">Hết Hàng</span>
                                                <style>
                                                    .out-of-stock {
                                                        position: absolute;
                                                        top: 50%;
                                                        left: 50%;
                                                        transform: translate(-50%, -50%);
                                                        font-size: medium;
                                                        color: #fff;
                                                        padding: 5px 10px;
                                                        border-radius: 5px;
                                                    }
                                                </style>
                                            <?php } else { ?>
                                                <i class="fa fa-shopping-cart cart-icon-btn"></i>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="product-name">
                                        <p class="big"><a href="productdetails.php?data-productid=<?php echo $row["id"]; ?>"><?php echo $row['title'] ?>
                                            </a></p>
                                    </div>
                                    <div class="product-price">
                                        <?php echo $row['price'] . "đ" ?>
                                    </div>
                                </div>
<<<<<<< HEAD
=======
                                <div class="product-name">
                                    <p class="big"><a
                                            href="productdetails.php?data-productid=<?php echo $row["id"]; ?>"><?php echo $row['title'] ?>
                                        </a></p>
                                </div>
                                <div class="product-price">
                                    <?php
    $discountPercent = isset($row['discount']) ? $row['discount'] : 0; 
    $originalPrice = $row['price'] / (1 - $discountPercent / 100);
    $finalPrice = $row['price'];

    if ($discountPercent > 0) {
        
        
        echo "<div style='color: #7fcbc9; font-size:large;'>" . number_format($finalPrice) . "đ</div>";
        echo "<div style='text-decoration: line-through; margin-left:5px; color:gray; font-size:small;' >" . number_format($originalPrice) . "đ</div>";
        
    } else {
        // Nếu không có giảm giá, chỉ hiển thị giá gốc
        echo number_format($originalPrice) . "đ";
    }
    ?>
                                </div>
>>>>>>> c075ab7470ef9d33dbac31d73484750d0cf30f99
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <script>

                    </script>
                    <!-- pagination  -->
                    <?php
                    if (!isset($_GET["input-min"]) && !isset($_GET["input-max"])) {
                    ?>

                        <?php
                        echo '<nav aria-label="Page navigation example">';
                        echo '<ul class="pagination">';
                        if ($current_page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="SanPham.php?' . $filter_query . (!empty($filter_query) ? "&" : "") . 'page=' . ($current_page - 1) . '">Previous</a></li>';
                        }
                        for ($pages = 1; $pages <= $number_of_pages; $pages++) {
                            if ($pages == $current_page) {
                                echo '<li class="page-item active"><a class="page-link" href="SanPham.php?' . $filter_query . (!empty($filter_query) ? "&" : "") . 'page=' . $pages . '">' . $pages . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="SanPham.php?' . $filter_query . (!empty($filter_query) ? "&" : "") . 'page=' . $pages . '">' . $pages . '</a></li>';
                            }
                        }
                        if ($current_page < $number_of_pages) {
                            echo '<li class="page-item"><a class="page-link" href="SanPham.php?' . $filter_query . (!empty($filter_query) ? "&" : "") . 'page=' . ($current_page + 1) . '">Next</a></li>';
                        }
                        echo '</ul>';
                        echo '</nav>';
                    } else { ?>
                    <?php
                        echo '<nav aria-label="Page navigation example">';
                        echo '<ul class="pagination">';
                        if ($current_page > 1) {
                            echo '<li class="page-item  "><a class="page-link" href="SanPham.php?input-min=' . $_GET["input-min"] . '&input-max=' . $_GET['input-max'] . '&filter-product=filter-product&page=' . ($current_page - 1) . '">Previous</a></li>';
                        }
                        for ($pages = 1; $pages <= $number_of_pages; $pages++) {
                            if ($pages == $current_page) {
                                echo '<li class="page-item active"><a class="page-link" href="SanPham.php?input-min=' . $_GET["input-min"] . '&input-max=' . $_GET['input-max'] . '&filter-product=filter-product&page=' . $pages . '">' . $pages . '</a></li>';
                            } else {
                                echo '<li class="page-item"><a class="page-link" href="SanPham.php?input-min=' . $_GET["input-min"] . '&input-max=' . $_GET['input-max'] . '&filter-product=filter-product&page=' . $pages . '">' . $pages . '</a></li>';
                            }
                        }
                        if ($current_page < $number_of_pages) {
                            echo '<li class="page-item"><a class="page-link" href="SanPham.php?input-min=' . $_GET["input-min"] . '&input-max=' . $_GET['input-max'] . '&filter-product=filter-product&page=' . ($current_page + 1) . '">Next</a></li>';
                        }
                        echo '</ul>';
                        echo '</nav>';
                    } ?>

                    <!-- End pagination -->
                </div>
            </div>
            <aside class="side-bar">
                <aside class="aside-item">
                    <div class="aside-title">
                        <h2 class="title-head margin-top-0 "><span>Danh Mục</span></h2>
                    </div>
                    <div class="aside-content">
                        <nav class="nav-category">
                            <ul class=" nav-pills">
                                <li class="nav-item">
                                    <i class="fa fa-caret-right"></i>
                                    <a href="trangchu.php">Trang Chủ</a>
                                </li>
                                <li class="nav-item ">
                                    <i class="fa fa-caret-right"></i>
                                    <a href="SanPham.php">Sản Phẩm</a>
                                    <i class="fa fa-angle-down sub-btn"></i>
                                    <div class="sub-menu">
                                        <?php
                                        if ($result->num_rows > 0) {
                                            // Xuất dữ liệu của mỗi hàng
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<a class="sub-item" href="SanPham.php?category_id=' . $row["id"] . '"> <i class="fa fa-caret-right"></i>' . $row["name"] . '</a>';
                                            }
                                        } else {
                                            echo "Không có loại sản phẩm";
                                        }
                                        ?>
                                    </div>

                                </li>
                                <li class="nav-item">
                                    <i class="fa fa-caret-right"></i>
                                    <a href="trangchu.php">Giới Thiệu</a>
                                </li>
                                <li class="nav-item">
                                    <i class="fa fa-caret-right"></i>
                                    <a href="trangchu.php">Phản Hồi</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </aside>
                <form action="SanPham.php" method="get" class="aside-item filter-price">
                    <div class="aside-title">
                        <h2 class="title-head margin-top-0 "><span>Theo mức giá</span></h2>
                    </div>
                    <div class="aside-content filter-group">
                        <div class="price-input">
                            <div class="field">

                                <input type="number" class="input-min" value="<?php echo isset($_GET['input-min']) ? $_GET['input-min'] : "250000" ?>" name="input-min">
                            </div>
                            <div class="separator">-</div>
                            <div class="field">

                                <input type="number" class="input-max" value="<?php echo isset($_GET['input-max']) ? $_GET['input-max'] : '750000'; ?>" name="input-max">
                            </div>
                        </div>
                        <div class="slider">
                            <div class="progess"></div>
                        </div>
                        <div class="range-input">
                            <input type="range" class="range-min" min="0" max="1000000" value="250000" step="100">
                            <input type="range" class="range-max" min="0" max="1000000" value="750000" step="100">
                        </div>
                    </div>
                    <div class="btn-filter-price">
                        <button class="btn btn-primary" name="filter-product" value="filter-product" type="submit">Lọc</button>
                    </div>
                </form>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="../js/fillterprice.js"></script>
                <form action="SanPham.php" method="GET">
                    <aside class="aside-item filter-type">
                        <div class="aside-title">
                            <h2 class="title-head margin-top-0"><span>Theo Loại</span></h2>
                        </div>

                        <div class="aside-content filter-group">
                            <ul>
                                <?php
                                // Lấy giá trị category_id từ URL
                                $selectedCategoryId = isset($_GET['category_id']) ? $_GET['category_id'] : '';

                                if ($result = $conn->query($sql)) {
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            // Kiểm tra xem category_id hiện tại có trùng với giá trị từ URL không
                                            $isChecked = ($row["id"] == $selectedCategoryId) ? 'checked' : '';
                                            echo '<li class="filter-item"><span><label for="filter-' . strtolower(str_replace(' ', '-', $row["name"])) . '"><input type="radio" name="category_id" value="' . $row["id"] . '" ' . $isChecked . ' onchange="this.form.submit()"> ' . $row["name"] . '</label></span></li>';
                                        }
                                    } else {
                                        echo "Không có loại sản phẩm";
                                    }
                                } else {
                                    echo "Lỗi truy vấn: " . $conn->error;
                                }
                                ?>
                            </ul>
                        </div>

                        <?php $conn->close(); ?>
                    </aside>
                </form>
<<<<<<< HEAD
                <script>
                    // Select all checkboxes within the filter items
                    const checkboxes = document.querySelectorAll('.filter-item input[type="checkbox"]');

                    // Function to uncheck all other checkboxes except the one passed as parameter
                    function uncheckOthers(currentCheckbox) {
                        checkboxes.forEach((checkbox) => {
                            if (checkbox !== currentCheckbox) {
                                checkbox.checked = false;
                            }
                        });
                    }

                    // Add a change event listener to each checkbox
                    checkboxes.forEach((checkbox) => {
                        checkbox.addEventListener('change', function() {
                            if (this.checked) {
                                uncheckOthers(this);
                            }
                        });
                    });
                </script>
=======
>>>>>>> c075ab7470ef9d33dbac31d73484750d0cf30f99
            </aside>

        </div>
        <script>
            $(document).ready(function() {
                $('.sub-btn').click(function() {
                    $(this).next('.sub-menu').slideToggle();
                });
            });
        </script>
        <!-- Footer -->
        <?php include_once('./footer.php'); ?>
        <!-- End Footer -->
    </div>

    <?php
    // session_start();
    // unset($_SESSION["cart"]);
    ?>

    <!-- Minh Kha -->
    <div class="overlay d-none"></div>
    <div class="popupcart bg-white p-5 d-none">
        <div class="popuppanel">
            <div class="popuppanel__header mb-3">
                <i class="fa-solid fa-check" style="color: #7fcbc9; font-weight: 900; font-size: 20px"></i>
                <span id="popuppanel__header_title" style="font-weight: 900; font-size: 18px">Bạn đã thêm <span style="color: #7fcbc9;"></span> vào giỏ hàng</span>
            </div>
            <div class="popuppanel__subheader mb-2">
                <i class="fa-solid fa-cart-shopping" style="color: #7fcbc9; font-weight: 900; font-size: 20px"></i>
                <a href="./cart.php" id="popuppanel__subheader_cart"></a>
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
</body>

</html>