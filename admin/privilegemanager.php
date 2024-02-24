<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage privilege</title>
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
        <form action="../includes/admin.inc.php" method="post">
            <!-- Add new -->
            <div class="dashboard-body">
                <div class="header">FUNCTIONAL INFORMATION</div>

                <div class="dashboard-body">
                    <table>
                        <thead>
                            <tr>
                                <th>FUNCTION NAME</th>
                                <th colspan="4">ACTION</th>
                            </tr>
                        </thead>
                        <tbody id="bodyprivilege">
                            <tr style="height: 40px; text-align: center;">
                                <td>Category</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Add</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Edit</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Delete</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> See</td>
                            </tr>
                            <tr style="height: 40px; text-align: center;">
                                <td>Users</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Add</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Edit</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Delete</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> See</td>
                            </tr>
                            <tr style="height: 40px; text-align: center;">
                                <td>Products</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Add</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Edit</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Delete</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> See</td>
                            </tr>
                            <tr style="height: 40px; text-align: center;">
                                <td>Statistic</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Add</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Edit</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Delete</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> See</td>
                            </tr>
                            <tr style="height: 40px; text-align: center;">
                                <td>Orders</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Add</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Edit</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Delete</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> See</td>
                            </tr>
                            <tr style="height: 40px; text-align: center;">
                                <td>Permissions</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Add</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Edit</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Delete</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> See</td>
                            </tr>
                            <tr style="height: 40px; text-align: center;">
                                <td>Roles</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Add</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Edit</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> Delete</td>
                                <td><input style="display: inline-block;" type="checkbox" name="" id=""> See</td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn- btn--hover btn-save">Save</button>
                </div>
            </div>
        </form>
    </main>

    <script src="../js/admin.js"></script>
</body>

</html>