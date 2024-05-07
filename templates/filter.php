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
    }
    
}






// Close connection
mysqli_close($conn);
?>