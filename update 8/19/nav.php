<?php

require_once 'config/db.php';
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">LOGO</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <a class="nav-link active" href="show_product.php">ซื้อรถยนต์</a>
                <a class="nav-link active" href="#">ขายรถยนต์</a>
            </div>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="#"><i class="fas fa-phone-alt"></i> 02-564-4498</a>
                <div class="check-login">
                <?php
            if (isset($_SESSION['user_login'])){
                $user_id = $_SESSION['user_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
                    <?php if (isset($_SESSION['user_login'])) {
                         ?>
                        <a href="pofile_users.php" class="login-button active"><i class="fas fa-user"></i> <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></a>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    <?php } else { ?>
                        <a href="signin.php" class="nav-link active"><i class="fas fa-user"></i> Login</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</nav>