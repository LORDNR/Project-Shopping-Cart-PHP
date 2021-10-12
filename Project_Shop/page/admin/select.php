<?php
    require_once("../../dbcon.php");

    $id = $_POST["id"];

    $sql = "SELECT * FROM user WHERE id = :fid" ;
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fid', $id);
    
    $stmt->execute(); 
    $result = $stmt->fetchALL();

    $conn=null;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<table class="table table-striped table-bordered">
        <thead >
           
        </thead>


        <tbody>
            <?php
                for($i=0; $i<count($result); $i++) {
            ?>

            

            <tr>
                <td width="30%">Username</td>
                <td width="70%"><?php echo $result[$i]["username"]; ?></td>
            </tr>

            <tr>
                <td width="30%">Email</td>
                <td width="70%"><?php echo $result[$i]["email"]; ?></td>
            </tr>

            <tr>
                <td width="30%">Password</td>
                <td width="70%"><?php echo $result[$i]["PASSWORD"]; ?></td>
            </tr>

            <tr>
                <td width="30%">Status</td>
                <td width="70%"><?php echo $result[$i]["status"]; ?></td>
            </tr>


            <?php
                }
                $con = null;
            ?>
        </tbody>
    </table>
</body>
</html>