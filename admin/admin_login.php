<?php


@include '../connection.php';

session_start();

if(isset($_POST['submit'])){

    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $email = mysqli_real_escape_string($conn, $filter_email);
    
    $filter_pass = filter_var(md5($_POST['pass']), FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, $filter_pass);
 
    $select= mysqli_query($conn, "SELECT * FROM `admin` WHERE Email = '$email' AND Password = '$pass'") or die('query failed');

    if(mysqli_num_rows($select) > 0){
        $row = mysqli_fetch_assoc($select);
        $_SESSION['admin_id'] = $row['ID'];
        header('location:dashboard.php');
     }else{
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
    <link rel="stylesheet" href="../css/components.css">

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
    </form>
</section>


</body>
</html>