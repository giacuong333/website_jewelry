<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Category</title>
    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <!-- Icon -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">
    <!-- JQuery -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>

</head>

<body>
    <?php include("../admin/common.php"); ?>

    <main>

        <div class="dashboard-header">
            <input type="text" placeholder="Search" name="searchcategoryinput" id="searchcategoryinput" />

            <select class="btn- btn--hover" name="searchcategoryvalue" id="searchcategoryvalue">
                <option value="id">Id</option>
                <option value="name">Name</option>
            </select>

            <button id="addcategory" class="btn- btn--hover" type="button">
                <span class="fa-solid fa-plus"></span>
                Add new
            </button>
        </div>

        <!-- Product -->
        <div class="dashboard-body">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="bodycategory">
                    <?php
                    include("../includes/admin.inc.php");

                    if (is_array($categories)) {
                        foreach ($categories as $category) {
                    ?>
                            <tr data-categoryid="<?php echo $category["id"]; ?>">
                                <td> <?php echo $category["categoryid"]; ?></td>
                                <td> <?php echo $category["name"]; ?></td>
                                <td>
                                    <span class="fa-solid fa-pen-to-square edit-categorybtn"></span>
                                    <span class="fa-solid fa-trash del-categorybtn" name="del-category" value="del-category"></span>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>