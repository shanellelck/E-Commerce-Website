<?php include "header.php" ?>

<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
    header('location:login.php');
}

?>

<!DOCTYPE html>
<HTML>
    <header>
        <meta charset="utf-8">
        <meta name="viewport" content="width =device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <script src="https://kit.fontawesome.com/5ca4d9b311.js" crossorigin="anonymous"></script>
        <title></title>
    </header>
    <body>
        <nav>
            <div class = "logo">
                    <a href='./index.html'>
                        <img src = './logo.jpg'>
                    </a>
                    
            </div>
            <ul>
                <li><a href="./index.php">HOME</a></li>
                <div class="dropdown">
                    <button class="dropbtn" onclick="window.location.href='./clothing.php';">CLOTHING
                    <!-- <i class="fa fa-caret-down"></i> -->
                    </button>
                    <div class="dropdown-content">
                    <a href="#">Tops</a>
                    <a href="#">Bottoms</a>
                    </div>
                </div> 
                <li><a href="#sale">SALE</a></li>
                <li><a class="left" href="#about-us">ABOUT US</a></li>
                <li><a class="left" href="./cart.php"><i class="fa-solid fa-cart-shopping"></i></a></li>
                <li><a class="left" href="./profile.php"><i class="fa-solid fa-user"></i></a></li>
                <a href ="logout.php">logout</a>
            </ul>
  
        </nav>

        <section id="home"></section>
        <section id="about-us">
        </section>
        <section id="sale"></section> -->
</body>
<footer>
<a>About Us</a>
<a>Contact Us</a>
</footer>