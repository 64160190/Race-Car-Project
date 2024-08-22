<?php
session_start();
require_once 'config/db.php';
$typeStmt = $conn->query("SELECT type_id, type_name FROM type");
$typeStmt->execute();
$types = $typeStmt->fetchAll(PDO::FETCH_ASSOC);
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
                            <label for="type" class="col-form-label">Product Type:</label>
                            <select name="type_id" class="form-control" required>
                                <option value="">Select Type</option>
                                <?php
        // ดึงข้อมูล type_id และ type_name จากตาราง type
                                 $typeStmt = $conn->query("SELECT type_id, type_name FROM type");
                                 $typeStmt->execute();
                                 $types = $typeStmt->fetchAll(PDO::FETCH_ASSOC);

                                foreach ($types as $type) {
                                    echo "<option value='{$type['type_id']}'>{$type['type_id']} - {$type['type_name']}</option>";
                                }
                                ?>
                            </select>
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
                        <div class="mb-3">
                            <label for="image" class="col-form-label">Product Image2:</label>
                            <input type="file" required class="form-control" id="imgInput" name="image2">
                            <img width="100%" id="previewImg" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label">Product Image3:</label>
                            <input type="file" required class="form-control" id="imgInput" name="image3">
                            <img width="100%" id="previewImg" alt="">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label">Product Image4:</label>
                            <input type="file" required class="form-control" id="imgInput" name="image4">
                            <img width="100%" id="previewImg" alt="">
                        </div>
    
                                <div class="col-md-6">
                                    <label for="fuel_type" class="col-form-label">ประเภทของเชื้อเพลิงที่รถใช้:</label>
                                    <select required class="form-control" name="fuel_type" id="fuel_type">
                                        <!-- น้ำมันเบนซิน -->
                                        <option value="Gasoline 95">เบนซิน 95 (Gasoline 95)</option>
                                        <option value="Gasohol 91">แก๊สโซฮอล์ 91 (Gasohol 91)</option>
                                        <option value="Gasohol 95">แก๊สโซฮอล์ 95 (Gasohol 95)</option>
                                        <option value="Gasohol E20">แก๊สโซฮอล์ E20 (Gasohol E20)</option>
                                        <option value="Gasohol E85">แก๊สโซฮอล์ E85 (Gasohol E85)</option>
                                        <!-- น้ำมันดีเซล -->
                                        <option value="Diesel">ดีเซลธรรมดา (Diesel)</option>
                                        <option value="Diesel B10">ดีเซล B10 (Diesel B10)</option>
                                        <option value="Diesel B20">ดีเซล B20 (Diesel B20)</option>
                                        <!-- ก๊าซปิโตรเลียมเหลว -->
                                        <option value="LPG">ก๊าซปิโตรเลียมเหลว (LPG - Liquefied Petroleum Gas)</option>
                                        <!-- ก๊าซธรรมชาติอัด -->
                                        <option value="CNG">ก๊าซธรรมชาติอัด (CNG - Compressed Natural Gas)</option>
                                        <!-- ไฟฟ้า -->
                                        <option value="Electricity">ไฟฟ้า (Electricity)</option>
                                        <!-- พลังงานไฮบริด -->
                                        <option value="Hybrid Gasoline">ไฟฟ้าและน้ำมันเบนซิน (Hybrid - Electricity &
                                            Gasoline)</option>
                                        <option value="Hybrid Diesel">ไฟฟ้าและน้ำมันดีเซล (Hybrid - Electricity &
                                            Diesel)</option>
                                        <!-- พลังงานไฮโดรเจน -->
                                        <option value="Hydrogen">พลังงานไฮโดรเจน (Hydrogen) (ยังไม่แพร่หลายในประเทศไทย)
                                        </option>
                                    </select>

                                    <label for="seats" class="col-form-label">จำนวนที่นั่งในรถ:</label>
                                    <input type="number"  required class="form-control"
                                        name="seats">
                                    <label for="registration_type" class="col-form-label">ประเภทของการจดทะเบียน:</label>
                                    <select required class="form-control" name="registration_type">
                                        <option value="รย.1">รย.1 - รถยนต์นั่งส่วนบุคคลไม่เกิน 7 คน</option>
                                        <option value="รย.2">รย.2 - รถยนต์นั่งส่วนบุคคลเกิน 7 คน</option>
                                        <option value="รย.3">รย.3 - รถยนต์บรรทุกส่วนบุคคล</option>
                                        <option value="รย.4">รย.4 - รถยนต์สามล้อส่วนบุคคล</option>
                                        <option value="รย.5">รย.5 - รถยนต์รับจ้างระหว่างจังหวัด</option>
                                        <option value="รย.6">รย.6 - รถยนต์รับจ้างบรรทุกคนโดยสารไม่เกิน 7 คน</option>
                                        <option value="รย.7">รย.7 - รถยนต์สี่ล้อเล็กรับจ้าง</option>
                                        <option value="รย.8">รย.8 - รถยนต์สี่ล้อเล็ก</option>
                                        <option value="รย.9">รย.9 - รถยนต์สามล้อรับจ้าง</option>
                                        <option value="รย.10">รย.10 - รถจักรยานยนต์ส่วนบุคคล</option>
                                        <option value="รย.11">รย.11 - รถจักรยานยนต์รับจ้าง</option>
                                        <option value="รย.12">รย.12 - รถจักรยานยนต์บรรทุกสินค้า</option>
                                        <option value="รย.13">รย.13 - รถสามล้อเครื่องยนต์</option>
                                        <option value="รย.14">รย.14 - รถสี่ล้อเครื่องยนต์</option>
                                        <option value="รย.15">รย.15 - รถลากจูง</option>
                                        <option value="รย.16">รย.16 - รถเครื่องจักรกล</option>
                                        <option value="รย.17">รย.17 - รถอื่นๆ</option>
                                    </select>
                                    <label for="spare_key" class="col-form-label">กุญแจสำรอง:</label>
                                    <select id="spare_key" name="spare_key" class="form-control" required>

                                        <option value="" disabled selected>กรุณาเลือกว่ามีกุญแจสำรองหรือไม่</option>
                                        <option value="มี"  >มี
                                        </option>
                                        <option value="ไม่มี" >
                                            ไม่มี</option>
                                    </select>

                                    <label for="main_warranty" class="col-form-label">การรับประกันหลัก:</label>
                                    <select id="main_warranty" name="main_warranty" class="form-control" required>
                                        <option value="" disabled selected style="color: #6c757d;">กรุณาเลือกการรับประกัน</option>
                                        <option value="การรับประกันที่เหลือจากผู้ผลิต" >การรับประกันที่เหลือจากผู้ผลิต</option>
                                        <option value="การรับประกันจากตัวแทนจำหน่าย" >การรับประกันจากตัวแทนจำหน่าย</option>
                                        <option value="การรับประกันเพิ่มเติมจากบริษัทประกันภัย" >การรับประกันเพิ่มเติมจากบริษัทประกันภัย</option>
                                        <option value="ไม่มีการรับประกัน">ไม่มีการรับประกัน</option>
                                    </select>
                                    <label for="color" class="col-form-label">สีหลักของรถ:</label>
                                    <select id="color" name="color" class="form-control" required>
    <option value="สีแดง" >สีแดง</option>
    <option value="สีน้ำเงิน">สีน้ำเงิน</option>
    <option value="สีดำ" >สีดำ</option>
    <option value="สีขาว">สีขาว</option>
    <option value="สีเทา">สีเทา</option>
    <option value="สีเงิน">สีเงิน</option>
    <option value="สีทอง">สีทอง</option>
    <option value="สีเขียว">สีเขียว</option>
                                    </select>
                                
                                    <label for="registration_date" class="col-form-label">วันที่จดทะเบียนรถ:</label>
                                    <input type="date"  required
                                        class="form-control" name="registration_date">
                                    <label for="latest_mileage" class="col-form-label">เลขไมล์ล่าสุดของรถ:</label>
                                    <input type="number" required
                                        class="form-control" name="latest_mileage">
                                    <label for="license_plate" class="col-form-label">เลขทะเบียนรถ:</label>
                                    <input type="text" required
                                        class="form-control" name="license_plate">
                                    <label for="tax_expiry_date" class="col-form-label">วันที่หมดอายุของภาษีรถ:</label>
                                    <input type="date"  required
                                        class="form-control" name="tax_expiry_date">
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
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#proModel">Add
                    Product</button>
            </div>
        </div>

        <div class="container mt-5">
            <?php
        if (isset($_SESSION['success'])) { ?>
            <div class="alert alert-success">
                <?php
                echo $_SESSION['success'];
                unset($_SESSION['success']);
                ?>
            </div>
            <?php } ?>
            <?php
        if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
                <?php
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
            <?php } ?>
            <!-- Admin Data -->
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">รหัสสินค้า</th>
                        <th scope="col">ชื่อสินค้า</th>
                        <th scope="col">รายละเอียด</th>
                        <th scope="col">รหัสรุ่น</th>
                        <th scope="col">ชื่อรุ่น</th>
                        <th scope="col">ราคา</th>
                        <th scope="col">คงเหลือ</th>
                        <th scope="col">เครื่องยนต์</th>
                        <th scope="col">รูปหลัก</th>
                        <th scope="col">รูปรอง</th>
                        <th scope="col">รูปรอง</th>
                        <th scope="col">รูปรอง</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                $stmt = $conn->query("SELECT * FROM promodel");
                $stmt->execute();
                $promodel = $stmt->fetchAll();

                if (!$promodel) {
                    echo "<tr><td colspan='13' class='text-center'>No product found</td></tr>";
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
                        <td width="100px"><img width="100%" src="uploads/<?= $promodels['image']; ?>" class="rounded"
                                alt=""></td>
                        <td width="100px"><img width="100%" src="uploads/<?= $promodels['image2']; ?>" class="rounded"
                                alt=""></td>
                        <td width="100px"><img width="100%" src="uploads/<?= $promodels['image3']; ?>" class="rounded"
                                alt=""></td>
                        <td width="100px"><img width="100%" src="uploads/<?= $promodels['image4']; ?>" class="rounded"
                                alt=""></td>
                        <td>
                            <a href="editproduct.php?pro_id=<?= $promodels['pro_id']; ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="?delete=<?= $promodels['pro_id']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete?')">Delete</a>
                        </td>
                    </tr>
                    <?php
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
</body>

</html>