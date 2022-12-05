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

    $SELECT_ITEMS_IN_CART = "SELECT * FROM cart_contains_item AS C, item AS I WHERE C.Customer_ID ='$user_id' AND I.Item_ID = C.Item_ID AND I.Model_ID = M.Model_ID;;";
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
                <td >
                    <div class= "order-info">
                        <img src="<?= $item['Image'];?>"/>
                        <div>
                        <p class="item-name-cart"><?= $item['Name'];?></p>
                        </div>
                    </div>
                </td>
                <?php $item_quantity = $item['Quantity'] ?>
                <td style="text-align: center"><p class="item-quantity-cart"><?= $item['Quantity_In_Cart'];?></p></td>
                
                <td  style="text-align: center">$<?= $item['Price'] * $item['Quantity_In_Cart'];?></td>
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
                <form method="POST">
                    <h2>Payment Options</h2>
                    <div>
                        <div>
                        <input type = "radio" name = "payment_method" value = "cash">Cash
                        </div>
                        <div>
                            <input type = "radio" name = "payment_method" value = "online">Credit/Debit
                        </div>
                        <button type = "submit" name = "confirm_payment" class = "btn btn-dark my-5">Confirm</button>
                    </div>
                </form>      
                    
                <?php
                if(isset($_POST['payment_method'])){
                
                    $online = "online";
                    $cash = "cash";
                    $clicked_payment = $_POST['payment_method'];
                    if($clicked_payment == $online){
                        ?>
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
                    }else if ($clicked_payment == $cash){
                        echo "Please pay in-store or upon delivery!";
                    }?>
                    <style>
                    .anybutton {
                    
                    width:100px;
                    height:40px;
                    position: fixed;
                
                    background: black; 
                    padding: 10px 20px;
                    border-radius: 4px;
                    bottom: 10px;
                    right: 20px;
                    color: white;
                    }
                  
                    </style>
                      
                    <a href="orderconfirmation.php?order_id=<?php echo $order_id ?>   & delivery_cost=<?php echo $delivery_cost ?>">
                    <button type="button" class="btn">Place Order</button>
                    </a>

                    <?php   
                    $payment_date = date("Y/m/d");
                    $insert_order = mysqli_query($conn, "INSERT INTO `payment`(Order_ID, Payment_Type, Payment_Date, Customer_ID) VALUES ( '$order_id','$clicked_payment', '$payment_date','$user_id' )") or die('query failed');
                   
                }?>
            </div>  
        </div>     
    </div>
</body>
</html>