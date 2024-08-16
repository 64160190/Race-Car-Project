<?php 
    session_start();
    require_once "config/db.php";
    if (isset($_POST['submit'])) {
        $pro_id = $_POST['pro_id'];
        $pro_name = $_POST['pro_name'];
        $detail = $_POST['detail'];
        $type_id = $_POST['type_id'];
        $type_name = $_POST['type_name'];
        $price = $_POST['price'];
        $amount = $_POST['amount'];
        $machine = $_POST['machine'];
        $image = $_FILES['image'];

        $allow = array('jpg','jpeg','png');
        $extension = explode(".",$image['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt;
        $filePath = "uploads/".$fileNew;
        
        if(in_array($fileActExt, $allow)) {
            if ($image['size'] > 0 && $image['error'] == 0) {
                if (move_uploaded_file($image['tmp_name'],$filePath)){
                    $sql = $conn->prepare("INSERT INTO promodel(pro_id, pro_name, detail, type_id, type_name, price, amount, machine, image) VALUES(:pro_id, :pro_name, :detail, :type_id, :type_name, :price, :amount, :machine ,:image)");
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
                        $_SESSION['success'] = "Data has been inserted suuuccesfully";
                        header("location: admin.php");
                    } else {
                        $_SESSION['error'] = "Data has not been inserted suuuccesfully";
                        header("location: admin.php");
                    }
                }
            }
        }
    }
?>