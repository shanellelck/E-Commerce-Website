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
$filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
$pass = mysqli_real_escape_string($conn, $filter_pass);

if(isset($_POST['update_profile'])){
    $filter_update_name = filter_var($_POST['update_name'], FILTER_SANITIZE_STRING);
    $update_name = mysqli_real_escape_string($conn, $filter_update_name);

    $filter_update_email = filter_var($_POST['update_email'], FILTER_SANITIZE_STRING);
    $update_email = mysqli_real_escape_string($conn, $filter_update_email);
    
    $filter_update_phoneNum = filter_var($_POST['update_phoneNum'], FILTER_SANITIZE_STRING);
    $update_phoneNum = mysqli_real_escape_string($conn, $filter_update_phoneNum);
    
    if ($_SESSION['user_type'] == 'customer'){
        mysqli_query($conn, "UPDATE `customer` SET Name ='$update_name',
        Phone_Num = '$update_phoneNum' WHERE ID = '$user_id'") or die('query failed');

    }else if ($_SESSION['user_type'] == 'admin'){
        mysqli_query($conn, "UPDATE `admin` SET Name ='$update_name' WHERE ID = '$user_id'") or die('query failed');

    }

    $pass =$_POST['pass'];
    $filter_update_pass = filter_var($_POST['update_pass'],FILTER_SANITIZE_STRING);
    $update_pass = mysqli_real_escape_string($conn, $filter_update_pass);
    
    $filter_new_pass = filter_var($_POST['new_pass'],FILTER_SANITIZE_STRING);
    $new_pass = mysqli_real_escape_string($conn, $filter_new_pass);

    $filter_cnew_pass = filter_var($_POST['confirm_new_pass'],FILTER_SANITIZE_STRING);
    $confirm_new_pass = mysqli_real_escape_string($conn, $filter_cnew_pass);

    if(!empty($update_pass) && !empty($new_pass) && !empty($confirm_new_pass)){
        if($update_pass != $pass){
            $message[] = 'wrong password!';
        }elseif($new_pass != $confirm_new_pass){
            $message[] =  'confirm password and new password not matched!';
        }elseif($_SESSION['user_type'] == 'customer'){
            mysqli_query($conn, "UPDATE `customer` SET Password = '$confirm_new_pass' WHERE ID = '$user_id'")
            or die('query failed');
            $message[] = 'password updated successfully!';
        }elseif($_SESSION['user_type'] == 'admin'){
            mysqli_query($conn, "UPDATE `admin` SET Password = '$confirm_new_pass' WHERE ID = '$user_id'")
            or die('query failed');
            $message[] = 'password updated successfully!';
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
    <title>Update Profile</title>

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


<div class="update-profile">
    <div class="box">
    <?php 
        $select_user = mysqli_query($conn, "SELECT * FROM `customer` WHERE ID = '$user_id'") or die('query failed');
        $select_admin = mysqli_query($conn, "SELECT * FROM `admin` WHERE ID = '$user_id'") or die('query failed');

        if(mysqli_num_rows($select_user) > 0){
        $fetch_profile = mysqli_fetch_assoc($select_user);
        }
        if(mysqli_num_rows($select_admin) > 0){
            $fetch_profile = mysqli_fetch_assoc($select_admin);
        }
    ?>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex">
         <h3>Update Profile</h1>
            <div class="inputBox">
                <span>email :</span>
                <span class="box"><?php echo $fetch_profile['Email'];?></span>
                <span>name :</span>
                <input type="text" name="update_name" value="<?php echo $fetch_profile['Name']?>"
                class="box">
                <?php if ($_SESSION['user_type'] == 'customer'): ?>
                <span>phone number :</span>
                <input type="text" name="update_phoneNum" value="<?php echo $fetch_profile['Phone_Num']?>"
                class="box">
                <?php endif; ?>
            </div>
            <div class="inputBox">
                <input type="hidden" name="pass" value ="<?php echo $fetch_profile['Password']?>">
                <span> password :</span>
                <input type="password" name="update_pass" placeholder="enter your password" class="box">
                <span> new password :</span>
                <input type="password" name="new_pass" placeholder="enter your new password" class="box">
                <span> confirm new password :</span>
                <input type="password" name="confirm_new_pass" placeholder="confirm new password" class="box">
            </div>
        </div>
        <input type="submit" value="update profile" name ="update_profile" class="btn">
        <a href="profile.php" class="delete-btn">go back</a>
    </form>
    </div>
</div>
</body>
</html>