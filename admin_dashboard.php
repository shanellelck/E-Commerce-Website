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
    <h1 class="title">dashboard</h1>
        <div class="box-container">
            
            <div class="box">
                <?php 
                $select_customers = mysqli_query($conn, "SELECT * FROM `customer` ");
                $number_of_customers = mysqli_num_rows($select_customers);
                ?>
                <h3><?php echo $number_of_customers; ?></h3>
                <p>Customers</p>
                <a href="customer_list.php" class="btn">view customers</a>
            </div>

            <div class="box">
                <?php 
                $select_suppliers = mysqli_query($conn, "SELECT * FROM `supplier`");
                $number_of_suppliers = mysqli_num_rows($select_suppliers);
                ?>
                <h3><?php echo $number_of_suppliers; ?></h3>                
                <p>Suppliers</p>
                <a href="suppliers.php" class="btn">view Suppliers</a>
            </div>

            <div class="box">
                <?php 
                $select_suppliers = mysqli_query($conn, "SELECT * FROM `supplier`");
                $number_of_suppliers = mysqli_num_rows($select_suppliers);
                ?>
                <h3><?php echo $number_of_suppliers; ?></h3> 
                <p>Orders</p>
                <a href="order_list.php" class="btn">view Orders</a>               
            </div>

        
        </div>

</div>

</body>
</html>