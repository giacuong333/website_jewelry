<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Roles</title>
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
            <input type="text" placeholder="Search" name="searchroleinput" id="searchroleinput" />

            <select class="btn- btn--hover" name="searchrolevalue" id="searchrolevalue">
                <option value="id">Id</option>
                <option value="name">Name</option>
            </select>

            <button id="addrole" class="btn- btn--hover" type="button">
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

                <tbody id="bodyrole">
                    <?php
                    include("../includes/admin.inc.php");

                    if (is_array($roles)) {
                        foreach ($roles as $role) {
                    ?>
                            <tr data-roleid="<?php echo $role["id"]; ?>">
                                <td> <?php echo $role["id"]; ?></td>
                                <td> <?php echo $role["name"]; ?></td>
                                <td>
                                    <span class="fa-solid fa-pen-to-square edit-rolebtn"></span>
                                    <span class="fa-solid fa-trash del-rolebtn" name="del-role" value="del-role"></span>
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