<?php
session_start();
require_once 'config/db.php';

if (isset($_POST['submit'])) {
    $pro_name = $_POST['pro_name'];
    $detail = $_POST['detail'];
    $type_id = $_POST['type_id'];  // รับค่า type_id จาก dropdown
    
    $price = $_POST['price'];
    $amount = $_POST['amount'];
    $machine = $_POST['machine'];
    $image = $_FILES['image'];
    $image2 = $_FILES['image2'];
    $image3 = $_FILES['image3'];
    $image4 = $_FILES['image4'];

    $upload = $_FILES['image']['name'];
    $upload2 = $_FILES['image2']['name'];
    $upload3 = $_FILES['image3']['name'];
    $upload4 = $_FILES['image4']['name'];

    $allow = array('jpg', 'jpeg', 'png');

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
    }

    // ดึงค่า type_name จาก type_id
    $typeStmt = $conn->prepare("SELECT type_name FROM type WHERE type_id = :type_id");
    $typeStmt->bindParam(':type_id', $type_id);
    $typeStmt->execute();
    $type = $typeStmt->fetch(PDO::FETCH_ASSOC);
    $type_name = $type ? $type['type_name'] : ''; // ตรวจสอบให้แน่ใจว่า type_name ไม่เป็น null

    $sql = $conn->prepare("INSERT INTO promodel (pro_name, detail, type_id, type_name, price, amount, machine, image, image2, image3, image4) VALUES (:pro_name, :detail, :type_id, :type_name, :price, :amount, :machine, :image, :image2, :image3, :image4)");
    $sql->bindParam(":pro_name", $pro_name);
    $sql->bindParam(":detail", $detail);
    $sql->bindParam(":type_id", $type_id);
    $sql->bindParam(":type_name", $type_name);  // ส่งค่า type_name ที่ดึงมาจาก type_id
    $sql->bindParam(":price", $price);
    $sql->bindParam(":amount", $amount);
    $sql->bindParam(":machine", $machine);
    $sql->bindParam(":image", $fileNew);
    $sql->bindParam(":image2", $fileNew2);
    $sql->bindParam(":image3", $fileNew3);
    $sql->bindParam(":image4", $fileNew4);
    $sql->execute();

    if ($sql) {
        $_SESSION['success'] = "ข้อมูลถูกเพิ่มเรียบร้อยแล้ว";
        header("location: admin.php");
    } else {
        $_SESSION['error'] = "ไม่สามารถเพิ่มข้อมูลได้";
        header("location: admin.php");
    }
}
?>
