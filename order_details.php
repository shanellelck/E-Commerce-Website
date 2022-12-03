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
    }else{
        $user_id ='';
        header('location:index.php');
    }

   
?>


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
        <h3>Order Status:</h3> <?= $order_status?> <p>&nbsp; &nbsp; &nbsp;&nbsp;&nbsp;</p> <h3>Change Order Status</h3>
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