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
                <input type="text" id="search" placeholder="Search...">
                <a id="home" href="./index.php">HOME</a>
                <div class="dropdown">
                    <button class="dropbtn" onclick="window.location.href='./clothing.php';">CLOTHING
                    <!-- <i class="fa fa-caret-down"></i> -->
                    </button>
                    <div class="dropdown-content">
                    <a href="#">Tops</a>
                    <a href="#">Bottoms</a>
                    </div>
                </div> 
                <a href="#sale">SALE</a>
                <a class="left" href="#about-us">ABOUT US</a>
                <a class="left" href="./cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                <a class="left" href="./profile.php"><i class="fa-solid fa-user"></i></a>
                <a href ="logout.php">logout</a>
            </div>
            
            <!-- <ul>
                <li><a href="./index.php">HOME</a></li>
                
                <li></li>
                <li></li>
                <li></li>
                <li></li>
            </ul> -->
  
        </nav>
    </header>
</html>