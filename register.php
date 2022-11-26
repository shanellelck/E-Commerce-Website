<?php

include 'connection.php';

if(isset($_POST['submit'])){

   
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);
    
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    
    $filter_pass = filter_var(md5($_POST['pass']), FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, $filter_pass);
    
    $filter_cpass = filter_var(md5($_POST['cpass']), FILTER_SANITIZE_STRING);
    $cpass = mysqli_real_escape_string($conn, $filter_cpass);

    $select= mysqli_query($conn, "SELECT * FROM `customer` WHERE email = '$email'") or die('query failed');

    if(mysqli_num_rows($select) > 0){
        $message[] = 'user email already exist!';
    }else{ 
        if($pass != $cpass){
            $message[] = 'password not matched!';
        }else{
            mysqli_query($conn, "INSERT INTO `customer`(`name`, `email`, `password`) VALUES ('$name','$email','$pass')")
            or die('query failed');
            
            $message[] = 'registered successful!';
            header('location:login.php');
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
    <title>register</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/components.css">

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
    
<section class="form-container">
    <form action="" enctype="multipart/form-data" method="POST">
        <h3>Register Now</h3>
        <input type="text" name="name" class="box" placeholder="enter your name" required>
        <input type="email" name="email" class="box" placeholder="enter your email" required>
        <input type="password" name="pass" class="box" placeholder="enter your password" required>
        <input type="password" name="cpass" class="box" placeholder="confirm your password" required>
        <input type="submit" value="register now" class="btn" name="submit">
        <p>already have an account? <a href="login.php">login now</a></p>

    </form>
</section>


</body>
</html>