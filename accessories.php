<?php include "header.php" ?>
<?php include "connection.php" ?>

<?php
    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

        $SELECT_ACCESSORIES = "SELECT * FROM model WHERE Description LIKE '%accessory%' AND Remove_Date IS NULL;";
        $accessories = $conn->query($SELECT_ACCESSORIES);
?>


<body>
    <section id="new-arrivals">
        <h1>Accessories</h1>
        <div class="tops">
            
            <?php 
                while($item = mysqli_fetch_assoc($accessories)):
            ?>
            <div class="item">
                <?php $item_id = $item['Model_ID'] ?>
                <p class="item-name"><?= $item['Name'];?></p>
                <img src="<?= $item['Model_Image'];?>"/>
                <p class="item-price">$<?= $item['Price'];?></p>
                <a href="item.php?item_id=<?php echo $item_id ?>">
                    <button type="button" class="btn">More</button>
                </a>
            </div>
            <?php endwhile; ?>
        </div>    
    </section>
</body>
<footer>
<!-- <a>About Us</a>
<a>Contact Us</a>
</footer> -->