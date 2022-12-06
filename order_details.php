<?php include "header.php" ?>
<?php include "connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php 
    session_start();
   
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
        $order_id = $_GET['order_id'];
        $order_date = $_GET['order_date'];
        $order_status = $_GET['order_status'];
        $delivery_method = $_GET['delivery_method'];
        $customer_id = $_GET['customer_id'];
        $payment_method = $_GET['payment_method'];
        $payment_ref_num = $_GET['payment_ref_num'];
    }else{
        $user_id ='';
        header('location:index.php');
    }
    $SELECT_ITEMS_IN_ORDER = "SELECT * FROM order_contains_items AS O, item AS I, model as M WHERE O.order_id ='$order_id' AND I.Item_ID = O.Item_ID AND I.Model_ID = M.Model_ID;";
    $items_in_order = $conn->query($SELECT_ITEMS_IN_ORDER);
    $SELECT_FINAL_ORDER = "SELECT * FROM order WHERE order_ID ='$order_id';"; 
    $items_in_final_order = mysqli_fetch_assoc($conn->query($SELECT_FINAL_ORDER));
    
?>
<style>
table{
    display: flex; 
    width:auto ;
    align: "right";
    border-collapse: collapse;}

th, td{
    text-align: center;
}
</style>
<div class ="small-container order-details-page">
        <table  align = "right" >
            <tr>
                <th>Product</th>
                <th>Colour</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>   
            
            <?php 
            $total_price ="0";
                while($item = mysqli_fetch_assoc($items_in_order)):
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
                $item_quantity = $item['Quantity_In_Order']; 
                $total_price = $total_price + ($item['Price'] * $item['Quantity_In_Order']);?>
                <td><?= $item_colour?></td>
                <td><?= $item_size?></td>
                <td style="text-align: center"><p class="item-quantity-cart"><?= $item_quantity;?></p></td>
                
                <td  style="text-align: center">$<?= $item['Price'] * $item['Quantity_In_Order'];?></td>
            </tr>     
            <?php endwhile; ?>
            
                <tr>
                    <th >Order Summary</th>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                    <th>  </th>
                </tr>
               
                <?php $tax = $total_price * 0.05 ?>
                <tr>
                    <td style="text-align: left">Subtotal</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center">$<?= $total_price ?></td>
                </tr>
                <tr>
                    <td style="text-align: left">Tax</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align: center">$<?= $tax?></td>
                </tr>
                <?php if( $delivery_method == 'Shipping'): ?>
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
                    <td style="text-align: center">$<?= $total_price + $tax + $delivery_cost?></td>
                </tr>
            
        </table>
</div>

<div class="flex-container">
    <style type = "text/css">
        {
            margin:0;
            padding:0;
            box-sizing: border-box;

        }
        .flex-container{
            width: auto;
            height: auto;
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            justify-content:center;
        }
        .flex-box{
            width: auto;
            height:auto;
            font-size:20px;
            text-align: left;
            border-radius: 20px;
            margin: 10px;
            padding: 15px 10px;
            border: .2rem solid black;

        }
         h3, p{
            display:inline;
        }
    </style>

    <div class = "flex-box">
        <h1 style = "text-align: center">Order Details</h1>
        <h3>Order ID:</h3> <?= $order_id?><br>
        <h3>Customer ID:</h3> <?= $customer_id?><br>
        <h3>Order Date:</h3> <?= $order_date?><br>
        <h3>Delivery Method:</h3> <?= $delivery_method?><br>
        <h3>Payment Method:</h3> <?= $payment_method?><br>
        <h3>Payment Reference Number:</h3> <?= $payment_ref_num?><br>
        <h3>Order Status:</h3> <?= $order_status?> <p>&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;</p> <br><h3>Change Order Status:</h3>
        <form method=post>
            <select name="status">
                <option name = "status" value="change" selected>Change Order Status</option>
                <option name = "status" value="Pending">Pending</option>
                <option name = "status" value="Processing">Processing</option>
                <option name = "status" value="Shipped" >Shipped</option>
                <option name = "status" value="Received" >Received</option>
            </select>
            <button type = "submit" name = "change_status" class = "btn btn-dark my-5">Change Status</button>
        </form>

        <?php
        if(isset($_POST['change_status']) ){
            $status = $_POST['status'];
            $update_status = mysqli_query($conn, "UPDATE orders SET Order_Status='$status' WHERE Order_ID = '$order_id';") or die('query failed');
            $order_status = $status;
           
            header("location:order_details.php?order_status=" .$order_status."&order_date=" .$order_date."&order_id=" .$order_id."&delivery_method=" .$delivery_method."&customer_id=" .$customer_id);
                
               
        }

        ?>

        
            
            
        
        
    </div>
    
</div>

















</body>
</html>