<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <!-- Icon -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">
    <!-- JQuery -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>
    <!-- JS -->
    <script src="../js/admin.js"></script>

</head>

<body>
    <?php
    include_once("../admin/common.php");
    include_once("../includes/admin.inc.php");
    ?>

    <main>
        <form action="../includes/admin.inc.php" method="post">
            <!-- Add new -->
            <div class="dashboard-body">
                <div class="header">USER INFORMATION</div>

                <div class="wrapper">
                    <table>
                        <tbody>
                            <tr>
                                <td>Full name</td>
                                <td>
                                    <input type="text" name="user_id" value="<?php echo $user['id']; ?>" hidden />
                                    <input type="text" name="fullname" required value="<?php echo $user['fullname']; ?>" />
                                </td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td><input type="email" name="email" required value="<?php echo $user['email']; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Phone number</td>
                                <td><input type="text" name="phonenumber" required value="<?php echo $user['phone_number']; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td>
                                    <select class="btn- btn--hover" name="roleid" id="">
                                        <?php
                                        foreach ($roles as $role) {
                                            if ($_GET["role_id"] == $role['id']) {
                                                echo "<option value='{$role['id']}' selected>{$role['name']}</option>";
                                                continue;
                                            }
                                            echo "<option value='{$role['id']}'>{$role['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn- btn--hover" name="updateuser" value="updateuser" type="submit">Update</button>
                                    <button class="btn- btn--hover" id="exituser" name="exituser" value="exituser" type="button">Exit</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </main>

</body>

</html>