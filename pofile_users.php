<?php 
    session_start();
    require_once 'config/db.php';
    if(!isset($_SESSION['user_login'])) {
        $_SESSION['error'] = 'กรณาเข้าสู่ระบบ !';
        header('location: signin.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once('nav.php') ?>
<?php include_once('header.php') ?>
<body>

          
      
     <div class="container">
        <?php
            if (isset($_SESSION['user_login'])){
                $user_id = $_SESSION['user_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
        <h3 class="mt-4">Welcome, <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h3>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div> 
    <?php include_once('fooster.php') ?>
</body>
</html>