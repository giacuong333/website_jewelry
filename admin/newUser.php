<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
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
    <?php include("../admin/common.php"); ?>

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
                                <td><input type="text" name="fullname" required /></td>
                            </tr>

                            <tr>
                                <td>Email</td>
                                <td><input type="email" name="email" required /></td>
                            </tr>
                            <tr>
                                <td>Phone number</td>
                                <td><input type="text" name="phonenumber" required /></td>
                            </tr>
                            <tr>
                                <td>Password</td>
                                <td><input type="password" name="password" required></td>
                            </tr>
                            <tr>
                                <td>Verify password</td>
                                <td><input type="password" name="verifypassword" required></td>
                            </tr>
                            <tr>
                                <td>Role</td>
                                <td>
                                    <select class="btn- btn--hover" name="roleid" id="">
                                        <option value="1">Admin</option>
                                        <option value="2">Nhân viên</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn- btn--hover" name="saveuser" value="saveuser" type="submit">Save</button>
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