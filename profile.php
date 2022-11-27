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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>

        <!-- font awesome cdn link  -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

        <!-- custom css file link  -->
        <link rel="stylesheet" href="style.css">
</head>
<body>



<section class="user-profile">
<?php 
        $select_user = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_user) > 0){
        $fetch_profile = mysqli_fetch_assoc($select_user);
        }
    ?>
    <div class="box">
        <img src="img/user_icon.png" alt="">
        <p><i class ="fas fa-user"></i><span><?php echo $fetch_profile['Name'];?></span></p>
        <p><i class ="fas fa-envelope"></i><span><?php echo $fetch_profile['Email'];?></span></p>
        <p><i class ="fas fa-phone"></i><span><?php if($fetch_profile['Phone_Num'] == ''){echo 'Please enter your phone number!';}
        else{echo $fetch_profile['Phone_Num'];};?></span></p>
        <a href ="update_profile.php" class="btn">update info</a>
        <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['Street_Num'] || $fetch_profile['Street_Name']
        || $fetch_profile['City'] || $fetch_profile['Province'] || $fetch_profile['Postal_Code'] || $fetch_profile['Country'] == ''){echo 'Please enter your address!';}
        else{echo $fetch_profile['Street_Num']. ' ' .$fetch_profile['Street_Name']. ' ' .
        $fetch_profile['City']. ' ' .$fetch_profile['Province']. ' ' .$fetch_profile['Postal_Code']. ' ' .$fetch_profile['Country'];};?></span></p>
        <a href="update_address.php" class="btn"> update address</a>
 



    </div>
</section>

</body>
</html>