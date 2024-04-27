<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New user</title>
    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <!-- Icon -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">
    <!-- JQuery -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>

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
                                    <input type="text" name="fullname" />
                                    <div class="error-message"></div>
                                </td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td>
                                    <input type="email" name="email" />
                                    <div class="error-message"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Phone number</td>
                                <td>
                                    <input type="text" name="phonenumber" />
                                    <div class="error-message"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td>
                                    <input type="password" name="password" />
                                    <div class="error-message"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Verify password</td>
                                <td>
                                    <input type="password" name="verifypassword" />
                                    <div class="error-message"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td>
                                    <select class="btn- btn--hover" name="roleid" id="">
                                        <?php
                                        foreach ($roles as $role) {
                                            echo "<option value='{$role['id']}'>{$role['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn- btn--hover" name="saveuser" value="saveuser" type="button">Save</button>
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