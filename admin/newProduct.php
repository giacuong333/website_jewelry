<!DOCTYPE html>
<html lang="en">

<head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <title>Manage Product</title>
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
                    <!-- Add new -->
                    <form action="../includes/admin.inc.php" method="post">
                              <div class="dashboard-body">
                                        <div class="header">PRODUCT INFORMATION</div>

                                        <div class="wrapper">
                                                  <table>
                                                            <tbody>
                                                                      <tr>
                                                                                <td>Image</td>
                                                                                <td>
                                                                                          <button class="btn- btn--hover" type="button">Select image</button>
                                                                                          <p style="display: inline-block">No image selected</p>
                                                                                </td>
                                                                                <td rowspan="8">
                                                                                          <img src="../assets/imgs/img1.png" alt="" />
                                                                                </td>
                                                                      </tr>
                                                                      <tr>
                                                                                <td>Title</td>
                                                                                <td><input type="text" /></td>
                                                                      </tr>
                                                                      <tr>
                                                                                <td>Category</td>
                                                                                <td>
                                                                                          <select class="btn- btn--hover" name="" id="">
                                                                                                    <option value="1">Nhẫn</option>
                                                                                                    <option value="2">Vòng cổ</option>
                                                                                                    <option value="3">Trâm cài</option>
                                                                                                    <option value="4">Vòng tay</option>
                                                                                          </select>
                                                                                </td>
                                                                      </tr>
                                                                      <tr>
                                                                                <td>Price</td>
                                                                                <td><input type="text" /></td>
                                                                      </tr>
                                                                      <tr>
                                                                                <td>Discount</td>
                                                                                <td><input type="text" /></td>
                                                                      </tr>
                                                                      <tr>
                                                                                <td>Description</td>
                                                                                <td><textarea name="" id="" cols="64" rows="1"></textarea></td>
                                                                      </tr>
                                                                      <tr>
                                                                                <td>Action</td>
                                                                                <td>
                                                                                          <label for="show"><input id="show" type="checkbox" />Show</label>
                                                                                          <label for="outstanding"><input id="outstanding" type="checkbox" />Outstanding</label>
                                                                                          <label for="new"><input id="new" type="checkbox" />New</label>
                                                                                </td>
                                                                      </tr>
                                                                      <tr>
                                                                                <td></td>
                                                                                <td>
                                                                                          <button class="btn- btn--hover" type="button">Save</button>
                                                                                          <button class="btn- btn--hover" type="button">Exit</button>
                                                                                </td>
                                                                      </tr>
                                                            </tbody>
                                                  </table>
                                        </div>
                              </div>
                    </form>
          </main>

          <!-- <script src="../js/admin.js"></script> -->
</body>

</html>