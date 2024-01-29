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

</head>

<body>
          <?php include("../admin/common.php"); ?>

          <main>

                    <div class="dashboard-header">
                              <input type="text" placeholder="Search" />

                              <select class="btn- btn--hover" name="" id="">
                                        <option value="">Id</option>
                                        <option value="">Fullname</option>
                                        <option value="">Email</option>
                                        <option value="">Phone number</option>
                                        <option value="">Role</option>
                                        <option value="">Create time</option>
                                        <option value="">Update time</option>
                              </select>

                              <button id="adduser" class="btn- btn--hover" type="button">
                                        <span class="fa-solid fa-plus"></span>
                                        Add new
                              </button>
                    </div>

                    <!-- Product -->
                    <div class="dashboard-body">
                              <table>
                                        <thead>
                                                  <tr>
                                                            <th>ID</th>
                                                            <th>Full name</th>
                                                            <th>Email</th>
                                                            <th>Phone number</th>
                                                            <th>Role</th>
                                                            <th>Create time</th>
                                                            <th>Update time</th>
                                                            <th>Action</th>
                                                  </tr>
                                        </thead>

                                        <tbody>
                                                  <?php
                                                  include("../includes/admin.inc.php");

                                                  if (is_array($users)) {
                                                            foreach ($users as $user) {
                                                  ?>
                                                                      <tr>
                                                                                <td name="user_id"><?php echo $user["id"]; ?></td>
                                                                                <td> <?php echo $user["fullname"]; ?></td>
                                                                                <td> <?php echo $user["email"]; ?></td>
                                                                                <td> <?php echo $user["phone_number"]; ?></td>
                                                                                <td> <?php echo $user["name"]; ?></td>
                                                                                <td> <?php echo $user["created_at"]; ?></td>
                                                                                <td> <?php echo $user["updated_at"]; ?></td>
                                                                                <td>
                                                                                          <span class="fa-solid fa-pen-to-square edit-userbtn" name="editbtn" value="editbtn"></span>
                                                                                          <span class="fa-solid fa-trash" name="delbtn" value="delbtn"></span>
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