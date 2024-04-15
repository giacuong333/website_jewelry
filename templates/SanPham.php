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

// Rest of your code...
$sqli = "SELECT * FROM product LIMIT 9";
$query = mysqli_query($conn, $sqli);



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
        <div class="bread-crumb">
            <div class="main-bread-crumb">
                <ul>
                    <li><a href="trangchu.php">Trang chủ</a></li>
                    <li><a href="SanPham.php">Sản phẩm</a></li>
                </ul>
            </div>
        </div>
        <!-- End bread-crumb -->
        <div class="container">
            <div class="main-container">
                <div class="sort-product"></div>
                <div class="product-view">
                    <div class="row">
                        <?php     
                          while($row = mysqli_fetch_array($query)){
                          
                        ?>
                        
                        <div class="product-item">
                            <div class="product">
                                <div class="product-img">
                                    <a href="#">
                                        <img class="img-prd" src="<?php echo $row['thumbnail']?>" alt="anh san pham ">
                                    </a>
                                </div>
                                <div class="product-name">
                                    <p class="big"><a href="#"><?php echo $row['title']?>
                                        </a></p>
                                </div>
                                <div class="product-price">
                                <?php echo $row['price']?>
                                </div>
                            </div>
                        </div> 
                        <?php
                          }
                        ?>
                    </div>
                    <div class="text-xs-left"></div>
                </div>
            </div>
            <aside class="side-bar">
                <aside class="aside-item">
                    <aside class="title">
                        <h2 class="title-head margin-top-0"><span>Danh mục</span></h2>
                    </aside>
                    <aside class="content"></aside>
                </aside>
                <aside class="filter"></aside>
        </div>
    </div>
    <!-- Footer -->
    <?php include('footer.php'); ?>
    <!-- End Footer -->
    </div>
</body>

</html>