<?php
    require_once("../../dbcon.php");

    $id = $_POST["id"];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['PASSWORD'];
    $status = $_POST['status'];

    if($id!='') {
        $sql = "UPDATE user SET username='$username', email='$email', PASSWORD='$password', status='$status' WHERE id=$id";
    }else {
        $sql = "INSERT INTO user (username, email, PASSWORD, status)
        VALUES ('$username', '$email', '$password', '$status')";
    }

    $stmt = $conn->prepare($sql);

   
    

    if ($stmt->execute()) {
        echo "Complete";
    }else {
        echo "error";
    }
?>