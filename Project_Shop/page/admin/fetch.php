<?php
    require_once("../../dbcon.php");
    $id = $_POST["id"];
    // echo $id;

    try {

    
    $sql = "SELECT * FROM user WHERE id = :fid" ;
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fid', $id);
    
    $stmt->execute(); 
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    } 
    catch(PDOException $e) {
        $e->getMessage();
    }
    

    echo json_encode($result);

?>


