<?php
session_start();
require_once 'config/db.php';
?>
<html lang="en">

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

  <?php include_once('nav.php') ?>
  <?php include_once('header.php') ?>


  <body>
    <div class="container">
      <div class="row">
        <?php
        $stmt = $conn->query("SELECT * FROM promodel");
        $stmt->execute();
        $promodel = $stmt->fetchAll();
        if (!$promodel) {
          echo "<tr><td colspan='6' class='text-center'>No product found</td></tr>";
        } else {
          foreach ($promodel as $promodels) {
          }
        }
        foreach ($promodel as $promodels) {
      ?>
        
        <div class="col-sm-4">
          <img src="uploads/<?= $promodels['image']; ?>" class="product-img"> <br>
          ID: <?= $promodels['pro_id']; ?> <br>
          <h5 class="text-success"><?= $promodels['pro_name']; ?> </h5>
          ราคา :<b class="text-danger"> <?= $promodels['price']; ?></b> บาท <br>
          <a class="btn btn-secondary mt-3" href="sh_product_detail.php?id=<?= $promodels['pro_id']; ?>">รายละเอียด </a> 
        </div>
        <?php
        }
        $conn = null;
        ?>
      </div>
    </div>
    
    <!-- Footer -->
    <?php include_once('fooster.php') ?>
  </body>

</html>