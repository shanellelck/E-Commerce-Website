<?php include "header.php" ?>
<?php include "connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style-checkout.css">

</head>
<body>
<?php 
    session_start();
   
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $order_id = $_GET['order_id'];
        $delivery_cost = $_GET['delivery_cost'];

    }else{
        $user_id ='';
        header('location:index.php');
    }

    $SELECT_ITEMS_IN_CART = "SELECT * FROM cart_contains_item AS C, item AS I WHERE C.Customer_ID ='$user_id' AND I.Item_ID = C.Item_ID;";
    $items_in_cart = $conn->query($SELECT_ITEMS_IN_CART);
    $SELECT_FINAL_CART = "SELECT * FROM cart AS C WHERE C.Customer_ID ='$user_id';"; 
    $items_in_final_cart = mysqli_fetch_assoc($conn->query($SELECT_FINAL_CART));
?>
    <h1 class="title">Payment</h1>
    
    <div class ="small-container order-page">
        <table align = "right" >
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>   
            
            <?php 
                while($item = mysqli_fetch_assoc($items_in_cart)):
            ?>   
            <tr>
                <td>
                    <div class= "order-info">
                        <img src="<?= $item['Image'];?>"/>
                        <div>
                        <p class="item-name-cart"><?= $item['Name'];?></p>
                        </div>
                    </div>
                </td>
                <?php $item_quantity = $item['Quantity'] ?>
                <td><p class="item-quantity-cart"><?= $item['Quantity'];?></p></td>
                
                <td>$<?= $item['Price'] * $item['Quantity'];?></td>
            </tr>     
            <?php endwhile; ?>
            
            <tr>
                    <th>Order Summary</th>
                    <th>  </th>
                    <th>  </th>
                </tr>
                <?php $items_in_final_cart['Total_Price'] ?>
                <?php $tax = $items_in_final_cart['Total_Price'] * 0.05 ?>
                <tr>
                    <td style="text-align: left">Subtotal</td>
                    <td></td>
                    <td>$<?= $items_in_final_cart['Total_Price'] ?></td>
                </tr>
                <tr>
                    <td style="text-align: left">Tax</td>
                    <td></td>
                    <td>$<?= $tax?></td>
                </tr>
                <tr>
                    <td style="text-align: left">Delivery Fees</td>
                    <td></td>
                    <td>$<?= $delivery_cost?></td>
                </tr>
                <tr>
                    <td style="text-align: left">Total</td>
                    <td></td>
                    <td>$<?= $items_in_final_cart['Total_Price'] + $tax + $delivery_cost?></td>
                </tr>
        </table>
       
        
        <div class="flex-container">
            <div class = "flex-box">
                <h2>Your order has been placed!</h2>
                
                <?php echo "Order Reference Number: $order_id";
                
                $empty_cart_contains_item = mysqli_query($conn,"DELETE  FROM cart_contains_item WHERE  Customer_ID = '$user_id';");
                $empty_cart = mysqli_query($conn,"DELETE  FROM cart WHERE  Customer_ID = '$user_id';");
                
                ?>
            </div>  
        </div>
    </div>
</body>
</html>