<link rel="stylesheet" href="../assets/icons/css/all.min.css">
<link rel="stylesheet" href="../assets/css/config.css">

<header class="main-header">
    <div class="common-header">
        <div class="top-left">
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
        </div>
    </div>
    <div class="bottom">
        <ul class="list-items">
            <li class="item">TRANG CHỦ</li>
            <li class="item">SẢN PHẨM
                <label for="openchildmenu" class="fa-solid fa-angle-down"></label>
                <input type="checkbox" name="" id="openchildmenu" style="display: none;">
                <ul class="child-list-items">
                    <li class="child-item">Nhẫn</li>
                    <li class="child-item">Bông tai</li>
                    <li class="child-item">Dây chuyền</li>
                    <li class="child-item">Trâm cài</li>
                </ul>
            </li>
            <li class="item">GIỚI THIỆU</li>
            <li class="item">PHẢN HỒI</li>
        </ul>
    </div>
</header>