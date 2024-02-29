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

    <main class="main-privilege">
        <div class="overlay"></div>
        <form action="../includes/admin.inc.php" method="post" class="privilege-form">
            <!-- Add new -->
            <div class="dashboard-body">
                <div class="header">FUNCTIONAL INFORMATION</div>

                <table style="border: none;">
                    <thead>
                        <tr>
                            <th>FUNCTION NAME</th>
                            <th colspan="4">ACTION</th>
                        </tr>
                    </thead>
                    <tbody id="bodyprivilege">
                        <tr style="height: 40px; text-align: center;">
                            <td>Category</td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id="add-category"><label for="add-category">Add</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id="edit-category"><label for="edit-category">Edit</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id="delete-category"><label for="delete-category">Delete</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id="see-category"> <label for="see-category">See</label></td>
                        </tr>
                        <tr style="height: 40px; text-align: center;">
                            <td>Users</td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Add</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Edit</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Delete</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">See</label></td>
                        </tr>
                        <tr style="height: 40px; text-align: center;">
                            <td>Products</td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Add</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Edit</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Delete</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">See</label></td>
                        </tr>
                        <tr style="height: 40px; text-align: center;">
                            <td>Statistic</td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Add</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Edit</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Delete</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">See</label></td>
                        </tr>
                        <tr style="height: 40px; text-align: center;">
                            <td>Orders</td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Add</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Edit</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Delete</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">See</label></td>
                        </tr>
                        <tr style="height: 40px; text-align: center;">
                            <td>Permissions</td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Add</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Edit</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Delete</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">See</label></td>
                        </tr>
                        <tr style="height: 40px; text-align: center;">
                            <td>Roles</td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Add</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Edit</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">Delete</label></td>
                            <td><input style="display: inline-block;" type="checkbox" name="" id=""> <label for="">See</label></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn- btn--hover btn-save">Save</button>
                <button type="button" class="btn- btn--hover btn--exit">Exit</button>
            </div>
        </form>
    </main>

    <script src="../js/admin.js"></script>
</body>

</html>