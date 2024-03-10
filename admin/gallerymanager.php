<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Manage gallery</title>
      <!-- Style -->
      <link rel="stylesheet" href="../assets/css/admin.css" />
      <!-- Icon -->
      <link rel="stylesheet" href="../assets/icons/css/all.min.css">
      <!-- JQuery -->
      <script src="../assets/libs/jquery-3.7.1.min.js"></script>
</head>

<?php
if (isset($_GET["page-nr"])) {
      $id = $_GET["page-nr"];
} else {
      $id = 1;
}
?>

<body id="<?php echo $id; ?>">
      <?php
      include("../includes/admin.inc.php");
      include("../admin/common.php");
      ?>

      <main>
            <div class="dashboard-header">
                  <input type="text" placeholder="Search" name="searchgalleryinput" id="searchgalleryinput" />

                  <select class="btn- btn--hover" name="searchgalleryvalue" id="searchgalleryvalue">
                        <option value="title">Title</option>
                  </select>

                  <?php
                  if (checkPermission("Add galleries", $admin)) {
                  ?>
                        <button id="addgallery" class="btn- btn--hover" type="button">Upload image</button>
                  <?php
                  }
                  ?>
            </div>

            <!-- Product -->
            <div class="dashboard-body">
                  <div class="header" style="font-size:14px; font-weight:300; letter-spacing: 1px;">
                        Welcome to the gallery page, you can view the list of images below.
                  </div>

                  <div class="body">
                        <div class="gallery-container">
                              <?php
                              $gallery_list = $admin->getGalleries();
                              foreach ($gallery_list["results"] as $item) {
                                    echo '
                                    <div class="gallery-container__item" id="' . $item["id"] . '">
                                          <img src="' . $item["thumbnail"] . '" alt="' . $item["title"] . '" class="gallery-container__item-image">
                                    </div>';
                              }
                              ?>
                        </div>

                        <div class="pagination-container">
                              <div class="pagination-container__pages">
                                    <a href="?page-nr=1" class="btn-">First</a>

                                    <?php
                                    if (isset($_GET["page-nr"]) && $_GET["page-nr"] > 1) {
                                    ?>

                                          <a href="?page-nr=<?php echo (int)$_GET["page-nr"] - 1; ?>" class="btn-">Prev</a>

                                    <?php
                                    }
                                    ?>

                                    <?php
                                    for ($counter = 1; $counter <= $gallery_list["pages"]; $counter++) {
                                    ?>

                                          <a href="?page-nr=<?php echo $counter; ?>" class="btn- pagination-container__pages-num"><?php echo $counter; ?></a>

                                    <?php
                                    }
                                    ?>

                                    <?php
                                    if (!isset($_GET["page-nr"])) {
                                    ?>

                                          <a href="?page-nr=2" class="btn-">Next</a>

                                          <?php
                                    } else {
                                          if ($_GET["page-nr"] < $gallery_list["pages"]) {

                                          ?>
                                                <a href="?page-nr=<?php echo $_GET["page-nr"] + 1; ?>" class="btn-">Next</a>
                                    <?php
                                          }
                                    }
                                    ?>

                                    <a href="?page-nr=<?php echo $gallery_list["pages"] ?>" class="btn-">Last</a>
                              </div>
                        </div>
                  </div>
            </div>

      </main>

</body>

</html>