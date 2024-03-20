<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>New input invoice</title>
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
                        <div class="header">INPUT INVOICE INFORMATION</div>

                        <div class="wrapper">
                              <table>
                                    <tbody>
                                          <tr>
                                                <td>Product</td>
                                                <td>
                                                      <select name="product_selected" id="product_selected" class="btn- btn--hover" style="width: 80%;">
                                                            <?php
                                                            foreach ($products as $product) {
                                                                  echo '<option name="' . $product["title"] . '" value="' . $product["id"] . '" title="' . $product["title"] . '">' . $product["title"] . '</option>';
                                                            }
                                                            ?>
                                                      </select>
                                                </td>
                                          </tr>

                                          <tr>
                                                <td>Quantity</td>
                                                <td><input type="text" name="product_amount" /></td>
                                          </tr>

                                          <tr>
                                                <td>Price</td>
                                                <td><input type="text" name="product_price" /></td>
                                          </tr>

                                          <tr>
                                                <td></td>
                                                <td>
                                                      <button class="btn- btn--hover" name="addproduct" value="addproduct" type="submit">Add</button>
                                                      <button class="btn- btn--hover saveproducttempo" type="button">Save</button>
                                                      <button class="btn- btn--hover" id="exitimportinvoice" type="button" name="exitnewimport" value="exitnewimport">Exit</button>
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