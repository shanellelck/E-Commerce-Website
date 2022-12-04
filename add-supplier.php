<?php 
   
   include 'connection.php';
   include 'header.php' ;
   
   session_start();
   
   if(isset($_SESSION['user_id'])){
       $user_id = $_SESSION['user_id'];
   }else{
       $user_id ='';
       header('location:index.php');
   }

   if(isset($_POST['add_supplier'])){

      $email = mysqli_real_escape_string($conn, $_POST['supplier_email']);
      $name = mysqli_real_escape_string($conn, $_POST['supplier_name']);
      $phoneNum = mysqli_real_escape_string($conn, $_POST['supplier_phoneNum']);
      $streetNum = mysqli_real_escape_string($conn, $_POST['supplier_streetNum']);
      $streetName = mysqli_real_escape_string($conn, $_POST['supplier_streetName']);
      $city = mysqli_real_escape_string($conn, $_POST['supplier_city']);
      $province = mysqli_real_escape_string($conn, $_POST['supplier_province']);
      $postal = mysqli_real_escape_string($conn, $_POST['supplier_postal']);
      $country = mysqli_real_escape_string($conn, $_POST['supplier_country']);





   
      $select_supplier = mysqli_query($conn, "SELECT Email FROM `supplier` WHERE Email = '$email'") or die('query failed');
   
      if(mysqli_num_rows($select_supplier) > 0){
          $message[] = 'Supplier already exist!';
      }else{
          $insert_supplier = mysqli_query($conn, "INSERT INTO `supplier` (Email, Name, Phone_number, Street_number, Street_name, City, Province, Postal_code, Country)
          VALUES ('$email','$name','$phoneNum','$streetNum','$streetName', '$city','$province','$postal','$country')") or die('query failed');
        $message[] = 'Supplier added successfully!';

      }
   
   }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
      <!-- custom css file link  -->
        <link rel="stylesheet" href="style-input.css">
</head>
<body>
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
<div class="add-supplier">
<section class="form-container">

   <h1 class="title">Add Supplier</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <h3>Supplier Info</h3>
        
        <div class="inputBox">

        <div class="inputContainer">
        <span>Supplier Email :</span>
         <input type="text" name="supplier_email" class="box" required placeholder="enter supplier's email">
         </div>
            
        <div class="inputContainer">
        <span>Supplier Name :</span>
         <input type="text" name="supplier_name" class="box" required placeholder="enter supplier's name">
         </div>
            
        <div class="inputContainer">
        <span>Supplier Phone Number :</span>
         <input type="text" name="supplier_phoneNum" class="box" required placeholder="enter supplier's phone number">
         </div>
    
         <h3>Supplier Address</h3>

            
        <div class="inputContainer">
        <span>Street Number :</span>
         <input type="text" name="supplier_streetNum" class="box" required placeholder="enter supplier's street number">
         </div>
            
        <div class="inputContainer">
        <span>Street Name :</span>
         <input type="text" name="supplier_streetName" class="box" required placeholder="enter supplier's street name">
         </div>
            
        <div class="inputContainer">
        <span>City :</span>
         <input type="text" name="supplier_city" class="box" required placeholder="enter supplier's city">
         </div>
            
        <div class="inputContainer">
        <span>Province :</span>
         <input type="text" name="supplier_province" class="box" required placeholder="enter supplier's province">
         </div>
            
        <div class="inputContainer">
        <span>Postal Code :</span>
         <input type="text" name="supplier_postal" class="box" required placeholder="enter supplier's postal code">
         </div>
            
        <div class="inputContainer">
        <span>Country :</span>
         <input type="text" name="supplier_country" class="box" required placeholder="enter supplier's country">
         </div>

         <input type="submit" class="btn" value="add supplier" name="add_supplier">

        </div>
      </div>
   </form>

</section>
</div>
    
</body>
</html>