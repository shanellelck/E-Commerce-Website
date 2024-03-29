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
    }else{
        $user_id ='';
        header('location:index.php');
    }

    $SELECT_ITEMS_IN_CART = "SELECT * FROM cart_contains_item AS C, item AS I, model as M WHERE C.Customer_ID ='$user_id' AND I.Item_ID = C.Item_ID AND I.Model_ID = M.Model_ID;";
    $items_in_cart = $conn->query($SELECT_ITEMS_IN_CART);
    $SELECT_FINAL_CART = "SELECT * FROM cart AS C WHERE C.Customer_ID ='$user_id';"; 
    $items_in_final_cart = mysqli_fetch_assoc($conn->query($SELECT_FINAL_CART));
?>
    <h1 class="title">Checkout Page</h1>
    
    <div class ="small-container order-page">
        <table  align = "right" >
            <tr>
                <th>Product</th>
                <th>Colour</th>
                <th>Size</th>
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
                <?php 
                $item_colour = $item['Colour'];
                $item_size = $item['Size'];
                $item_quantity = $item['Quantity_In_Cart'] ?>
                <td><?= $item_colour?></td>
                <td><?= $item_size?></td>
                <td style="text-align: center"><p class="item-quantity-cart"><?= $item['Quantity_In_Cart'];?></p></td>
                
                <td  style="text-align: center">$<?= $item['Price'] * $item['Quantity_In_Cart'];?></td>
            </tr>     
            <?php endwhile; ?>
            
                <tr>
                    <th >Order Summary</th>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                </tr>
                <?php $items_in_final_cart['Total_Price'] ?>
                <?php $tax = $items_in_final_cart['Total_Price'] * 0.05 ?>
                <tr>
                    <td style="text-align: left">Subtotal</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center">$<?= $items_in_final_cart['Total_Price'] ?></td>
                </tr>
                <tr>
                    <td style="text-align: left">Tax</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center">$<?= $tax?></td>
                </tr>
                <?php if(($_POST['delivery_method']) == 'Shipping'): ?>
                    <tr>
                        <?php $delivery_cost = 5 ?>
                        <td style="text-align: left">Delivery Fees</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php $delivery_cost = 5?>
                        <td style="text-align: center">$<?= $delivery_cost?></td>
                    </tr>
                <?php endif; ?>
                <tr>
                    <td style="text-align: left">Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center">$<?= $items_in_final_cart['Total_Price'] + $tax + $delivery_cost?></td>
                </tr>
            
        </table>

        
        
        <div class="flex-container">
        
            <div class = "flex-box">
                <form method="POST">
                    <h2>Delivery Options</h2>
                    <div>
                        <input type = "radio" name = "delivery_method" value = "Pick-up">Pick-up
                    </div>
                    <div>
                        <input type = "radio" name = "delivery_method" value = "Shipping">Shipping
                    </div>
                        <button type = "submit" name = "confirm_delivery" class = "btn btn-dark my-5">Confirm</button>
                </form>
              
                <?php 
                if(isset($_POST['delivery_method']) )
                {
                    $select_user = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID = '$user_id'") or die('query failed');
                    if(mysqli_num_rows($select_user) > 0){
                        $fetch_profile = mysqli_fetch_assoc($select_user);
                    }
                    
                    $shipping = "Shipping";
                    $pickup = "Pick-up";
                    $clicked_delivery = $_POST['delivery_method'];
                    if(($_POST['delivery_method']) == $shipping){
                       
                        $delivery_cost = 5;
                        ?>
                    <h2>Shipping Address</h2>
                    <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['Street_Num'] == ''){echo 'Please enter your address!';}
                        else{echo  ' ' .$fetch_profile['Street_Num']. ', ' .$fetch_profile['Street_Name']. ', ' .
                        $fetch_profile['City']. ', ' .$fetch_profile['Province']. ', ' .$fetch_profile['Postal_Code']. ', ' .$fetch_profile['Country'];};?></span></p>
                    <a href="update_address.php" class="btn"> update address</a>
                    <br>
                    <?php
                    }else if (($_POST['delivery_method']) == $pickup){
                        ?>
                        <h2>Pick-up Address</h2>
                        <p><i class="fas fa-map-marker-alt"></i><span><?php echo " 3625 Shaganappi Trail NW, Calgary, AB T3A 0E2";?></span></p>
                        <?php
                        $delivery_cost = 0;
                    }
                   
                 
                } ?>
                <h2>Payment Details</h2>
                <div class="inputBox">
                            <div>
                                <input type="text" name = "card-num" placeholder="Card Number" class="box">
                            </div>
                            <br>
                            <div>
                                <input type="month" name = "expiration-date" placeholder="Expiration Date" class="box">
                            </div>
                            <br>
                            <div>
                                <input type="text" name = "cvc" placeholder="CVC" class="box">
                            </div>
                             <br>  
                        </div>
                <?php       
                if(isset($_POST['delivery_method']) )
                {    
                        ?>
                    <a href="orderconfirmation.php?clicked_delivery=<?php echo $clicked_delivery ?>   & delivery_cost=<?php echo $delivery_cost ?>">
                    <button type="button" class="btn">Place Order</button>
                    </a>
                    <?php
                }?>
                   
            </div>
        </div>
    </div>
</body>
</html>


