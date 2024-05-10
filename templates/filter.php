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

if(isset($_POST['min_price']) && isset($_POST['max_price'])){
    $min_price = $_POST['min_price'];
    $max_price = $_POST['max_price'];

    $sql = "SELECT * FROM product WHERE  isShow='1' AND price BETWEEN '$min_price' AND '$max_price' ";
    $query = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($query);
    if($count == 0){
        echo '<h2>No Product Found</h2>';
    }else{
        echo '<div class="product-view"><div class="row">';
        while ($row = mysqli_fetch_array($query)) {
            echo '
                <div class="product-item" data-productid="'.$row["id"].'">
                    <div class="product">
                        <div class="product-img">
                            <a href="#">
                                <img class="img-prd" src="'.$row['thumbnail'].'" alt="anh san pham ">
                            </a>
                            <div class="cart-icon">
                                <i class="fa fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="product-name">
                            <p class="big"><a href="productdetails.php?data-productid='.$row["id"].'">'.$row['title'].'</a></p>
                        </div>
                        <div class="product-price">
                            '.$row['price'].'đ
                        </div>
                    </div>
                </div>';
        }
        echo '</div></div>';
    }
    
}






// Close connection
mysqli_close($conn);
?>