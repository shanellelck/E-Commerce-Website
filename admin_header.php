<?php 

   include 'connection.php';
 
   session_start();
   
   if(isset($_SESSION['user_id'])){
       $user_id = $_SESSION['user_id'];
   }else{
       $user_id ='';
       header('location:index.php');
   }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <!-- custom css file link  -->
          <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <header class ="admin_header">

    <div class="flex">

    
    <nav class = "navbar">

        <a href="add-item.php">Add Item</a>
        <a href="add-model.php">Add Model</a>
        <a href="add-supplier.php">Add Supplier</a>

    </nav>
    </div>
    </header>    
</body>
</html>