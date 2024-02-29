<!-- Style -->
<link rel="stylesheet" href="../assets/css/admin.css" />
<!-- Icon -->
<link rel="stylesheet" href="../assets/icons/css/all.min.css">
<!-- JQuery -->
<script src="../assets/libs/jquery-3.7.1.min.js"></script>
<!-- Js -->
<script src="../js/admin.js"></script>
<script src="../js/login.js"></script>
<!-- <script src="../js/logout.js"></script> -->

<!-- Navbar -->
<nav class="navbar">
    <h4>Dashboard</h4>
    <a href="../index.php" style="text-decoration: none; cursor: pointer;">
        <img src="../assets/imgs/brand/logo.png" alt="">
    </a>
    <div class="profile">
        <?php session_start(); ?>
        <p class="profile-name" style="font-size: 18px; font-weight: 500;"><?php echo isset($_SESSION["id"]) ? $_SESSION["fullname"] : "Đăng nhập"; ?></p>
    </div>
</nav>

<!-- Sidebar -->
<input type="checkbox" name="toggle" id="toggle" />
<label for="toggle" class="side-toggle">
    <span class="fas fa-bars"></span>
</label>

<div class="sidebar">
    <div class="sidebar-menu">
        <span class="fa-solid fa-list"> </span>
        <p>Category</p>
    </div>

    <div class="sidebar-menu">
        <span class="fas fa-users"> </span>
        <p>Users</p>
    </div>

    <div class="sidebar-menu">
        <span class="fa-brands fa-product-hunt"> </span>
        <p>Products</p>
    </div>

    <div class="sidebar-menu">
        <span class="fas fa-chart-line"> </span>
        <p>Statistic</p>
    </div>

    <div class="sidebar-menu">
        <span class="fas fa-id-card"> </span>
        <p>Contact</p>
    </div>

    <div class="sidebar-menu">
        <span class="fa-solid fa-sort"> </span>
        <p>Orders</p>
    </div>

    <div class="sidebar-menu">
        <span class="fa-solid fa-user-secret"></span>
        <p>Roles</p>
    </div>

    <div class="sidebar-menu">
        <span class="fa-solid fa-circle-info"></span>
        <p>Other</p>
    </div>

    <div class="sidebar-menu">
        <span class="fa-solid fa-power-off"> </span>
        <p>Log out</p>
    </div>
</div>