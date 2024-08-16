<?php
session_start();
require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">

 <?php include_once('nav.php') ?>
  <?php include_once('header.php') ?>

<body>
    <div class="container">
        <div class="row">
        <?php
        $ids = $_GET['id'];

        // ตรวจสอบว่ามีการส่ง id มาหรือไม่
        if (!isset($ids)) {
            echo "<tr><td colspan='6' class='text-center'>No product found</td></tr>";
            exit;
        }

        $sql = "SELECT * FROM promodel, type WHERE promodel.type_id = type.type_id AND promodel.pro_id = :id";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $ids);
        $stmt->execute();
        $promodel = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($promodel)) {
            echo "<tr><td colspan='6' class='text-center'>No product found</td></tr>";
        } else {
            foreach ($promodel as $promodels) {
                ?>
                <div class="col-md-6">
                    <img src="uploads/<?= htmlspecialchars($promodels['image']); ?>" width="100%" />
                </div>

                <div class="col-md-12">
                    ID: <?= htmlspecialchars($promodels['pro_id']); ?> <br>
                    <h5 class="text-success"><?= htmlspecialchars($promodels['pro_name']); ?></h5>
                    ราคา :<b class="text-danger"> <?= htmlspecialchars($promodels['price']); ?></b> บาท <br>
                </div>
                <?php
            }
        }
        $conn = null;
        ?>
</body>
<?php include_once('fooster.php') ?>

</html>