
<?php include "connection.php" ?>

<?php
    session_start();    

    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    if(!isset($user_id)){
        header('location:login.php');
    }
    include "header.php" ;


        // $SELECT_NEW_ARRIVALS = "SELECT * FROM item WHERE Category_ID ='SSH';";
        $SELECT_NEW_ARRIVALS = "SELECT * FROM `item` ORDER BY Add_Date Desc LIMIT 10";
        $new_arrivals = $conn->query($SELECT_NEW_ARRIVALS);

        $SELECT_NEW_DRESSES = "SELECT * FROM `item` WHERE Category_ID = 'DRESSES'";
        $new_dresses = $conn->query($SELECT_NEW_DRESSES);


?>


<body>
    <?php if ($_SESSION['user_type'] == 'admin'): ?>
        <a href="add-item.php" class="btn"> add item</a>
    <?php endif; ?>
    <section id="new-arrivals">
        <h1>New Arrivals</h1>
        <h2>Tops</h2>
        <div class="tops">
            <?php 
                while($item = mysqli_fetch_assoc($new_arrivals)):
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
        <h2>Bottoms</h2>   
        <div class="bottoms">
            
        </div>
        <h2>Dresses</h2>
        <div class="dresses">
            <?php 
                while($dress = mysqli_fetch_assoc($new_dresses)):
            ?>
            <div class="item">
                <?php $dress_id = $dress['Item_ID'] ?>
                <p class="item-name"><?= $dress['Name'];?></p>
                <img src="<?= $dress['Image'];?>"/>
                <p class="item-price">$<?= $dress['Price'];?></p>
                <a href="item.php?item_id=<?php echo $dress_id ?>">
                    <button type="button" class="btn">More</button>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
        <h2>Accessories</h2>
        <div class="accessories">
            
        </div>
    </section>
</body>
<footer>
<a>About Us</a>
<a>Contact Us</a>
</footer>