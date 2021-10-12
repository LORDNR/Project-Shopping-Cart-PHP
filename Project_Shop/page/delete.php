<?php 
    require_once('../dbcon.php'); 

    // echo '<pre>';
    // print_r($_GET);
    // echo '</pre>';

    $id = $_GET["id"]; 

        $sql = "SELECT * FROM tblproduct WHERE id = :bp_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':bp_id' => $_GET['id']));
        $imgRow = $stmt->fetch(PDO::FETCH_ASSOC);
        unlink("../images/product-images/" . $imgRow['image']) ;






    try { 
        $sql = "DELETE FROM tblproduct  where id = :bp_id"; 
        $stmt = $conn->prepare($sql); 
        $stmt->bindParam('bp_id', $id , PDO::PARAM_INT); 
        $stmt->execute(); 
        require_once('../assets/html/del_success.html');
        header('refresh:2; ./admin/product/admin_page.php');
    }catch(PDOException $e) {
        echo "<BR> $sql <BR>" . $e->get_message();
        header('refresh:2; ./admin/product/admin_page.php');
    }
    $conn = null;
?>

