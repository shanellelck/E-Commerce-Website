
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
        $SELECT_NEW_TOPS = "SELECT * FROM `model` WHERE (Description LIKE '%hoodie%' OR Description LIKE '%sweater%') AND Remove_Date IS NULL ORDER BY Add_Date Desc LIMIT 10";
        $new_arrivals = $conn->query($SELECT_NEW_TOPS);

        $SELECT_NEW_BOTTOMS = "SELECT * FROM `model` WHERE (Description LIKE '%pants%' OR Description LIKE '%shorts%') AND Remove_Date IS NULL;";
        $new_bottoms = $conn->query($SELECT_NEW_BOTTOMS);

        $SELECT_NEW_DRESSES = "SELECT * FROM `model` WHERE Description LIKE '%dress%' AND Remove_Date IS NULL;";
        $new_dresses = $conn->query($SELECT_NEW_DRESSES);

        $SELECT_NEW_ACCESSORIES = "SELECT * FROM `model` WHERE Description LIKE '%accessory%' AND Remove_Date IS NULL;";
        $new_accessories = $conn->query($SELECT_NEW_ACCESSORIES);
?>


<body>
    <?php if ($_SESSION['user_type'] == 'admin'): ?>
        <div class="admin-nav">
            
        </div>
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
        <h2>Bottoms</h2>   
        <div class="bottoms">
            <?php 
                while($bottom = mysqli_fetch_assoc($new_bottoms)):
            ?>
            <div class="item">
                <?php $bottom_id = $bottom['Model_ID'] ?>
                <p class="item-name"><?= $bottom['Name'];?></p>
                <img src="<?= $bottom['Model_Image'];?>"/>
                <p class="item-price">$<?= $bottom['Price'];?></p>
                <a href="item.php?item_id=<?php echo $bottom_id ?>">
                    <button type="button" class="btn">More</button>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
        <h2>Dresses</h2>
        <div class="dresses">
            <?php 
                while($dress = mysqli_fetch_assoc($new_dresses)):
            ?>
            <div class="item">
                <?php $dress_id = $dress['Model_ID'] ?>
                <p class="item-name"><?= $dress['Name'];?></p>
                <img src="<?= $dress['Model_Image'];?>"/>
                <p class="item-price">$<?= $dress['Price'];?></p>
                <a href="item.php?item_id=<?php echo $dress_id ?>">
                    <button type="button" class="btn">More</button>
                </a>
            </div>
            <?php endwhile; ?>
        </div>
        <h2>Accessories</h2>
        <div class="accessories">
        <?php 
                while($dress = mysqli_fetch_assoc($new_accessories)):
            ?>
            <div class="item">
                <?php $dress_id = $dress['Model_ID'] ?>
                <p class="item-name"><?= $dress['Name'];?></p>
                <img src="<?= $dress['Model_Image'];?>"/>
                <p class="item-price">$<?= $dress['Price'];?></p>
                <a href="item.php?item_id=<?php echo $dress_id ?>">
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