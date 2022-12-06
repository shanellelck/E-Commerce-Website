<?php 
    include 'header.php' ;
   include 'connection.php';
   include 'admin_header.php';
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style-dashboard.css">

    <title>Admin Dashboard</title>

</head>
<body>
<div class="dashboard">
    <h1 class="title">Dashboard</h1>
        <div class="box-container">
            
            <div class="box">
                <?php 
                $select_customers = mysqli_query($conn, "SELECT * FROM `customer` ");
                $number_of_customers = mysqli_num_rows($select_customers);
                ?>
                <h3><?php echo $number_of_customers; ?></h3>
                <h2>Customers</h2>
                <a href="customer_list.php" class="btn">View customers</a>
            </div>

            <div class="box">
                <?php 
                $select_suppliers = mysqli_query($conn, "SELECT * FROM `supplier`");
                $number_of_suppliers = mysqli_num_rows($select_suppliers);
                ?>
                <h3><?php echo $number_of_suppliers; ?></h3>                
                <h2>Suppliers</h2>
                <a href="supplier_list.php" class="btn">View Suppliers</a>
            </div>

            <div class="box">
                <?php 
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`");
                $number_of_orders = mysqli_num_rows($select_orders);
                ?>
                <h3><?php echo "$number_of_orders"; ?></h3> 
                <h2>Orders</h2>
                <a href="order_list.php" class="btn">View Orders</a>               
            </div>

        
        </div>

</div>

</body>
</html>