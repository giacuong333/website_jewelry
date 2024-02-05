<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        <!-- Add new -->
        <form action="../includes/admin.inc.php" method="post" enctype="multipart/form-data">
            <div class="dashboard-body">
                <div class="header">PRODUCT INFORMATION</div>

                <div class="wrapper">
                    <table>
                        <tbody>
                            <?php include("../includes/admin.inc.php");
                            ?>
                            <tr>
                                <td>Image</td>
                                <td>
                                    <input type="text" name="productid" value="<?php echo $product["id"]; ?>" hidden>
                                    <input type="text" name="thumbnail" value="<?php echo $product["thumbnail"] ?>" hidden>
                                    <input type="file" name="imagepath" class="btn- btn--hover" id="productinputimg" accept="image/*">
                                </td>
                                <td rowspan="8">
                                    <img id="productimg" src="<?php echo $product["thumbnail"]; ?>" alt="Product Image" />
                                </td>
                            </tr>
                            <tr>
                                <td>Title</td>
                                <td><input type="text" value="<?php echo $product["title"]; ?>" required name="title" /></td>
                            </tr>
                            <tr>
                                <td>Category</td>
                                <td>
                                    <select class="btn- btn--hover" name="categoryid" id="">
                                        <option value="1" <?php echo $product["category_id"] == 1 ? "selected='selected'" : "" ?>>Nhẫn</option>
                                        <option value="2" <?php echo $product["category_id"] == 2 ? "selected='selected'" : ""; ?>>Vòng cổ</option>
                                        <option value="3" <?php echo $product["category_id"] == 3 ? "selected='selected'" : ""; ?>>Trâm cài</option>
                                        <option value="4" <?php echo $product["category_id"] == 4 ? "selected='selected'" : ""; ?>>Bông tai</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Price</td>
                                <td>
                                    <input type="text" value="<?php echo $product['price']; ?>" required name="price" />
                                </td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>
                                    <input type="text" name="discount" value="<?php echo $product["discount"]; ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>
                                    <textarea name="description" id="description" cols=" 64" rows="1"><?php echo $product['description']; ?></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>
                                    <label for="show">
                                        <input name="show" id="show" <?php echo $product['isShow'] == 1 ? "checked" : ""; ?> type="checkbox" />Show
                                    </label>
                                    <label for="outstanding">
                                        <input name="outstanding" <?php echo $product['isOutstanding'] == 1 ? "checked" : ""; ?> id="outstanding" type="checkbox" />Outstanding
                                    </label>
                                    <label for="new">
                                        <input name="new" id="new" <?php echo $product['isNew'] == 1 ? "checked" : ""; ?> type="checkbox" />New
                                    </label>
                                </td>
                            </tr>
                            <tr>
                                <td>Action</td>
                                <td>
                                    <button class="btn- btn--hover" name="updateproduct" value="updateproduct" id="updateproduct" type="submit">Save</button>
                                    <button class="btn- btn--hover" id="exitproduct" type="button">Exit</button>
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