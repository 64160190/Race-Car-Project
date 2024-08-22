<?php
session_start();
require_once 'config/db.php';

if (isset($_POST['submit'])) {
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

    $upload = $_FILES['image']['name'];
    $upload2 = $_FILES['image2']['name'];
    $upload3 = $_FILES['image3']['name'];
    $upload4 = $_FILES['image4']['name'];

    $allow = array('jpg', 'jpeg', 'png');

    function uploadFile($file, $allow, $folder) {
        if ($file['name'] != '') {
            $extension = explode(".", $file['name']);
            $fileActExt = strtolower(end($extension));
            if (in_array($fileActExt, $allow)) {
                $fileNew = rand() . "." . $fileActExt;
                $filePath = $folder . "/" . $fileNew;
                if ($file['size'] > 0 && $file['error'] == 0) {
                    move_uploaded_file($file['tmp_name'], $filePath);
                    return $fileNew;
                }
            }
        }
        return '';
    }

    $fileNew = uploadFile($image, $allow, "uploads");
    $fileNew2 = uploadFile($image2, $allow, "uploads");
    $fileNew3 = uploadFile($image3, $allow, "uploads");
    $fileNew4 = uploadFile($image4, $allow, "uploads");

    $fuel_type = isset($_POST['fuel_type']) ? $_POST['fuel_type'] : null;
    $seats = isset($_POST['seats']) ? $_POST['seats'] : null;
    $registration_type = isset($_POST['registration_type']) ? $_POST['registration_type'] : null;
    $spare_key = isset($_POST['spare_key']) ? $_POST['spare_key'] : null;
    $main_warranty = isset($_POST['main_warranty']) ? $_POST['main_warranty'] : null;
    $color = isset($_POST['color']) ? $_POST['color'] : null;
    $registration_date = isset($_POST['registration_date']) ? $_POST['registration_date'] : null;
    $latest_mileage = isset($_POST['latest_mileage']) ? $_POST['latest_mileage'] : null;
    $license_plate = isset($_POST['license_plate']) ? $_POST['license_plate'] : null;
    $tax_expiry_date = isset($_POST['tax_expiry_date']) ? $_POST['tax_expiry_date'] : null;

    // Ensure that required fields are not null
    if ($fuel_type === null || $seats === null || $registration_type === null) {
        $_SESSION['error'] = "ข้อมูลที่สำคัญบางอย่างขาดหายไป";
        header("location: admin.php");
        exit();
    }

    // Get type_name from type_id
    $typeStmt = $conn->prepare("SELECT type_name FROM type WHERE type_id = :type_id");
    $typeStmt->bindParam(':type_id', $type_id);
    $typeStmt->execute();
    $type = $typeStmt->fetch(PDO::FETCH_ASSOC);
    $type_name = $type ? $type['type_name'] : '';

    try {
        // Start transaction
        $conn->beginTransaction();

        // Insert into promodel
        $sql = $conn->prepare("INSERT INTO promodel (pro_name, detail, type_id, type_name, price, amount, machine, image, image2, image3, image4) VALUES (:pro_name, :detail, :type_id, :type_name, :price, :amount, :machine, :image, :image2, :image3, :image4)");
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

        $pro_id = $conn->lastInsertId();

        // Insert into car_details
        $sql = $conn->prepare("INSERT INTO car_details (pro_id, fuel_type, seats, registration_type, spare_key, main_warranty, color, registration_date, latest_mileage, license_plate, tax_expiry_date) VALUES (:pro_id, :fuel_type, :seats, :registration_type, :spare_key, :main_warranty, :color, :registration_date, :latest_mileage, :license_plate, :tax_expiry_date)");
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
        $sql->execute();

        // Commit transaction
        $conn->commit();

        $_SESSION['success'] = "ข้อมูลถูกเพิ่มเรียบร้อยแล้ว";
        header("location: admin.php");
    } catch (Exception $e) {
        // Rollback transaction
        $conn->rollBack();
        $_SESSION['error'] = "ไม่สามารถเพิ่มข้อมูลได้: " . $e->getMessage();
        header("location: admin.php");
    }
}
?>
