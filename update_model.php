<?php include "header.php" ?>
<?php include "connection.php" ?>
<?php
    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

    $item_id = $_GET['item_id'];
    
    $SELECT_MODEL = "SELECT * FROM model WHERE Model_ID = '$item_id';";
    $find_model = $conn->query($SELECT_MODEL);

    $model = mysqli_fetch_assoc($find_model);

    $model_id = $model['Model_ID'];
    $model_desc = $model['Description'];
    $model_price = $model['Price'];
    $model_name = $model['Model_Name'];
    $image_path = $model['Model_Image'];

?>
<header>
    <link rel="stylesheet" type="text/css" href="update_item.css">
</header>

<body>
    <!-- update model details, description, price, quantity
        can also add an 'item'
        new colour -> then need to have admin manually insert id and image etc -->

        <!-- model id -->
        <!-- description -->
        <!-- price -->
        <!-- model name -->
        <!-- total quantity -->
        <!-- admin id -> automatically users session id -->
        
        <!-- supplier email address  -->
        <!-- image  -->
        <?php if (isset($_POST['update_model'])) {
            if (isset($_POST['update_id'])) {
                if (($_POST['update_id'] != $model_id) && ($_POST['update_id'] != null)) {
                    $new_id = $_POST['update_id'];
                    $UPDATE_MODEL_ID ="UPDATE model SET Model_ID = '$new_id' WHERE Model_ID = '$item_id'";
                    $set_id = $conn->query($UPDATE_MODEL_ID);
                    $model_id = $new_id;
                }
                // echo "GOOD";
            }
            if (isset($_POST['update_desc'])) {
                if (($_POST['update_desc'] != $model_desc) && ($_POST['update_desc'] != null)) {
                    $new_desc = $_POST['update_desc'];
                    $UPDATE_DESC ="UPDATE model SET Description = '$new_desc' WHERE Model_ID = '$item_id'";
                    $set_desc = $conn->query($UPDATE_DESC);
                    $model_desc = $new_desc;
                }
                // echo "GOOD";
            }
            if (isset($_POST['update_price'])) {
                if (($_POST['update_price'] != $model_price) && ($_POST['update_price'] != null)) {
                    $new_price = intval($_POST['update_price']);
                    // echo $new_price;
                    $UPDATE_PRICE ="UPDATE model SET Price = '$new_price' WHERE Model_ID = '$item_id';";
                    $set_price = $conn->query($UPDATE_PRICE);
                    $model_price = $new_price;
                }
                // echo "GOOD";
            }
            if (isset($_POST['update_name'])) {
                if (($_POST['update_name'] != $model_name) && ($_POST['update_name'] != null)) {
                    $new_name = $_POST['update_name'];
                    $UPDATE_NAME ="UPDATE model SET Model_Name = '$new_name' WHERE Model_ID = '$item_id';";
                    $set_name = $conn->query($UPDATE_NAME);
                    $model_name = $new_name;
                }
                // echo "GOOD";
            }
            if (isset($_POST['update_image'])) {
                $image = $_FILES["update_image"]["name"];
                $image = filter_var($image, FILTER_SANITIZE_STRING);
                $image_size = $_FILES["update_image"]["size"];
                $image_tmp_name = $_FILES["update_image"]["tmp_name"];
                $image_folder = "img/".$image;
                $old_image = $_POST['update_p_image'];


                $UPDATE_IMG ="UPDATE model SET Model_Image = '$image_folder' WHERE Model_ID = '$item_id';";
                $set_img = $conn->query($UPDATE_IMG) or die('query failed');
                if($set_img){
                    if($image_size > 2000000){
                       echo 'image size is too large!';
                       }else{
                       move_uploaded_file($image_tmp_name, $image_folder);
                       unlink('img/'.$old_image);
                       echo 'item added successfully!';
                       }
                    }
                }
            $date = date("Y-m-d");
            $UPDATE_TABLE = "INSERT INTO model_update VALUES ('$user_id', '$item_id', '$date')";
            $set_update = $conn->query($UPDATE_TABLE);

            // $UPDATE_ADMIN = "UPDATE model SET Admin_ID = '$user_id' WHERE Model_ID = '$item_id'";
            // $set_admin = $conn->query($UPDATE_ADMIN);
            // $UPDATE_PRICE = "UPDATE model SET Price = '30.00' WHERE Model_ID = '$item_id';";
            // $set_price = $conn->query($UPDATE_PRICE);
        } ?>


    <div class="update-profile">
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex">
         <h3>Update Model</h1>
            <div class="inputBox">
                <div class="inputContainer">
                    <span>Model ID: </span>
                    <input type="text" name="update_id" value="<?php echo $model_id?>"
                    class="box">
                </div>
                <div class="inputContainer">
                    <span>Description: </span>
                    <input type="text" name="update_desc" value="<?php echo $model_desc?>"
                    class="box">
                </div>
                <div class="inputContainer">
                    <span>Price: </span>
                    <input type="text" name="update_price" value="<?php echo $model_price?>"
                    class="box">
                </div>
                <div class="inputContainer">
                    <span>Model Name:</span>
                    <input type="text" name="update_name" value="<?php echo $model_name?>"
                    class="box">
                </div>
                <div class="inputContainer">
                    <span>Image: </span>
                    <input type="hidden" value="<?php echo $image_path ?>" name="update_p_image">
                    <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png">
                </div>
            </div>
        </div>
        <input type="submit" value="update_model" name ="update_model" class="btn">
        <a href="update_model.php?item_id=<?php echo $item_id ?>" class="">go back</a>
    </form>
    </div>

</body>