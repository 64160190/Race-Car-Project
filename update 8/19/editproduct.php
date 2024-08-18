<?php
session_start();
require_once 'config/db.php';
$typeStmt = $conn->query("SELECT type_id, type_name FROM type");
$typeStmt->execute();
$types = $typeStmt->fetchAll(PDO::FETCH_ASSOC);
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ !';
    header('location: signin.php');
}

if (isset($_POST['update'])){
    $pro_id = $_POST['pro_id'];
    $pro_name = $_POST['pro_name'];
    $detail = $_POST['detail'];
    $type_id = $_POST['type_id'];

    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $machine = $_POST['machine'];
    $image = $_FILES['image'];
    $image2 = $_FILES['image2'];
    $image3 = $_FILES['image3'];
    $image4 = $_FILES['image4'];

    $imageCh = $_POST['imageCh'];
    $image2Ch = $_POST['image2Ch'];
    $image3Ch = $_POST['image3Ch'];
    $image4Ch = $_POST['image4Ch'];

    $upload = $_FILES['image']['name'];
    $upload2 = $_FILES['image2']['name'];
    $upload3 = $_FILES['image3']['name'];
    $upload4 = $_FILES['image4']['name'];

    $allow = array('jpg', 'jpeg', 'png');

    // Handle image uploads
    $fileNew = $fileNew2 = $fileNew3 = $fileNew4 = '';
    
    if ($upload != '') {
        $extension = explode(".", $image['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "uploads/" . $fileNew;
        if (in_array($fileActExt, $allow)) {
            if ($image['size'] > 0 && $image['error'] == 0) {
                move_uploaded_file($image['tmp_name'], $filePath);
            }
        }
    } else {
        $fileNew = $imageCh;
    }

    if ($upload2 != '') {
        $extension2 = explode(".", $image2['name']);
        $fileActExt2 = strtolower(end($extension2));
        $fileNew2 = rand() . "." . $fileActExt2;
        $filePath2 = "uploads/" . $fileNew2;
        if (in_array($fileActExt2, $allow)) {
            if ($image2['size'] > 0 && $image2['error'] == 0) {
                move_uploaded_file($image2['tmp_name'], $filePath2);
            }
        }
    } else {
        $fileNew2 = $image2Ch;
    }

    if ($upload3 != '') {
        $extension3 = explode(".", $image3['name']);
        $fileActExt3 = strtolower(end($extension3));
        $fileNew3 = rand() . "." . $fileActExt3;
        $filePath3 = "uploads/" . $fileNew3;
        if (in_array($fileActExt3, $allow)) {
            if ($image3['size'] > 0 && $image3['error'] == 0) {
                move_uploaded_file($image3['tmp_name'], $filePath3);
            }
        }
    } else {
        $fileNew3 = $image3Ch;
    }

    if ($upload4 != '') {
        $extension4 = explode(".", $image4['name']);
        $fileActExt4 = strtolower(end($extension4));
        $fileNew4 = rand() . "." . $fileActExt4;
        $filePath4 = "uploads/" . $fileNew4;
        if (in_array($fileActExt4, $allow)) {
            if ($image4['size'] > 0 && $image4['error'] == 0) {
                move_uploaded_file($image4['tmp_name'], $filePath4);
            }
        }
    } else {
        $fileNew4 = $image4Ch;
    }
    $typeStmt = $conn->prepare("SELECT type_name FROM type WHERE type_id = :type_id");
    $typeStmt->bindParam(':type_id', $type_id);
    $typeStmt->execute();
    $type = $typeStmt->fetch(PDO::FETCH_ASSOC);
    $type_name = $type ? $type['type_name'] : ''; // ตรวจสอบให้แน่ใจว่า type_name ไม่เป็น null
    
    $sql = $conn->prepare("UPDATE promodel SET pro_name = :pro_name, detail = :detail, type_id = :type_id, type_name = :type_name, price = :price, amount = :amount, machine = :machine, image = :image, image2 = :image2, image3 = :image3, image4 = :image4 WHERE pro_id = :pro_id");
    $sql->bindParam(":pro_id", $pro_id);
    $sql->bindParam(":pro_name", $pro_name);
    $sql->bindParam(":detail", $detail);
    $sql->bindParam(":type_id", $type_id);
    $sql->bindParam(":type_name", $type_name);
    $sql->bindParam(":price", $price);
    $sql->bindParam(":amount", $amount);
    $sql->bindParam(":machine", $machine);
    $sql->bindParam(":image", $fileNew);
    $sql->bindParam(":image2", $fileNew2);
    $sql->bindParam(":image3", $fileNew3);
    $sql->bindParam(":image4", $fileNew4);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "Data has been updated successfully";
        header("location: admin.php");
    } else {
        $_SESSION['error'] = "Data has not been updated successfully";
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
                <input type="hidden" value="<?= $data['image2']; ?>" required class="form-control" name="image2Ch">
                <input type="hidden" value="<?= $data['image3']; ?>" required class="form-control" name="image3Ch">
                <input type="hidden" value="<?= $data['image4']; ?>" required class="form-control" name="image4Ch">
            </div>
            <div class="mb-3">
                <label for="detail" class="col-form-label">Product Detail:</label>
                <input type="text" value="<?= $data['detail']; ?>" required class="form-control" name="detail">
            </div>
            <div class="mb-3">
    <label for="type" class="col-form-label">Product Type:</label>
    
    <select name="type_id" class="form-control" required>
        <option value="">Select Type</option>
        <?php
        // ดึงข้อมูล type_id และ type_name จากตาราง type
        $typeStmt = $conn->query("SELECT type_id, type_name FROM type");
        $typeStmt->execute();
        $types = $typeStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($types as $type) {
            $selected = ($type['type_id'] == $data['type_id']) ? 'selected' : '';
            echo "<option value='{$type['type_id']}' {$selected}>{$type['type_id']} - {$type['type_name']}</option>";
        }
        ?>
    </select>
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
                <input type="file" class="form-control" id="imgInput" name="image">
                <img width="100%" id="previewImg" src="uploads/<?= $data['image']; ?>" alt="">
            </div>
            <div class="mb-3">
                <label for="image2" class="col-form-label">Product Image 2:</label>
                <input type="file" class="form-control" id="imgInput2" name="image2">
                <img width="100%" id="previewImg2" src="uploads/<?= $data['image2']; ?>" alt="">
            </div>
            <div class="mb-3">
                <label for="image3" class="col-form-label">Product Image 3:</label>
                <input type="file" class="form-control" id="imgInput3" name="image3">
                <img width="100%" id="previewImg3" src="uploads/<?= $data['image3']; ?>" alt="">
            </div>
            <div class="mb-3">
                <label for="image4" class="col-form-label">Product Image 4:</label>
                <input type="file" class="form-control" id="imgInput4" name="image4">
                <img width="100%" id="previewImg4" src="uploads/<?= $data['image4']; ?>" alt="">
            </div>
            <div class="mb-3">
                <button type="submit" name="update" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script>
function previewImage(inputId, previewId) {
    let imgInput = document.getElementById(inputId);
    let previewImg = document.getElementById(previewId);
    imgInput.onchange = evt => {
        const [file] = imgInput.files;
        if (file) {
            previewImg.src = URL.createObjectURL(file);
        }
    }
}

previewImage('imgInput', 'previewImg');
previewImage('imgInput2', 'previewImg2');
previewImage('imgInput3', 'previewImg3');
previewImage('imgInput4', 'previewImg4');
</script>

</html>