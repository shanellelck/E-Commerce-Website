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

if(isset($_POST['submit'])){
 
    $filter_streetNum = filter_var($_POST['street-num'],FILTER_SANITIZE_STRING);
    $update_streetNum = mysqli_real_escape_string($conn, $filter_streetNum);
   
    $filter_streetName = filter_var($_POST['street-name'],FILTER_SANITIZE_STRING);
    $update_streetName = mysqli_real_escape_string($conn, $filter_streetName);

    $filter_city = filter_var($_POST['city'],FILTER_SANITIZE_STRING);
    $update_city = mysqli_real_escape_string($conn, $filter_city);

    $filter_province = filter_var($_POST['province'],FILTER_SANITIZE_STRING);
    $update_province = mysqli_real_escape_string($conn, $filter_province);

    $filter_postal = filter_var($_POST['postal-code'],FILTER_SANITIZE_STRING);
    $update_postal = mysqli_real_escape_string($conn, $filter_postal);
    
    $filter_country = filter_var($_POST['country'],FILTER_SANITIZE_STRING);
    $update_country = mysqli_real_escape_string($conn, $filter_country);

    if(!empty($update_streetNum) && !empty($update_streetName) && !empty($update_city)
    && !empty($update_province) && !empty($update_postal) && !empty($update_country)){
        mysqli_query($conn, "UPDATE `customer` SET Street_Num = '$update_streetNum', Street_Name = '$update_streetName', 
        City = '$update_city', Province = '$update_province', Postal_Code = '$update_postal', Country = '$update_country'
        WHERE ID = '$user_id'") or die('query failed');
         $message[] = 'address updated successfully!';
    }else{
        $message[] = 'Please fill all entries';
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Address</title>


    <!-- custom css file link  -->
    <link rel="stylesheet" href="style-input.css">


</head>
<body>
<div class="update-address">
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
    <section class="form-container">
    <?php 
        $select_user = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_user) > 0){
        $fetch_profile = mysqli_fetch_assoc($select_user);
        }
    ?>
    <div class="box">
        <form action="" method="POST">
            <div class="flex">
                <h3>Update Address</h3>
                <div class="inputBox">
                <div class="inputContainer">
                <span>Street Number:</span>
                <input type="text" name = "street-num" placeholder="enter your street number" class="box">
                </div>  
                <div class="inputContainer">
                <span>Street Name:</span>
                <input type="text" name = "street-name" placeholder="enter your street name" class="box">
                </div>  
                <div class="inputContainer">
                <span>City:</span>
                <input type="text" name = "city" placeholder="enter your city" class="box">
                </div>  
                <div class="inputContainer">
                <span>Province:</span>
                <input type="text" name = "province" placeholder="enter your province" class="box">
                </div>  
                <div class="inputContainer">
                <span>Postal Code:</span>
                <input type="text" name = "postal-code" placeholder="enter your postal code" class="box">
                </div>  
                <div class="inputContainer">
                <span>Country</span>
                <input type="text" name = "country" placeholder="enter your country" class="box">
                </div>  
                <input type="submit" value="save address" name="submit" class="btn">
                <a href="profile.php" class="delete-btn">go back</a>
                </div>
            </div>
        </form>
    </div>
    </section>
    </div> 
    
</body>
</html>