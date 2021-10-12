<?php

    session_start();
    
    require_once('dbcon.php');
    

    //  check User
    if (!isset($_SESSION['username'])) {
        $_SESSION['msg'] = "You must log in first";
        header('location: ./page/login.php');
    }

    if (isset($_GET['logout'])) {
        session_destroy();
        unset($_SESSION['username']);
        header('location: ./page/login.php');
    }
    
    $sql = "SELECT * FROM user" ;
    $stmt = $conn->prepare($sql);
    
    $stmt->execute(); 

    $result = $stmt->fetchALL();

    $conn=null;

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/style3.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous"></script>
    
</head>
<body>



    <!-- Navbar -->
    <header>
        <?php if (isset($_SESSION['username'])) : ?>
        <H2 class="t-head"><?php echo $_SESSION['username']; ?></H2>

        <nav>
            <ul class="nav__links">
                <li>
                    <a href="#">User</a>
                </li>
                <li>
                    <a  href="./page/admin/product/admin_page.php">Product</a>
                </li>
            </ul>
      </nav>

      <a class="btn2" href="index.php?logout='1'"><button class="button1">Logout</button></a>
      <?php endif ?>
  </header>
  <!--END Navbar -->

  
    <main class="ad-main">
        <div class="container">
            <div class="d-add" align="right">
                <button name="add" id="add" data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-success">Add</button>
            </div>
            <br> 
            <table class="table table-striped table-bordered">
                <thead >
                    <tr>
                        <th width="70%">Username</th>
                        <th width="10%">View</th>
                        <th width="10%">Edit</th>
                        <th width="10%">Delete</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                        for($i=0; $i<count($result); $i++) {
                    ?>

                    <tr>
                        
                        <td><?php echo $result[$i]["username"]; ?></td>
                        
                        <td>
                            <button type="button" class="btn btn-info view_data" id="<?php echo $result[$i]["id"] ?>">View</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-success edit_data"  id="<?php echo $result[$i]["id"] ?>">Edit</button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger delete_data" id="<?php echo $result[$i]["id"] ?>">Delete</button>
                        </td>
                        
                    </tr>

                    <?php
                        }
                        $con = null;
                    ?>
                </tbody>
            </table>

            <?php require("./page/admin/view.php"); ?>
            <?php require("./page/admin/insertModal.php"); ?>
        </div>
    </main>
</body>
    
    
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#insert-form").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url:"./page/admin/insert.php",
                    method:"post",
                    data:$("#insert-form").serialize(),
                    beforeSend:function() {
                        $('#insert').val("Insert..");
                    },
                    success:function(data) {
                        $("#insert-form")[0].reset();
                        $("#addModal").modal('hide');
                        location.reload();
                    }
                });
            });

            $(".delete_data").click(function() {
                var uid = $(this).attr("id");
                var status=confirm("Are you delete?");
                if(status) {
                    $.ajax({
                    url:"./page/admin/delete.php",
                    method:"post",
                    data:{id:uid},
                    success:function(data) {
                        location.reload();
                    }
                });
                }
            });

            $(".view_data").click(function() {
                var uid = $(this).attr("id");
                $.ajax({
                    url:"./page/admin/select.php",
                    method:"post",
                    data:{id:uid},
                    success:function(data) {
                        $('#detail').html(data);
                        $('#dataModal').modal('show');
                    }
                });
            });

            $(".edit_data").click(function() {
                var uid = $(this).attr("id");
                $.ajax({
                    url:"./page/admin/fetch.php",
                    method:"post",
                    data:{id:uid},
                    dataType:"json",
                    success:function(data) {
                        $('#id').val(data.id);
                        $('#username').val(data.username);
                        $('#email').val(data.email);
                        $('#PASSWORD').val(data.PASSWORD);
                        $('#status').val(data.status);
                        $('.sub').val("Update");
                        $('#addModal').modal("show");
                       
                    }
                });
            });
        });
    </script>
    

</html>