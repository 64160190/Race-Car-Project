<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรณาเข้าสู่ระบบ !';
    header('location: signin.php');
}

if (isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $deletestmt = $conn->query("DELETE FROM promodel WHERE pro_id = $delete_id");
    $deletestmt->execute();
    
    if ($deletestmt){
        echo "<script>alert('Data has been deleted suuccessfully')</script>";
        $_SESSION['success'] = "Data has been deleted suuccessfully";
        header("refresh:0.5; url=admin.php");
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
    <div class="modal fade" id="proModel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add model</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="insert.php" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="pro_name" class="col-form-label">Product Name:</label>
                            <input type="text" required class="form-control" name="pro_name">
                        </div>
                        <div class="mb-3">
                            <label for="detail" class="col-form-label">Product Detail:</label>
                            <input type="text" required class="form-control" name="detail">
                        </div>
                        <div class="mb-3">
                            <label for="type_id" class="col-form-label">Product Type:</label>
                            <input type="text" required class="form-control" name="type_id">
                        </div>
                        <div class="mb-3">
                            <label for="type_name" class="col-form-label">Type Name:</label>
                            <input type="text" required class="form-control" name="type_name">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="col-form-label">Product Price:</label>
                            <input type="text" required class="form-control" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label">Product Amount:</label>
                            <input type="text" required class="form-control" name="amount">
                        </div>
                        <div class="mb-3">
                            <label for="machine" class="col-form-label">Product Machine:</label>
                            <input type="text" required class="form-control" name="machine">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label">Product Image:</label>
                            <input type="file" required class="form-control" id="imgInput" name="image">
                            <img width="100%" id="previewImg" alt="">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>CRUD</h1>
            </div>
            <div class="col-md-6 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#proModel">Add Product</button>
            </div>
        </div>
        <hr>
        <?php
        if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['succes']);
                ?>
            </div>

        <?php }  ?>
        <?php
        if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>

        <?php }  ?>
        <!-- Admin Data-->
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">pro_name</th>
                    <th scope="col">detail</th>
                    <th scope="col">type_id</th>
                    <th scope="col">type_name</th>
                    <th scope="col">price</th>
                    <th scope="col">amount</th>
                    <th scope="col">machine</th>
                    <th scope="col">image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $stmt = $conn->query("SELECT * FROM promodel");
                    $stmt->execute();
                    $promodel = $stmt->fetchAll();

                    if(!$promodel){
                        echo "<tr><td colspan='6' class='text-center'>No product found</td></tr>";
                    } else {
                        foreach ($promodel as $promodels) {

                      
                ?>
                <tr>
                    <th scope="row"><?= $promodels['pro_id']; ?></th>
                    <td><?= $promodels['pro_name']; ?></td>
                    <td><?= $promodels['detail']; ?></td>
                    <td><?= $promodels['type_id']; ?></td>
                    <td><?= $promodels['type_name']; ?></td>
                    <td><?= $promodels['price']; ?></td>
                    <td><?= $promodels['amount']; ?></td>
                    <td><?= $promodels['machine']; ?></td>
                    <td width="250px"><img width="100%" src="uploads/<?= $promodels['image'];?>" class="rounded" alt=""></td>
                    <td>
                        <a href="editproduct.php?pro_id=<?= $promodels['pro_id'];?>" class="btn btn-warning">Edit</a>
                        <a href="?delete=<?= $promodels['pro_id'];?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?')">Delete</a>

                    </td>
                </tr>
                <?php  }
                         } ?>
            </tbody>
        </table>
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