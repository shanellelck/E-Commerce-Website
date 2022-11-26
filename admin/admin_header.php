
<?php 
if(isset($message)){
    foreach($message as $message){
       echo '
       <div class="message">
          <span>'.$message.'</span>
          <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
       </div>
       ';
    }
 } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style.css">
    <link rel="stylesheet" type="text/css" href="../style-item.css">
    <script src="https://kit.fontawesome.com/5ca4d9b311.js" crossorigin="anonymous"></script>
    <title>admin page</title>
</head>
<body>
<header class="header">
    <div class = "flex">
        <a href="dashboard.php" class ="logo"> Admin <span>Panel</span></a>
        <nav class = "navbar">
            <a href="dashboard.php">Home</a>
            <a href="admin_item.php">Items</a>
            <a href="admin_order.php">Orders</a>
            <a href="admin_user.php">Users</a>
        </nav>
        <div class="icons">
            <i class = "bi bi-list" id="menu-btn"></i>
            <i class = "bi bi-user" id="user-btn"></i>
        </div>
        <div class="user-box">
            <p>username : <span><?php echo $_SESSION['admin_name'];?></span></p>
        </div>
    </div>
</header>
</body>
</html>
