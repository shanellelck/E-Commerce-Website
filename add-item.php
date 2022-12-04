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
      $colour = mysqli_real_escape_string($conn, $_POST['item_colour']);
      $size = mysqli_real_escape_string($conn, $_POST['item_size']);
      $quantity = mysqli_real_escape_string($conn, $_POST['item_quantity']);
      $model = mysqli_real_escape_string($conn, $_POST['item_model']);
      
 
      $image = $_FILES["item_image"]["name"];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $image_size = $_FILES["item_image"]["size"];
      $image_tmp_name = $_FILES["item_image"]["tmp_name"];
      $image_folder = "img/".$image;
   

   
      $select_itemID = mysqli_query($conn, "SELECT Item_ID FROM `item` WHERE Item_ID = '$id'") or die('query failed');
   
      if(mysqli_num_rows($select_itemID) > 0){
          $message[] = 'Item ID already exist!';
      }else{
          $insert_item = mysqli_query($conn, "INSERT INTO `item` (Item_ID, Model_ID, Colour, Size, Quantity, Image)
          VALUES ('$id','$model','$colour', '$size','$quantity','$image_folder')") or die('query failed');
      
         if($insert_item){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
               }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'item added successfully!';
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
<div class="add-item">
<section class="form-container">

   <h3 class="title">Add New Item</h3>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">

         <div class="inputContainer">
         <span>Item ID :</span>
         <input type="text" name="item_ID" class="box" required placeholder="enter item ID" >
         </div>

         <div class="inputContainer">
         <span>Item Model :</span>
         <select name="item_model" class="box" required>
            <option value="" selected disabled>select model</option>
            <?php 
            $sql = mysqli_query($conn, "SELECT * FROM model");
            while ($row = $sql->fetch_assoc()){
            echo "<option value=".$row['Model_ID'].">" . $row['Model_Name'] . "</option>";
            }
            ?>
         </select>
         </div>

         <div class="inputContainer">
         <span>Item Colour :</span>
         <input type="text" name="item_colour" class="box" required placeholder="enter item colour">
         </div>

         <div class="inputContainer">
         <span>Item Size :</span>
         <input type="text" name="item_size" class="box" required placeholder="enter item size">
         </div>

         <div class="inputContainer">
         <span>Item Quantity :</span>
         <input type="number" min="0" class="box" required placeholder="enter item quantity" name="item_quantity">
         </div>

         <div class="inputContainer">
         <span>Item Image :</span>
         <input type="file" name="item_image" required class="box" accept="image/jpg, image/jpeg, image/png">
         </div>

         <input type="submit" class="btn" value="add item" name="add_item">
         </div>
      </div>
   </form>
   

</section>
</div>
    
</body>
</html>