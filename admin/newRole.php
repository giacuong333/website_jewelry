<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New role</title>
    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/admin.css" />
    <!-- Icon -->
    <link rel="stylesheet" href="../assets/icons/css/all.min.css">
    <!-- JQuery -->
    <script src="../assets/libs/jquery-3.7.1.min.js"></script>

</head>

<body>
    <?php include_once("../admin/common.php"); ?>

    <main>
        <form action="../includes/admin.inc.php" method="post">
            <!-- Add new -->
            <div class="dashboard-body">
                <div class="header">ROLE INFORMATION</div>

                <div class="wrapper">
                    <table>
                        <tbody>
                            <tr>
                                <td>Name of role</td>
                                <td>
                                    <input type="text" name="rolename" />
                                    <div class="error-message"></div>
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td>
                                    <button class="btn- btn--hover" name="saverole" value="saverole" type="button">Save</button>
                                    <button class="btn- btn--hover" id="exitrole" name="exitrole" value="exitrole" type="button">Exit</button>
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