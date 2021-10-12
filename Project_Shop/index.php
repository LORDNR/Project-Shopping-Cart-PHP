<?php

  session_start();
  require_once('dbcontroller.php');
  require_once('server.php');
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

  $db_handle = new DBcontroller();

  if(!empty($_GET["action"])) {
    switch($_GET["action"]) {
      case "add":
        if(!empty($_POST["quantity"])) {
          $productByCode = $db_handle->runQuery("SELECT * FROM tblproduct WHERE code='" . $_GET["code"] . "'");
          $itemArray = array($productByCode[0]["code"]=>(array('name'=>$productByCode[0]["name"],
                                                       'code'=>$productByCode[0]["code"],
                                                       'quantity'=>$_POST["quantity"],
                                                       'price'=>$productByCode[0]["price"],
                                                       'image'=>$productByCode[0]["image"],
                                                       'type_id'=>$productByCode[0]["type_id"],)));
        }

        if(!empty($_SESSION["cart_item"])) {
          if(in_array($productByCode[0]["code"], array_keys($_SESSION["cart_item"]))) {
            foreach($_SESSION["cart_item"] as $k => $v) {
              if($productByCode[0]["code"] == $k) {
                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                  $_SESSION["cart_item"][$k]["quantity"] = 0;
                }
                $_SESSION["cart"][$k]["quantity"] += $_POST["quantity"];
              }
            }
          } else {
            $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
            }
        } else {
          $_SESSION["cart_item"] = $itemArray;
          }
      break;
      case "remove":
        if(!empty($_SESSION["cart_item"])) {
          foreach($_SESSION["cart_item"] as $k => $v) {
            if($_GET["code"] == $k)
              unset($_SESSION["cart_item"][$k]);
            
            if(empty($_SESSION["cart_item"])) 
              unset($_SESSION["cart_item"]);
          }
        }
      break;
      case "empty":
        unset($_SESSION["cart_item"]);
      break;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    
    <title>Shopping</title>
    <link rel="stylesheet" href="./assets/css/style.css" />
    <link rel="stylesheet" href="./assets/css/style4.css">
    
  </head>
  <body>


    <!-- Navbar -->
    <header>
      <?php if (isset($_SESSION['username'])) : ?>
      <H2 class="t-head"><?php echo $_SESSION['username']; ?></H2>
      <nav>
      
        <ul class="nav__links">
          <li>
            <a href="#">home</a>
          </li>
          <li>
            
          </li>
        </ul>
      </nav>
      <a class="btn2" href="index.php?logout='1'"><button class="button1">Logout</button></a>
      <?php endif ?>
  </header>
  <!--END Navbar -->








  <!-- Shopping-cart -->
  <main>
    <div id="shopping-cart">
      <div class="txt-heading">Shopping-cart</div>
      <a id="btnEmpty" href="index.php?action=empty">Empty Cart</a>

      <?php
        if (isset($_SESSION["cart_item"])) {
          $total_quantity = 0;
          $total_price = 0;
        
      ?>
      <table class="tbl-cart" cellpadding="10" cellspacing="1">
        <tbody>
          <tr>
            <th style="text-align: left;">Name</th>
            <th style="text-align: left;">Code</th>
            <th style="text-align: right;" width="5%">Quantity</th>
            <th style="text-align: right;" width="10%">Unit price</th>
            <th style="text-align: right;" width="10%">Price</th>
            <th style="text-align: center;"width="5%">Remove</th>
          </tr>

          <?php
            foreach($_SESSION["cart_item"] as $item) {
              $item_price = $item["quantity"] * $item["price"];
          ?>

          <tr>
            <td>
              <img src="<?php echo "./images/product-images/" . $item["image"];  ?>"  class="cart-item-image" alt="" >
              <?php echo $item["name"]; ?>
            </td>
            <td><?php echo  $item["code"]; ?></td>
            <td style="text-align: right;"><?php echo $item["quantity"]; ?></td>
            <td style="text-align: right;"><?php echo "$" . $item["price"]; ?></td>
            <td style="text-align: right;"><?php echo "$" . number_format($item["price"]*$item["quantity"] , 2); ?></td>
            <td style="text-align: center">
              <a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction">
                <img width="20px" src="./images/images/delete.png" alt="remove item">
              </a>
            </td>
          </tr>
          
          <?php
            $total_quantity += $item["quantity"];
            $total_price += ($item["price"] * $item["quantity"]);

            }
          ?>


          <tr>
            <td colspan="2" align="right">Total : </td>
            <td align="right"><?php echo $total_quantity;  ?></td>
            <td align="right" colspan="2"><?php echo "$" . number_format($total_price, 2);  ?></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      <?php
        } else {
      ?>
      <div class="no-records">Your Cart Is Empty</div>

      <?php
  }
?>
    </div>

<!--END Shopping-cart -->
    


    





<!-- BUY -->


<?php
  $date = date("Y-m-d");
?>

<div class="btnbuy">
<a class="btn2" href="<?php echo "./page/buy.php?user=" . $_SESSION['username'] . "&date=" . $date . "&order_code=" . rand(1,1000000000) . "&price=" . $total_price?>">
    <button class="buy">
      BUY
    </button>
  </a>
</div>




















    


    <!-- Product -->

    <div id="product-grid">
      <div class="txt-heading">Products</div>
      
        <script>
          function del() {

          alert("Confirm Delete.");
        }
        </script>

      <?php
        $select_stmt = $conn->prepare("SELECT * FROM tblproduct");
        $select_stmt->execute();

        while ($row = $select_stmt->fetch(PDO::FETCH_ASSOC)) {
      ?>
      <div class="product-item">
        <form action="index.php?action=add&code=<?php echo $row["code"]; ?>" method="post" >

          <div class="product-image">
            <img class="image-full" src="<?php echo "./images/product-images/" . $row["image"]; ?>" alt="images">
          </div>
          <div class="product-title-footer">
            <div class="product-title"><?php echo $row["name"]; ?></div>
            <div class="product-price">$<?php echo $row["price"]; ?></div>
            <div class="cart-action">
              <input type="text" class="product-quantity" name="quantity" value="1" size="2">
              <input type="submit" class="btnAddAction"  value="Add to cart" >
            </div>
          </div>
        </form>
      </div>

<?php
        }

?>
<!--END Product -->
</main>

<footer>

</footer>



    </div>
  </body>
</html>
