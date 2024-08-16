<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรณาเข้าสู่ระบบ !';
    header('location: signin.php');
}

if (isset($_POST['update'])){
    $pro_id = $_POST['pro_id'];
    $pro_name = $_POST['pro_name'];
    $detail = $_POST['detail'];
    $type_id = $_POST['type_id'];
    $type_name = $_POST['type_name'];
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $machine = $_POST['machine'];
    $image = $_FILES['image'];

    $imageCh = $_POST['imageCh'];
    $upload = $_FILES['image']['name'];

    if($upload != ''){
        $allow = array('jpg','jpeg','png');
        $extension = explode(".",$image['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "uploads/".$fileNew;
        if(in_array($fileActExt, $allow)) {
            if ($image['size'] > 0 && $image['error'] == 0) { 
                move_uploaded_file($image['tmp_name'],$filePath);
                }
            }
    } else{
        $fileNew = $imageCh;
    }
    $sql = $conn->prepare("UPDATE promodel SET pro_name = :pro_name, detail = :detail, type_id = :type_id, type_name = :type_name, price = :price, amount = :amount, machine = :machine, image = :image WHERE pro_id = :pro_id" );
    $sql->bindParam(":pro_id", $pro_id);
    $sql->bindParam(":pro_name", $pro_name);
    $sql->bindParam(":detail", $detail);
    $sql->bindParam(":type_id", $type_id);
    $sql->bindParam(":type_name", $type_name);
    $sql->bindParam(":price", $price);
    $sql->bindParam(":amount", $amount);
    $sql->bindParam(":machine", $machine);
    $sql->bindParam(":image", $fileNew);
    $sql->execute();
    if ($sql) {
        $_SESSION['success'] = "Data has been updated suuuccesfully";
        header("location: admin.php");
    } else {
        $_SESSION['error'] = "Data has not been updated suuuccesfully";
        header("location: admin.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('header.php') ?>
    <title>Admin Page</title>
    <!--<style>
        .container {
            max-width: 550px;
        }
    </style> -->
</head>

<body>
    <div class="container">
        <?php
        if (isset($_SESSION['admin_login'])) {
            $admin_id = $_SESSION['admin_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id = $admin_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        ?>
        <h3 class="mt-4">Welcome Admin, <?php echo $row['firstname'] . ' ' . $row['lastname'] ?></h3>
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <div class="container mt-5">
        <h1>Edit Data</h1>
        <hr>
        <form action="editproduct.php" method="post" enctype="multipart/form-data">
            <?php 
                if(isset($_GET['pro_id'])){
                    $pro_id = $_GET['pro_id'];
                    $stmt = $conn->query("SELECT * FROM promodel WHERE pro_id = $pro_id");
                    $stmt->execute();
                    $data = $stmt->fetch();
                }
            ?>
            <div class="mb-3">
            <input type="text" readonly value="<?= $data['pro_id']; ?>" required class="form-control" name="pro_id">
                <label for="pro_name" class="col-form-label">Product Name:</label>
                <input type="text" value="<?= $data['pro_name']; ?>" required class="form-control" name="pro_name"> 
                <input type="hidden" value="<?= $data['image']; ?>" required class="form-control" name="imageCh">
            </div>
            <div class="mb-3">
                <label for="detail" class="col-form-label">Product Detail:</label>
                <input type="text" value="<?= $data['detail']; ?>" required class="form-control" name="detail">
            </div>
            <div class="mb-3">
                <label for="type_id" class="col-form-label">Product Type:</label>
                <input type="text" value="<?= $data['type_id']; ?>" required class="form-control" name="type_id">
            </div>
            <div class="mb-3">
                <label for="type_name" class="col-form-label">Type Name:</label>
                <input type="text" value="<?= $data['type_name']; ?>" required class="form-control" name="type_name">
            </div>
            <div class="mb-3">
                <label for="price" class="col-form-label">Product Price:</label>
                <input type="text" value="<?= $data['price']; ?>" required class="form-control" name="price">
            </div>
            <div class="mb-3">
                <label for="amount" class="col-form-label">Product Amount:</label>
                <input type="text" value="<?= $data['amount']; ?>" required class="form-control" name="amount">
            </div>
            <div class="mb-3">
                <label for="machine" class="col-form-label">Product Machine:</label>
                <input type="text" value="<?= $data['machine']; ?>" required class="form-control" name="machine">
            </div>
            <div class="mb-3">
                <label for="image" class="col-form-label">Product Image:</label>
                <input type="file"  class="form-control" id="imgInput" name="image">
                <img width="100%" src="uploads/<?= $data['image'];?>" id="previewImg" alt="">
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="admin.php">Go Back</a>
                <button type="submit" name="update" class="btn btn-success">Update</button>
            </div>
        </form>

    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script>
    let imgInput = document.getElementById('imgInput');
    let previewImg = document.getElementById('previewImg');
    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            previewImg.src = URL.createObjectURL(file);
        }
    }
</script>

</html>