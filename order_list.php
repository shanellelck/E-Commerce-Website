<?php include "header.php" ?>
<?php include "connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style-list.css">

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

    $select_orders = "SELECT * FROM orders ORDER BY order_id DESC;";
    $orders = $conn->query($select_orders);
?>


  
    <div class ="small-container cart-page">
    <h1 class="title">Orders</h1>
    <table class="order-list">
        <tr>
            <th><p>Order ID<p></th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Delivery Method</th>
            <th>Customer ID</th>
            <th>Payment Method</th>
            <th>Payment Reference Number</th>
            <th style="text-align: center">Details</th>
        </tr>   
        
        <?php 
            while($order = mysqli_fetch_assoc($orders)):
        ?>   
        <tr>
        
            <?php 
            $order_id = $order['Order_ID'];
            $order_date = $order['Order_Date']; 
            $order_status = $order['Order_Status']; 
            $delivery_method = $order['Delivery_Method']; 
            $customer_id = $order['Customer_ID']; 
            $select_payments = "SELECT * FROM payment where  Order_ID = '$order_id'";
            $payments = $conn->query($select_payments);
            $payment = mysqli_fetch_assoc($payments);
            $payment_method = $payment['Payment_Type'];
            $payment_ref_num = $payment['Payment_Ref_Num'];
            ?>
           
            <td> <?= $order_id?></td>
            <td> <?= $order_date?></td>
            <td> <?= $order_status?></td>
            <td> <?= $delivery_method?></td>
            <td style="text-align: center"> <?= $customer_id?></td>
            <td><?= $payment_method?></td>
            <td><?= $payment_ref_num?></td>
            <td style="text-align: center"> 
            <a href="order_details.php?order_id=<?php echo $order_id ?> 
            & customer_id=<?php echo $customer_id ?>
            & order_date=<?php echo $order_date ?>
            & order_status=<?php echo $order_status ?>
            & payment_method=<?php echo $payment_method ?>
            & payment_ref_num=<?php echo $payment_ref_num ?>
            & delivery_method=<?php echo $delivery_method ?>" button type="button" class="btn">View</button></a>
            </td>
            
        </tr>
        <?php endwhile; ?>
    </table>
    </div>
</body>
</html>