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

$email = $_GET['email'];

if(isset($_POST['submit'])){

    $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
    $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
    $update_phoneNum = mysqli_real_escape_string($conn, $_POST['update_phoneNum']);
    
    $select = mysqli_query($conn, "SELECT * FROM `customer` WHERE Email = '$update_email'") or die('query failed');


    if(mysqli_num_rows($select) > 0 && $update_email != $email){
        $message[] = 'customer email already exist'; 
    }else{
        mysqli_query($conn, "UPDATE `customer` SET Name = '$update_name', Email = '$update_email', Phone_number = '$update_phoneNum' WHERE Email = '$email'") or die('query failed');
        $message[] = 'customer info updated successfully!';
    }
    
 
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

        mysqli_query($conn, "UPDATE `customer` SET Street_number = '$update_streetNum', Street_name = '$update_streetName', 
        City = '$update_city', Province = '$update_province', Postal_code = '$update_postal', Country = '$update_country'
        WHERE Email = '$email'") or die('query failed');
     
        $message[] = 'address updated successfully!';

    }else{
        $message[] = 'Please fill all address entries';
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
<div class="update-customer">
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
        $select_customer = mysqli_query($conn, "SELECT * FROM `customer` WHERE Email = '$email'") or die('query failed');
        if(mysqli_num_rows($select_customer) > 0){
        $fetch_customer = mysqli_fetch_assoc($select_customer);
        }
    ?>
    <div class="box">
        <form action="" method="POST">
            <div class="flex">
                <h3>Update Customer Info</h3>
                
                <div class="inputBox">
                
                <div class="inputContainer">
                <span>Email :</span>
                <input type="text" name="update_email" value="<?php echo $fetch_customer['Email']?>"
                required class="box">
                </div>
                
                <div class="inputContainer">
                <span>Name :</span>
                <input type="text" name="update_name" value="<?php echo $fetch_customer['Name']?>"
                required class="box">
                </div>
                
                <div class="inputContainer">
                <span>Phone number :</span>
                <input type="text" name="update_phoneNum" value="<?php echo $fetch_customer['Phone_number']?>"
                required class="box">
                </div>

                <h3>Update Customer Address</h3>
                
                <div class="inputContainer">
                <span>Street Number:</span>
                <input type="text" name = "street-num" <?php if($fetch_customer['Street_number'] == ''): ?>
                placeholder = "enter your street number"
                <?php else : ?> value = "<?php echo $fetch_customer['Street_number']?>"
                <?php endif; ?> class="box"></div>  
                
                <div class="inputContainer">
                <span>Street Name:</span>
                <input type="text" name = "street-name" <?php if($fetch_customer['Street_name'] == ''): ?>
                placeholder = "enter your street name"
                <?php else : ?> value = "<?php echo $fetch_customer['Street_name']?>"
                <?php endif; ?> class="box"></div>  

                <div class="inputContainer">
                <span>City:</span>
                <input type="text" name = "city" <?php if($fetch_customer['City'] == ''): ?>
                placeholder = "enter your city"
                <?php else : ?> value = "<?php echo $fetch_customer['City']?>"
                <?php endif; ?> class="box"></div> 

                <div class="inputContainer">
                <span>Province:</span>
                <input type="text" name = "province" <?php if($fetch_customer['Province'] == ''): ?>
                placeholder = "enter your province"
                <?php else : ?> value = "<?php echo $fetch_customer['Province']?>"
                <?php endif; ?> class="box"></div>  

                <div class="inputContainer">
                <span>Postal Code:</span>
                <input type="text" name = "postal-code" <?php if($fetch_customer['Postal_code'] == ''): ?>
                placeholder = "enter your postal code"
                <?php else : ?> value = "<?php echo $fetch_customer['Postal_code']?>"
                <?php endif; ?> class="box"></div> 

                <div class="inputContainer">
                <span>Country:</span>
                <input type="text" name = "country" <?php if($fetch_customer['Country'] == ''): ?>
                placeholder = "enter your country"
                <?php else : ?> value = "<?php echo $fetch_customer['Country']?>"
                <?php endif; ?> class="box">
                </div>   

                <input type="submit" value="save address" name="submit" class="btn">
                <a href="customer_list.php" class="delete-btn">go back</a>
                </div>
            </div>
        </form>
    </div>
    </section>
    </div> 
    
</body>
</html>