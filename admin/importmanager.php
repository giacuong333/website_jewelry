<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Manage Imports</title>
      <!-- Style -->
      <link rel="stylesheet" href="../assets/css/admin.css" />
      <!-- Icon -->
      <link rel="stylesheet" href="../assets/icons/css/all.min.css">
      <!-- JQuery -->
      <script src="../assets/libs/jquery-3.7.1.min.js"></script>
</head>

<body id="import-body">
      <?php
      include_once("../admin/common.php");
      include_once("../includes/admin.inc.php");
      ?>

      <!-- Import invoice details -->
      <!-- <div class="overlay"></div>
      <div class="import-invoice-container">
            <div class="import-invoice-container__header">
                  <img src="../assets/imgs/brand/logo.png"></img>
                  <h1 class="import-invoice-container__title">INVOICE</h1>
                  <p class="import-invoice-container__sub-title">Submission</p>
            </div>

            <div class="import-invoice-container__body">
                  <div class="import-invoice-container__body-top">
                        <p>Invoice to: <span>Wen trang sức</span></p>
                        <p>Employee name: <span>Lê Gia Cường</span></p>
                        <p><span>01/02/2024</span></p>
                  </div>

                  <div class="import-invoice-container__body-bottom">
                        <table style="border-collapse: collapse;">
                              <thead>
                                    <th style="text-align: left; padding-left: 16px;">Product name</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                              </thead>

                              <tbody>
                                    <tr style="line-height: 3;">
                                          <td style="padding-left: 16px;">Nhẫn vòng ADV Nhẫn vòng ADV Nhẫn vòng ADV Nhẫn vòng ADV</td>
                                          <td style="text-align:center;">10</td>
                                          <td style="text-align:center;">2000000</td>
                                    </tr>

                                    <tr style="line-height: 3;">
                                          <td style="padding-left: 16px;">Nhẫn vòng hột xoàng</td>
                                          <td style="text-align:center;">100</td>
                                          <td style="text-align:center;">3000000</td>
                                    </tr>

                                    <tr style="line-height: 3;">
                                          <td style="padding-left: 16px;">Nhẫn vòng hột xoàng</td>
                                          <td style="text-align:center;">100</td>
                                          <td style="text-align:center;">3000000</td>
                                    </tr>

                                    <tr style="line-height: 3;">
                                          <td style="padding-left: 16px;">Nhẫn vòng hột xoàng</td>
                                          <td style="text-align:center;">100</td>
                                          <td style="text-align:center;">3000000</td>
                                    </tr>

                                    <tr style="line-height: 3;">
                                          <td style="padding-left: 16px;">Nhẫn vòng hột xoàng</td>
                                          <td style="text-align:center;">100</td>
                                          <td style="text-align:center;">3000000</td>
                                    </tr>

                                    <tr style="line-height: 3; background-color: #1f7a77; color: #fff;">
                                          <td colspan="2" style="padding-left: 16px;">Total</td>
                                          <td style="text-align:center;">5000000</td>
                                    </tr>
                              </tbody>
                        </table>
                  </div>
            </div>

            <div class="import-invoice-container__footer">
                  <p class="import-invoice-container__footer-payment">Payment Information: <span>Credit cards</span></p>
                  <p class="import-invoice-container__footer-phonenumber">Phone number: <span>0948800917</span></p>
                  <p class="import-invoice-container__footer-address">Address: <span>Đại học Sài Gòn, Quận 5, tp Hồ Chí Minh</span></p>
            </div>
      </div> -->

      <main>
            <div class="dashboard-header">
                  <input type="text" placeholder="Search" name="searchimportinvoieinput" id="searchimportinvoieinput" />

                  <select class="btn- btn--hover" name="searchimportinvoievalue" id="searchimportinvoievalue">
                        <option value="id">Id</option>
                        <option value="employee-name">Employee name</option>
                        <option value="import-create-time">Create time</option>
                  </select>

                  <!-- Search for orders in a range date -->
                  <input type="datetime-local" placeholder="From date" name="searchfromdateinput" id="searchfromdateinput" />
                  <input type="datetime-local" placeholder="To date" name="searchtodateinput" id="searchtodateinput" />
                  <button type="button" class="btn- btn--hover btn-searchbydate">Search by date</button>

                  <button type="button" class="btn- btn--hover btn-addinputinvoice">
                        <span class="fa-solid fa-plus "></span>
                        Add new
                  </button>
            </div>

            <!-- Product -->
            <div class="dashboard-body">
                  <table>
                        <thead>
                              <tr>
                                    <th>ID</th>
                                    <th>Employee name</th>
                                    <th>Create time</th>
                                    <th>Total invoice</th>
                                    <th>Action</th>
                              </tr>
                        </thead>

                        <tbody id="bodyimportinvoice">
                              <?php
                              if (is_array($import_invoices)) {
                                    foreach ($import_invoices as $import_invoice) {
                              ?>
                                          <tr class="row-import-invoice" data-import_invoiceid="<?php echo $import_invoice["id"]; ?>">
                                                <td> <?php echo $import_invoice["id"]; ?></td>
                                                <td> <?php echo $import_invoice["fullname"]; ?></td>
                                                <td> <?php echo $import_invoice["created_at"]; ?></td>
                                                <td> <?php echo $import_invoice["total_import_order"]; ?></td>
                                                <td>
                                                      <?php
                                                      if (checkPermission("Delete imports", $admin)) {
                                                      ?>
                                                            <span class="fa-solid fa-trash del-importbtn" name="del-import" value="del-import"></span>
                                                      <?php
                                                      }
                                                      ?>
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