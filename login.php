<?php

include 'connection.php';

session_start();

if(isset($_POST['submit'])){

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, $filter_pass);
 
    // $select_customer = mysqli_query($conn, "SELECT * FROM customer WHERE Email = '$email' AND Password = '$pass';") or die('query failed');
    $select_customer = mysqli_query($conn, "SELECT * FROM customer WHERE Email = '$email' AND Password = '$pass';");
    $select_admin = mysqli_query($conn, "SELECT * FROM admin WHERE Email_Address = '$email' AND Password = '$pass';");

    if(mysqli_num_rows($select_customer) > 0){
        $row = mysqli_fetch_assoc($select_customer);
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['user_type'] = 'customer';
        header('location:index.php');
     } else if (mysqli_num_rows($select_admin) > 0){
        $row = mysqli_fetch_assoc($select_admin);
        $_SESSION['user_id'] = $row['ID'];
        $_SESSION['user_type'] = 'admin';
        header('location:index.php');
     }
     else{
        $message[] = 'Incorrect username or password!';
    }
    
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
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
        <h3>login now</h3>
        <input type="email" name="email" class="box" placeholder="enter your email" required>
        <input type="password" name="pass" class="box" placeholder="enter your password" required>
        <input type="submit" value="login now" class="btn" name="submit">
        <p>don't have an account? <a href="register.php">register now</a></p>

    </form>
</section>


</body>
</html>