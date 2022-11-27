<?php include "header.php" ?>
<?php include "connection.php" ?>

<?php
    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

        $SELECT_DRESSES = "SELECT * FROM item WHERE Category_ID ='DRESSES';";
        $dresses = $conn->query($SELECT_DRESSES);
?>


<body>
    <section id="new-arrivals">
        <h1>Dresses</h1>
        <div class="tops">
            <h2>Tops</h2>
            <?php 
                while($item = mysqli_fetch_assoc($dresses)):
            ?>
            <div class="item">
                <?php $item_id = $item['Item_ID'] ?>
                <p class="item-name"><?= $item['Name'];?></p>
                <img src="<?= $item['Image'];?>"/>
                <p class="item-price">$<?= $item['Price'];?></p>
                <a href="item.php?item_id=<?php echo $item_id ?>">
                    <button type="button" class="btn">More</button>
                </a>
            </div>
            <?php endwhile; ?>
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

