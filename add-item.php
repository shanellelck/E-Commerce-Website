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

   if(isset($_POST['add_item'])){

      $id = mysqli_real_escape_string($conn, $_POST['item_ID']);
      $name = mysqli_real_escape_string($conn, $_POST['item_name']);
      $colour = mysqli_real_escape_string($conn, $_POST['item_colour']);
      $size = mysqli_real_escape_string($conn, $_POST['item_size']);
      $quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
      $category = mysqli_real_escape_string($conn, $_POST['item_category']);
      $price = mysqli_real_escape_string($conn, $_POST['item_price']);
      $admin_ID = mysqli_real_escape_string($conn, $user_id);
      $add_Date = date('Y-m-d');
      $supplier = mysqli_real_escape_string($conn, $_POST['item_supplier']);
      $description = mysqli_real_escape_string($conn, $_POST['item_details']);
      
 
      $image = $_FILES["item_image"]["name"];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $image_size = $_FILES["item_image"]["size"];
      $image_tmp_name = $_FILES["item_image"]["tmp_name"];
      $image_folder = "img/".$image;
   

   
      $select_itemID = mysqli_query($conn, "SELECT Item_ID FROM `item` WHERE Item_ID = '$id'") or die('query failed');
   
      if(mysqli_num_rows($select_itemID) > 0){
          $message[] = 'Item ID already exist!';
      }else{
          $insert_item = mysqli_query($conn, "INSERT INTO `item` (Item_ID, Description, Price, Name, Colour, Size, Quantity, Category_ID, Admin_ID, Add_Date, Supplier_Email_Address, Image)
          VALUES ('$id','$description','$price','$name','$colour', '$size','$quantity','$category','$admin_ID','$add_Date','$supplier','$image_folder')") or die('query failed');
      
         if($insert_item){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
               }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'product added successfully!';
               }
            }
   
      }
   
   }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
      <!-- custom css file link  -->
        <link rel="stylesheet" href="style.css">
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
<section class="add-item">

   <h1 class="title">Add new item</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
         <input type="text" name="item_ID" class="box" required placeholder="enter item ID">
         <input type="text" name="item_name" class="box" required placeholder="enter item name">
         <input type="text" name="item_colour" class="box" required placeholder="enter item colour">
         <input type="text" name="item_size" class="box" required placeholder="enter item size">
         <select name="item_category" class="box" required>
            <option value="" selected disabled>select category</option>
            <?php 
            $sql = mysqli_query($conn, "SELECT * FROM category");
            while ($row = $sql->fetch_assoc()){
            echo "<option value=".$row['Category_ID'].">" . $row['Category_Name'] . "</option>";
            }
            ?>
         </select>
         <select name="item_supplier" class="box" required>
            <option value="" selected disabled>select supplier</option>
            <?php 
            $sql = mysqli_query($conn, "SELECT * FROM supplier");
            while ($row = $sql->fetch_assoc()){
            echo "<option value=".$row['Email_Address'].">" . $row['Email_Address'] . "</option>";
            }
            ?>
         </select>
         </div>
         <div class="inputBox">
         <input type="number" min="0.00" max= "999.99" step="0.01" class="box" required placeholder="enter item price" name="item_price">
         <input type="number" min="0" class="box" required placeholder="enter item quantity" name="item_quantity">
         <input type="file" name="item_image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>
      </div>
      <textarea name="item_details" class="box" required placeholder="enter item details" cols="30" rows="10"></textarea>
      <input type="submit" class="btn" value="add item" name="add_item">
   </form>

</section>
    
</body>
</html>