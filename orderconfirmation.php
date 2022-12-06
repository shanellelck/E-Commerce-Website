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
        $clicked_delivery = $_GET['clicked_delivery'];
        $delivery_cost = $_GET['delivery_cost'];

    }else{
        $user_id ='';
        header('location:index.php');
    }
    $SELECT_ITEMS_IN_CART = "SELECT * FROM cart_contains_item AS C, item AS I, model as M WHERE C.Customer_ID ='$user_id' AND I.Item_ID = C.Item_ID AND I.Model_ID = M.Model_ID;";
    $items_in_cart = $conn->query($SELECT_ITEMS_IN_CART);
    $SELECT_FINAL_CART = "SELECT * FROM cart AS C WHERE C.Customer_ID ='$user_id';"; 
    $items_in_final_cart = mysqli_fetch_assoc($conn->query($SELECT_FINAL_CART));
?>
    <h1 class="title">Order Confirmation</h1>
    
    <div class ="small-container order-page">
        <table  align = "right" >
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>   
            
            <?php 
                while($item = mysqli_fetch_assoc($items_in_cart)):
            ?>   
            <tr>
                <td >
                    <div class= "order-info">
                        <img src="<?= $item['Image'];?>"/>
                        <div>
                        <p class="item-name-cart"><?= $item['Name'];?></p>
                        </div>
                    </div>
                </td>
                <?php $item_quantity = $item['Quantity_In_Cart'] ?>
                <td style="text-align: center"><p class="item-quantity-cart"><?= $item['Quantity_In_Cart'];?></p></td>
                
                <td  style="text-align: center">$<?= $item['Price'] * $item['Quantity_In_Cart'];?></td>
            </tr>     
            <?php endwhile; ?>
            
                <tr>
                    <th >Order Summary</th>
                    <th>  </th>
                    <th>  </th>
                </tr>
                <?php $items_in_final_cart['Total_Price'] ?>
                <?php $tax = $items_in_final_cart['Total_Price'] * 0.05 ?>
                <tr>
                    <td style="text-align: left">Subtotal</td>
                    <td></td>
                    <td >$<?= $items_in_final_cart['Total_Price'] ?></td>
                </tr>
                <tr>
                    <td style="text-align: left">Tax</td>
                    <td></td>
                    <td >$<?= $tax?></td>
                </tr>
                <?php if(($_POST['delivery_method']) == 'Shipping'): ?>
                    <tr>
                        <?php $delivery_cost = 5 ?>
                        <td style="text-align: left">Delivery Fees</td>
                        <td></td>
                        <?php $delivery_cost = 5?>
                        <td style="text-align: right">$<?= $delivery_cost?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td style="text-align: left">Total</td>
                    <td></td>
                    <td >$<?= $items_in_final_cart['Total_Price'] + $tax + $delivery_cost?></td>
                </tr>
            
        </table>
        
        <div class="flex-container">
            <div class = "flex-box">
                <h2>Your order has been placed successfully!</h2>
                
                <?php 
                $date = date("Y/m/d");
                $insert_order = mysqli_query($conn, "INSERT INTO `orders`(Order_Date, Delivery_Method, Delivery_Cost, Customer_ID) VALUES ('$date','$clicked_delivery', '$delivery_cost','$user_id' )") or die('query failed');

                $select_order =  mysqli_query($conn, "SELECT Order_ID FROM `orders` WHERE	Customer_ID = '$user_id' AND	Order_Date = '$date' Order by Order_ID desc limit 1") or die('query failed');
                $fetch_order = mysqli_fetch_assoc($select_order);
                $order_id = $fetch_order['Order_ID'];
                $insert_payment = mysqli_query($conn, "INSERT INTO `payment`(Order_ID, Payment_Date, Customer_ID) VALUES ('$order_id', '$date','$user_id' )") or die('query failed');
                

                $SELECT_I_IN_CART = "SELECT * FROM cart_contains_item AS C, item AS I, model as M WHERE C.Customer_ID ='$user_id' AND I.Item_ID = C.Item_ID AND I.Model_ID = M.Model_ID;";
                $i_in_cart = $conn->query($SELECT_I_IN_CART); 
                while($item = mysqli_fetch_assoc($i_in_cart)):
                    $item_id = $item['Item_ID'];
                    $item_qty = $item['Quantity_In_Cart'];
                    $insert_order_contains = mysqli_query($conn, "INSERT INTO order_contains_items VALUES ('$order_id', '$item_id', '$item_qty');");
                    
                endwhile;

                echo "Order Reference Number: $order_id";
                $empty_cart_contains_item = mysqli_query($conn,"DELETE  FROM cart_contains_item WHERE  Customer_ID = '$user_id';");
                $empty_cart = mysqli_query($conn,"DELETE  FROM cart WHERE  Customer_ID = '$user_id';");
                
                ?>
            </div>  
        </div>
    </div>
</body>
</html>


