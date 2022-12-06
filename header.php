<?php
    session_start();    

    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    if(!isset($user_id)){
        header('location:login.php');
    }
?>




<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width =device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="stylesheet" type="text/css" href="style-item.css">
        <script src="https://kit.fontawesome.com/5ca4d9b311.js" crossorigin="anonymous"></script>
        <title></title>
    </head>
    <header>
        <nav>
            <div class="navbar">
                <a href='./index.php' class="logo">
                    <img id="logo" src = './logo.jpg'>
                </a>   
                <?php 
                    if (isset($_POST['search-bar'])) {
                        $search_word = $_POST['search-bar'];
                        header("location:search_results.php?search_word=".$search_word);
                    }
                ?>
                <form method="post">
                    <input type="text" id="search" name="search-bar" placeholder="Search...">
                </form>
                <a class="right" id="home" href="./index.php">HOME</a>
                <div class="right dropdown">
                    <button class="dropbtn" onclick="window.location.href='./clothing.php';">CLOTHING
                    </button>
                    <div class="dropdown-content">
                    <a href="#">Tops</a>
                    <a href="#">Bottoms</a>
                    <a href="./dresses.php">Dresses</a>
                    </div>
                </div> 
                <a class="right" href="#sale">SALE</a>
                <a class="right" href="#about-us">ABOUT US</a>

                <?php if ($_SESSION['user_type'] == 'admin'): ?>
                    <a class="right" href="./admin_dashboard.php">DASHBOARD</a>
                <?php endif; ?>
                <?php if ($user_type == 'customer'): ?>
                    <a class="right" href="./cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                <?php endif; ?>
                <a class="right" href="./profile.php"><i class="fa-solid fa-user"></i></a>
                <a class="right" href ="logout.php">logout</a>
            </div>
        </nav>
    </header>
</html>