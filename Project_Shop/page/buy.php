<?php
    require_once("../dbcon.php");
    
    $user = $_GET["user"];
    $date = $_GET["date"];
    $order_code = $_GET["order_code"];
    $price = $_GET["price"];

    try {
        $sql = "INSERT INTO order_product(`user`, `date`, `order_code`, `price`) VALUE (:fuser, :fdate, :forder_code, :fprice)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fuser', $user );
        $stmt->bindParam(':fdate', $date);
        $stmt->bindParam(':forder_code', $order_code);
        $stmt->bindParam(':fprice', $price);
        $stmt->execute();
    }
    catch(PDOException $e) {
        echo $e->getMessage();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<style>
    body{
        margin-top: 2%;
    }
</style>
<body>

<h1 align="center" style = "margin-bottom: 1%">Receipt</h1>

    

    <div class="container">
        <table class="table table-striped table-bordered">
            <tr>
                <td width="30%">User</td>
                <td width="70%"><?php echo $user; ?></td>
            </tr>

            <tr>
                <td width="30%">Date</td>
                <td width="70%"><?php echo $date; ?></td>
            </tr>

            <tr>
                <td width="30%">Order code</td>
                <td width="70%"><?php echo $order_code; ?></td>
            </tr>

            
                
            <tr>
                <td width="30%">Price</td>
                <td width="70%"><?php echo $price; ?> $</td>
            </tr>
        </table>

        <div align = "right" style = "margin-top: 3%">
            <button type="button" class="btn btn-success" onclick="window.location='../index.php'">Return to shop</button>  
            <a href="../index.php?logout='1'"><button style = "margin-left: 3%" type="button" class="btn btn-danger">Logout</button></a>
        </div>
    </div>



    
    
</body>
</html>
