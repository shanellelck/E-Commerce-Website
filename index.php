<?php include "header.php" ?>

<?php
    // Create connection
    $servername = "localhost";
    $database = "shop";
    $username = "root";
    $password = "";

    // Create connection

    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection


    @include 'config.php';

    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

        $SELECT_NEW_ARRIVALS = "SELECT * FROM item WHERE category_id ='SSH';";
        $new_arrivals = $conn->query($SELECT_NEW_ARRIVALS);
?>


<body>
    <section id="new-arrivals">
        <h1>New Arrivals</h1>
        <div class="tops">
            <h2>Tops</h2>
            <?php 
                while($item = mysqli_fetch_assoc($new_arrivals)):
            ?>
            <div class="item">
                <?php $item_id = $item['Item_ID'] ?>
                <p class="item-name"><?= $item['Name'];?></p>
                <img src="<?= $item['Img'];?>"/>
                <p class="item-price">$<?= $item['Price'];?></p>
                <a href="item.php?item_id=<?php echo $item_id ?>">
                    <button type="button" class="btn">More</button>
                </a>
            </div>
            <?php endwhile; ?>
        </div>    
        <div class="bottoms">
            <h2>Bottoms</h2>
        </div>
        <div class="accessories">
            <h2>Accessories</h2>
        </div>
    </section>
        <!-- <section id="about-us">
        </section>
        <section id="sale"></section> -->
</body>
<footer>
<a>About Us</a>
<a>Contact Us</a>
</footer>