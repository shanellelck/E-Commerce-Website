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

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    $item_id = $_GET['item_id'];
    // echo $item_id;
    $SELECT_NEW_ARRIVALS = "SELECT * FROM item WHERE item_id = '$item_id';";
    $new_arrivals = $conn->query($SELECT_NEW_ARRIVALS);
?>


<body>
       <div class="item-details">
            <?php 
                while($item = mysqli_fetch_assoc($new_arrivals)):
            ?>
            <div class="item-img">
                <img src="<?= $item['Img'];?>"/>
            </div>
            <div class="item-view">
                <p class="item-view-name"><?= $item['Name'];?></p>
                <p class="item-view-price">$<?= $item['Price'];?></p>
                <p class="item-view-colour"><?= $item['Colour'];?></p>
                <P class="item-view-colour-blob"></p>
                <P class="item-view-size-info">Size:</p>
                <p class="item-view-size"><?= $item['Size'];?></p>
                <button type="submit" class="add-btn">Add to Cart</button>

                <!-- Try to make a toggle for the stuff below -->
                <p class="product-details-title">Product Details:</p>
                <p class="product-details"><?= $item['Description'];?></p>
                <p class="shipping-returns-title">Shipping & returns:</p>
                <p class="shipping-returns"></p>
            </div>
            <?php endwhile; ?>
       </div>
</body>