<?php 

    require_once('../dbcon.php');

    if (isset($_REQUEST['btn_edit'])) {
        try {
            $id = $_GET['id'];
            $price = $_REQUEST['price'];

            if (empty($price)) {
                $errorMsg = "Please Enter price";
            } 

            if (!isset($errorMsg)) {

                $sql = "UPDATE tblproduct SET price = :fprice WHERE id = :fid";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':fid',$id);
                $stmt->bindParam(':fprice',$price);

                if ($stmt->execute()) {
                    $editMsg = "Edit successfully...";
                    header('refresh:2;./admin/product/admin_page.php');
                }
            }

        } catch(PDOException $e) {
            $e->getMessage();
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body>
    

    <div class="container text-center">
        <h1>Edit product</h1>
        <?php 
            if(isset($errorMsg)) {
        ?>
            <div class="alert alert-danger">
                <strong><?php echo $errorMsg; ?></strong>
            </div>
        <?php } ?>

        <?php 
            if(isset($editMsg)) {
        ?>
            <div class="alert alert-success">
                <strong><?php echo $editMsg; ?></strong>
            </div>
        <?php } ?>

        <form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
 
            <div class="form-group">
                <div class="row">
                <label for="name" class="col-sm-3 control-label">Price</label>
                <div class="col-sm-9">
                    <input type="text" name="price" class="form-control" placeholder="Enter price">
                </div>
                </div>
            </div>


            
            <div class="form-group">
                <div class="col-sm-12">
                    <input type="submit" name="btn_edit" class="btn btn-success" value="Edit">
                    <a href="./admin/product/admin_page.php" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>