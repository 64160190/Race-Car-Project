<?php
session_start();
require_once 'config/db.php';
?>
<html lang="en">
<head>
<?php include_once('nav.php') ?>
<?php include_once('header.php') ?>
<body>
 

  <div class="container">
    <div class="row">
      <?php
      // Number of items per page
      $items_per_page = 12;
      // Get current page from URL, default to 1
      $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      // Calculate the offset for SQL query
      $offset = ($current_page - 1) * $items_per_page;

      // Query to get the total number of items
      $total_stmt = $conn->query("SELECT COUNT(*) FROM promodel");
      $total_items = $total_stmt->fetchColumn();
      $total_pages = ceil($total_items / $items_per_page);

      // Query to get the items for the current page
      $stmt = $conn->prepare("SELECT * FROM promodel LIMIT :offset, :items_per_page");
      $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
      $stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
      $stmt->execute();
      $promodel = $stmt->fetchAll();

      if (!$promodel) {
        echo "<div class='col-12 text-center'>No product found</div>";
      } else {
        foreach ($promodel as $promodels) {
      ?>
        <div class="col-sm-4 mb-4">
          <img src="uploads/<?= htmlspecialchars($promodels['image']); ?>" class="product-img" alt="<?= htmlspecialchars($promodels['pro_name']); ?>"> <br>
          ID: <?= htmlspecialchars($promodels['pro_id']); ?> <br>
          <h5 class="text-success"><?= htmlspecialchars($promodels['pro_name']); ?> </h5>
          ราคา :<b class="text-danger"> <?= htmlspecialchars($promodels['price']); ?></b> บาท <br>
          <a class="btn btn-secondary mt-3" href="sh_product_detail.php?id=<?= htmlspecialchars($promodels['pro_id']); ?>">รายละเอียด </a> 
        </div>
      <?php
        }
      }
      $conn = null;
      ?>
    </div>

    <!-- Pagination -->
    <nav>
      <ul class="pagination">
        <?php if ($current_page > 1): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $current_page - 1; ?>" aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>
        <?php endif; ?>

        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
          <li class="page-item <?= $page == $current_page ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?= $page; ?>"><?= $page; ?></a>
          </li>
        <?php endfor; ?>

        <?php if ($current_page < $total_pages): ?>
          <li class="page-item">
            <a class="page-link" href="?page=<?= $current_page + 1; ?>" aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>

  <!-- Footer -->
  <?php include_once('fooster.php') ?>
</body>
</html>
