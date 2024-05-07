<!-- Fontawesome -->
<link rel="stylesheet" href="../assets/icons/css/all.min.css">

<!-- CDN Boostrap Css -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

<!-- CDN Boostrap Js  -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script> -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

<!-- Js -->
<script src="../js/header.js"></script>

<div class="container-fluid">
    <div class="row">
        <header class="main-header">
            <div class="common-header py-md-4 py-0 justify-content-md-around justify-content-lg-around justify-content-between">
                <div class="top-left d-lg-flex d-md-flex d-none">
                    <i class="fa-brands fa-facebook-f"></i>
                    <i class="fa-brands fa-pinterest"></i>
                    <i class="fa-brands fa-google"></i>
                    <i class="fa-brands fa-square-instagram"></i>
                </div>
                <div class="top-middle">
                    <img src="../assets/imgs/brand/logo.png" alt="">
                </div>
                <div class="top-right">
                    <label for="userpanel" class="fa-solid fa-user"></label>
                    <input type="checkbox" name="" id="userpanel" style="display: none;">
                    <div class="login-options">
                        <?php
                        session_start();
                        if (isset($_SESSION["id"])) {
                            echo "
                    <a href='../includes/logout.inc.php'>
                        <i class='fa-solid fa-power-off'> </i>
                        <span>Đăng xuất</span>
                    </a>";
                        } else {
                            echo "
                    <a href='../templates/login.php'>
                        <i class='fa-solid fa-user-plus'></i>
                        <span> Đăng nhập</span>
                    </a>
                    <a href='../templates/signup.php'>
                        <i class='fa-solid fa-right-from-bracket'></i>
                        <span> Đăng ký</span>
                    </a>";
                        }
                        ?>
                    </div>
                    <i class="fa-solid fa-cart-shopping">
                        <span class="quantity">1</span>
                    </i>

                    <!-- Used for < medium screen -->
                    <button type="button" class="btn d-md-none d-lg-none d-flex text-dark text-end fs-4" data-bs-toggle="collapse" data-bs-target="#collapse-parent" aria-expanded="false" aria-controls="collapse-parent">
                        <i class="fa-solid fa-bars ms-auto" style="color: #7fcbc9;"></i>
                    </button>
                </div>

            </div>

            <div class="bottom collapse d-lg-block d-md-block" id="collapse-parent">
                <ul class="list-items bg-white w-100 p-0 m-0 flex-md-row flex-lg-row flex-column align-items-start">
                    <li class="item ps-0">
                        <a href="../templates/trangchu.php" style="text-decoration: none;">TRANG CHỦ</a>
                    </li>
                    <li class="item ps-0 dropdown">
                        <a href="SanPham.php" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" id="openchildmenu" style="text-decoration: none;">SẢN PHẨM</a>
                        <ul class="child-list-items bg-white dropdown-menu py-0" aria-labelledby="openchildmenu">
                            <li class="child-item dropdown-item">Nhẫn</li>
                            <li class="child-item dropdown-item">Bông tai</li>
                            <li class="child-item dropdown-item">Dây chuyền</li>
                            <li class="child-item dropdown-item">Trâm cài</li>
                        </ul>
                    </li>
                    <li class="item ps-0">
                        <a href="../templates/gioithieu.php" style="text-decoration: none;">GIỚI THIỆU</a>
                    </li>
                    <li class="item ps-0">
                        <a href="../templates/phanhoi.php" style="text-decoration: none;">PHẢN HỒI</a>
                    </li>
                </ul>
            </div>
        </header>
    </div>
</div>