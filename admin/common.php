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
        <?php include("../includes/admin.inc.php"); ?>
        <p class="profile-name" style="font-size: 18px; font-weight: 500;"><?php echo isset($_SESSION["id"]) ? $_SESSION["fullname"] : "Đăng nhập"; ?></p>
    </div>
</nav>

<!-- Sidebar -->
<input type="checkbox" name="toggle" id="toggle" />
<label for="toggle" class="side-toggle">
    <span class="fas fa-bars"></span>
</label>

<?php
$menuItemList = array(
    "Categories" => '
        <a href="../admin/categorymanager.php" class="sidebar-menu">
            <span class="fa-solid fa-list"></span>
            <p>Categories</p>
        </a>',
    "Users" => '
        <a href="../admin/usermanager.php" class="sidebar-menu">
            <span class="fas fa-users"></span>
            <p>Users</p>
        </a>
    ',
    "Products" => '
        <a href="../admin/productmanager.php" class="sidebar-menu">
            <span class="fa-brands fa-product-hunt"></span>
            <p>Products</p>
        </a>
    ',
    "Statistics" => '
        <a href="../admin/statisticmanager.php" class="sidebar-menu">
            <span class="fas fa-chart-line"></span>
            <p>Statistics</p>
        </a>
    ',
    "Contacts" => '
        <a href="../admin/contactmanager.php" class="sidebar-menu">
            <span class="fas fa-id-card"></span>
            <p>Contacts</p>
        </a>
    ',
    "Orders" => '
        <a href="../admin/ordermanager.php" class="sidebar-menu">
            <span class="fa-solid fa-sort"></span>
            <p>Orders</p>
        </a>
    ',
    "Roles" => '    
        <a href="../admin/rolemanager.php" class="sidebar-menu">
            <span class="fa-solid fa-user-secret"></span>
            <p>Roles</p>
        </a>
    '
);
?>

<div class="sidebar">
    <?php
    if (isset($_SESSION["role_id"])) {
        $role_id = $_SESSION["role_id"];
        $menuItemKeyList = array_keys($menuItemList);
        $descriptionList = $admin->getMenuItems($role_id);

        foreach ($menuItemKeyList as $menuItemKey) {
            $isContained = false;

            foreach ($descriptionList as $description => $elements) {
                foreach ($elements as $element) {
                    if (str_contains($element, strtolower($menuItemKey))) {
                        echo $menuItemList[$menuItemKey];
                        $isContained = true;
                        break;
                    }
                }

                if ($isContained) {
                    break;
                }
            }
        }

        echo '
            <a href="../admin/othermanager.php" class="sidebar-menu">
                <span class="fa-solid fa-circle-info"></span>
                <p>Other</p>
            </a>

            <a href="../includes/logout.inc.php" class="sidebar-menu">
                <span class="fa-solid fa-power-off"></span>
                <p>Log out</p>
            </a>
        ';
    }
    ?>
</div>