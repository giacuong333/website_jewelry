<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Manage Statistics</title>

      <!-- Style -->
      <link rel="stylesheet" href="../assets/css/admin.css" />

      <!-- Icon -->
      <link rel="stylesheet" href="../assets/icons/css/all.min.css">

      <!-- CDN Boostrap Css -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />

      <!-- CDN Boostrap Js  -->
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

      <!-- Chart js -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>

      <!-- JQuery -->
      <script src="../assets/libs/jquery-3.7.1.min.js"></script>

      <!-- Date Picker -->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
      <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
      <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

      <!-- Config datepicker -->
      <script src="../js/datepicker.config.js" defer></script>

      <!-- Chart -->
      <script src="../js/revenue.js"></script>

</head>

<body>
      <?php
      include_once("../admin/common.php");
      include_once("../includes/admin.inc.php"); ?>

      <main>
            <!-- EXPORT ORDERS -->
            <section>
                  <h2 class="header mb-4">EXPORT ORDERS</h2>
                  <div class="dashboard-header">
                        <!-- Search for orders in a range date -->
                        <div class="btns">
                              <button type="button" class="btn- btn--hover btn--active" id="monthly">Monthly</button>
                              <button type="button" class="btn- btn--hover" id="anually">Anually</button>
                        </div>
                  </div>

                  <!-- Export chart -->
                  <div class="chart-container">
                        <canvas id="export-chart"></canvas>
                  </div>

                  <!-- Table -->
                  <section class="section-table my-5">
                        <h2 class="">BEST SELLERS</h2>
                        <table class="table table-striped">
                              <thead class="" style="border-bottom: solid 1px #000">
                                    <tr>
                                          <th class="text-start">Product ID</th>
                                          <th class="text-start">Product name</th>
                                          <th>Sold quantity</th>
                                    </tr>
                              </thead>
                              <tbody class="sold-amount-tbody">
                              </tbody>
                        </table>
                  </section>
            </section>

            <!-- IMPORT ORDERS -->
            <section>
                  <h2 class="header mb-4">IMPORT ORDERS</h2>

                  <!-- Chart -->
                  <div class="chart-container">
                        <canvas id="import-chart"></canvas>
                  </div>
            </section>

      </main>
</body>

</html>