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

if (isset($_POST['update'])) {
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
if (isset($_POST['update'])) {
    $pro_id = $_POST['pro_id'];
    $fuel_type = $_POST['fuel_type'];
    $seats = $_POST['seats'];
    $registration_type = $_POST['registration_type'];
    $spare_key = $_POST['spare_key'];
    $main_warranty = $_POST['main_warranty'];
    $color = $_POST['color'];
    $registration_date = $_POST['registration_date'];
    $latest_mileage = $_POST['latest_mileage'];
    $license_plate = $_POST['license_plate'];
    $tax_expiry_date = $_POST['tax_expiry_date'];

    // เตรียมคำสั่ง SQL สำหรับการอัปเดตข้อมูล
    $sql = $conn->prepare("UPDATE car_details SET fuel_type = :fuel_type, seats = :seats, registration_type = :registration_type, spare_key = :spare_key, main_warranty = :main_warranty, color = :color, registration_date = :registration_date, latest_mileage = :latest_mileage, license_plate = :license_plate, tax_expiry_date = :tax_expiry_date WHERE pro_id = :pro_id");

    $sql->bindParam(":pro_id", $pro_id);
    $sql->bindParam(":fuel_type", $fuel_type);
    $sql->bindParam(":seats", $seats);
    $sql->bindParam(":registration_type", $registration_type);
    $sql->bindParam(":spare_key", $spare_key);
    $sql->bindParam(":main_warranty", $main_warranty);
    $sql->bindParam(":color", $color);
    $sql->bindParam(":registration_date", $registration_date);
    $sql->bindParam(":latest_mileage", $latest_mileage);
    $sql->bindParam(":license_plate", $license_plate);
    $sql->bindParam(":tax_expiry_date", $tax_expiry_date);

    if ($sql->execute()) {
        $_SESSION['success'] = "Data has been updated successfully";
        header("location: admin.php");
        exit;
    } else {
        $_SESSION['error'] = "Data has not been updated successfully";
        header("location: admin.php");
        exit;
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
    <style>
        .form-section {
            display: flex;
            justify-content: space-between;
            padding-left: 40px;
            /* ปรับค่าตามที่ต้องการ */
            padding-right: 40px;
            /* ปรับค่าตามที่ต้องการ */
           
        }
       
        .form-section1 {
            
            /* ปรับค่าตามที่ต้องการ */
            padding-right: 40px;
            /* ปรับค่าตามที่ต้องการ */

        }

        .form-container {
            width: 48%;
        }

        .form-container h1 {
            font-size: 1.5em;
        }
    </style>
</head>

<body>
    <section class="form-section">
        <div class="row">
            <div class="col-md-6">
                <h1>Edit Data</h1>
                <hr>
                <form action="editproduct.php" method="post" enctype="multipart/form-data">
                    <div class="form-section1">
                        <?php
                        if (isset($_GET['pro_id'])) {
                            $pro_id = $_GET['pro_id'];
                            $stmt = $conn->query("SELECT * FROM promodel WHERE pro_id = $pro_id");
                            $stmt->execute();
                            $data = $stmt->fetch();
                        }
                        ?>
                        <div class="col-md-12">
                            <input type="text" readonly value="<?= $data['pro_id']; ?>" required class="form-control"
                                name="pro_id">
                            <label for="pro_name" class="col-form-label">Product Name:</label>
                            <input type="text" value="<?= $data['pro_name']; ?>" required class="form-control"
                                name="pro_name">
                            <input type="hidden" value="<?= $data['image']; ?>" required class="form-control"
                                name="imageCh">
                            <input type="hidden" value="<?= $data['image2']; ?>" required class="form-control"
                                name="image2Ch">
                            <input type="hidden" value="<?= $data['image3']; ?>" required class="form-control"
                                name="image3Ch">
                            <input type="hidden" value="<?= $data['image4']; ?>" required class="form-control"
                                name="image4Ch">

                            <label for="detail" class="col-form-label">Product Detail:</label>
                            <input type="text" value="<?= $data['detail']; ?>" required class="form-control"
                                name="detail">

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

                            <label for="price" class="col-form-label">Product Price:</label>
                            <input type="text" value="<?= $data['price']; ?>" required class="form-control"
                                name="price">

                            <label for="amount" class="col-form-label">Product Amount:</label>
                            <input type="text" value="<?= $data['amount']; ?>" required class="form-control"
                                name="amount">

                            <label for="machine" class="col-form-label">Product Machine:</label>
                            <input type="text" value="<?= $data['machine']; ?>" required class="form-control"
                                name="machine">

                            <label for="image" class="col-form-label">Product Image:</label>
                            <input type="file" class="form-control" id="imgInput" name="image">
                            <img width="100%" id="previewImg" src="uploads/<?= $data['image']; ?>" alt="">

                            <label for="image2" class="col-form-label">Product Image 2:</label>
                            <input type="file" class="form-control" id="imgInput2" name="image2">
                            <img width="100%" id="previewImg2" src="uploads/<?= $data['image2']; ?>" alt="">

                            <label for="image3" class="col-form-label">Product Image 3:</label>
                            <input type="file" class="form-control" id="imgInput3" name="image3">
                            <img width="100%" id="previewImg3" src="uploads/<?= $data['image3']; ?>" alt="">

                            <label for="image4" class="col-form-label">Product Image 4:</label>
                            <input type="file" class="form-control" id="imgInput4" name="image4">
                            <img width="100%" id="previewImg4" src="uploads/<?= $data['image4']; ?>" alt="">
                        </div>
                        <div class="col-md-12">
                            <!-- เพิ่มฟิลด์สำหรับ car_details -->
                            <div class="form-section1">
                                <?php
                                if (isset($_GET['pro_id'])) {
                                    $pro_id = $_GET['pro_id'];
                                    // ดึงข้อมูล car_details ที่ตรงกับ pro_id
                                    $stmt = $conn->query("SELECT * FROM car_details WHERE pro_id = $pro_id");
                                    $stmt->execute();
                                    $data = $stmt->fetch();
                                }
                                ?>
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
                                    <input type="number" value="<?= $data['seats']; ?>" required class="form-control"
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
                                        <option value="มี" <?= $data['spare_key'] == 'มี' ? 'selected' : ''; ?>>มี
                                        </option>
                                        <option value="ไม่มี" <?= $data['spare_key'] == 'ไม่มี' ? 'selected' : ''; ?>>
                                            ไม่มี</option>
                                    </select>

                                    <label for="main_warranty" class="col-form-label">การรับประกันหลัก:</label>
                                    <select id="main_warranty" name="main_warranty" class="form-control" required>
                                        <option value="" disabled selected style="color: #6c757d;">กรุณาเลือกการรับประกัน</option>
                                        <option value="การรับประกันที่เหลือจากผู้ผลิต" <?= $data['main_warranty'] == 'การรับประกันที่เหลือจากผู้ผลิต' ? 'selected' : ''; ?>>การรับประกันที่เหลือจากผู้ผลิต</option>
                                        <option value="การรับประกันจากตัวแทนจำหน่าย" <?= $data['main_warranty'] == 'การรับประกันจากตัวแทนจำหน่าย' ? 'selected' : ''; ?>>การรับประกันจากตัวแทนจำหน่าย</option>
                                        <option value="การรับประกันเพิ่มเติมจากบริษัทประกันภัย" <?= $data['main_warranty'] == 'การรับประกันเพิ่มเติมจากบริษัทประกันภัย' ? 'selected' : ''; ?>>การรับประกันเพิ่มเติมจากบริษัทประกันภัย</option>
                                        <option value="ไม่มีการรับประกัน" <?= $data['main_warranty'] == 'ไม่มีการรับประกัน' ? 'selected' : ''; ?>>ไม่มีการรับประกัน</option>
                                    </select>
                                    <label for="color" class="col-form-label">สีหลักของรถ:</label>
                                    <select id="color" name="color" class="form-control" required>
    <option value="สีแดง" <?= $data['color'] == 'สีแดง' ? 'selected' : ''; ?>>สีแดง</option>
    <option value="สีน้ำเงิน" <?= $data['color'] == 'สีน้ำเงิน' ? 'selected' : ''; ?>>สีน้ำเงิน</option>
    <option value="สีดำ" <?= $data['color'] == 'สีดำ' ? 'selected' : ''; ?>>สีดำ</option>
    <option value="สีขาว" <?= $data['color'] == 'สีขาว' ? 'selected' : ''; ?>>สีขาว</option>
    <option value="สีเทา" <?= $data['color'] == 'สีเทา' ? 'selected' : ''; ?>>สีเทา</option>
    <option value="สีเงิน" <?= $data['color'] == 'สีเงิน' ? 'selected' : ''; ?>>สีเงิน</option>
    <option value="สีทอง" <?= $data['color'] == 'สีทอง' ? 'selected' : ''; ?>>สีทอง</option>
    <option value="สีเขียว" <?= $data['color'] == 'สีเขียว' ? 'selected' : ''; ?>>สีเขียว</option>
                                    </select>
                                
                                    <label for="registration_date" class="col-form-label">วันที่จดทะเบียนรถ:</label>
                                    <input type="date" value="<?= $data['registration_date']; ?>" required
                                        class="form-control" name="registration_date">
                                    <label for="latest_mileage" class="col-form-label">เลขไมล์ล่าสุดของรถ:</label>
                                    <input type="number" value="<?= $data['latest_mileage']; ?>" required
                                        class="form-control" name="latest_mileage">
                                    <label for="license_plate" class="col-form-label">เลขทะเบียนรถ:</label>
                                    <input type="text" value="<?= $data['license_plate']; ?>" required
                                        class="form-control" name="license_plate">
                                    <label for="tax_expiry_date" class="col-form-label">วันที่หมดอายุของภาษีรถ:</label>
                                    <input type="date" value="<?= $data['tax_expiry_date']; ?>" required
                                        class="form-control" name="tax_expiry_date">
                                </div>
                            </div>

                        </div>

                    </div>
    </section>
    <div class="mb-3">
        <button type="submit" name="update" class="btn btn-success">Update</button>
    </div>
    </form>
    </div>
    </div>


</body>

</html>


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