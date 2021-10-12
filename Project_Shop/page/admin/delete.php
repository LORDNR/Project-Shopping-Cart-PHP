<?php
    require_once("../../dbcon.php");

    $id = $_POST["id"];
    $sql = "DELETE FROM user where id = :fid"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bindParam(':fid', $id , PDO::PARAM_INT); 
    $stmt->execute(); 

?>