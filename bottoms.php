<?php include "header.php" ?>
<?php include "connection.php" ?>

<?php
    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

        $SELECT_BOTTOMS = "SELECT * FROM model WHERE (Description LIKE '%pants%' OR Description LIKE '%shorts%');";
        $bottoms = $conn->query($SELECT_BOTTOMS);
?>


<body>
    <section id="new-arrivals">
        <h1>Bottoms</h1>
        <div class="tops">
            
            <?php 
                while($item = mysqli_fetch_assoc($bottoms)):
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
<!-- <footer>
<a>About Us</a>
<a>Contact Us</a>
</footer> -->

