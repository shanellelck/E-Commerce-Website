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

   if(isset($_POST['add_model'])){

      $id = mysqli_real_escape_string($conn, $_POST['model_ID']);
      $name = mysqli_real_escape_string($conn, $_POST['model_name']);
      $quantity = mysqli_real_escape_string($conn, $_POST['model_total_quantity']);
      $price = mysqli_real_escape_string($conn, $_POST['model_price']);
      $admin_ID = mysqli_real_escape_string($conn, $user_id);
      $add_Date = date('Y-m-d');
      $supplier = mysqli_real_escape_string($conn, $_POST['model_supplier']);
      $description = mysqli_real_escape_string($conn, $_POST['model_details']);
      
 
      $image = $_FILES["model_image"]["name"];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $image_size = $_FILES["model_image"]["size"];
      $image_tmp_name = $_FILES["model_image"]["tmp_name"];
      $image_folder = "img/".$image;
   

   
      $select_modelID = mysqli_query($conn, "SELECT Model_ID FROM `model` WHERE Model_ID = '$id'") or die('query failed');
   
      if(mysqli_num_rows($select_modelID) > 0){
          $message[] = 'model ID already exist!';
      }else{
          $insert_model = mysqli_query($conn, "INSERT INTO `model` (Model_ID, Description, Price, Model_Name,  Total_Quantity, Admin_ID, Add_Date, Supplier_Email_Address, Image)
          VALUES ('$id','$description','$price','$name','$quantity','$admin_ID','$add_Date','$supplier','$image_folder')") or die('query failed');
      
         if($insert_model){
            if($image_size > 2000000){
               $message[] = 'image size is too large!';
               }else{
               move_uploaded_file($image_tmp_name, $image_folder);
               $message[] = 'model added successfully!';
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
    <title>Add Model</title>
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
<div class="add-model">
<section class="form-container">

   <h1 class="title">Add New Model</h1>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">

            <div class="inputContainer">
            <span>Model_ID :</span>
            <input type="text" name="model_ID" class="box" required placeholder="enter model ID">
            </div>
            
            <div class="inputContainer">
            <span>Model Name :</span>
            <input type="text" name="model_name" class="box" required placeholder="enter model name">
            </div>
            
            <div class="inputContainer">
            <span>Model Supplier :</span>
            <select name="model_supplier" class="box" required>
                <option value="" selected disabled>select supplier</option>
                <?php 
                $sql = mysqli_query($conn, "SELECT * FROM supplier");
                while ($row = $sql->fetch_assoc()){
                echo "<option value=".$row['Email'].">" . $row['Name']. "</option>";
                }
                ?>
            </select>
            </div>
            
            <div class="inputContainer">
            <span>Model Price :</span>
            <input type="number" min="0.00" max= "999.99" step="0.01" class="box" required placeholder="enter model price" name="model_price">
            </div>
            
            <div class="inputContainer">
            <span>Model Total Quantity :</span>
            <input type="number" min="0" class="box" required placeholder="enter model quantity" name="model_total_quantity">
            </div>
            
            <div class="inputContainer">
            <span>Model Image :</span>
            <input type="file" name="model_image" required class="box" accept="image/jpg, image/jpeg, image/png">
            </div>
            
            <div class="inputContainer">
            <span>Model Descriptions :</span>
            <textarea name="model_details" class="box" required placeholder="enter model details" cols="30" rows="10"></textarea>
            </div>

            <input type="submit" class="btn" value="add model" name="add_model">
        </div>
      </div>

   </form>

</section>
</div>   
</body>
</html>