<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Manage Contacts</title>
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

      <main class="contact-main">

            <div class="dashboard-header">
                  <input type="text" placeholder="Search" name="searchcontactinput" id="searchcontactinput" />

                  <select class="btn- btn--hover" name="searchcontactvalue" id="searchcontactvalue">
                        <option value="id">Id</option>
                        <option value="email">Email</option>
                        <option value="phone_number">Phone number</option>
                  </select>
            </div>

            <!-- Product -->
            <div class="dashboard-body">
                  <table>
                        <thead>
                              <tr>
                                    <th>ID</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Phone number</th>
                                    <th>content</th>
                                    <th>Action</th>
                              </tr>
                        </thead>

                        <tbody id="bodycontact">
                              <?php
                              if (is_array($contacts)) {
                                    foreach ($contacts as $contact) {
                              ?>
                                          <tr data-contactid="<?php echo $contact["contact_id"]; ?>">
                                                <td> <?php echo $contact["contact_id"]; ?></td>
                                                <td> <?php echo $contact["fullname"]; ?></td>
                                                <td> <?php echo $contact["email"]; ?></td>
                                                <td> <?php echo $contact["phone_number"]; ?></td>
                                                <td> <?php echo $contact["content"]; ?></td>
                                                <td>
                                                      <?php
                                                      if (checkPermission("Delete contacts", $admin)) {
                                                      ?>

                                                            <span class="fa-solid fa-trash del-contactbtn" name="del-contact" value="del-contact"></span>

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