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
    }else{
        $user_id ='';
        header('location:index.php');
    }
?>
    <h1 class="title">Admin Page</h1>
    <div class ="small-container order-page">
    <a href="customer_list.php" button type="button" class="btn">Customers</button></a>
    <a href="order_list.php" button type="button" class="btn">Orders</button></a>

    </div>
</body>
</html>