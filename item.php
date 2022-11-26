<?php include "header.php" ?>

<?php
    // Create connection
    $servername = "localhost";
    $database = "ecommerce_db";
    $username = "root";
    $password = "";

    // Create connection

    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection

    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }

    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

    $item_id = $_GET['item_id'];
    // echo $item_id;
    $SELECT_NEW_ARRIVALS = "SELECT * FROM item WHERE Item_ID = '$item_id';";
    $new_arrivals = $conn->query($SELECT_NEW_ARRIVALS);

    
?>


<body>
       <div class="item-details">
            <?php 
                while($item = mysqli_fetch_assoc($new_arrivals)):
            ?>
            <div class="item-img">
                <img src="<?= $item['Image'];?>"/>
            </div>
            <div class="item-view">
                <p class="item-view-name"><?= $item['Name'];?></p>
                <p class="item-view-price">$<?= $item['Price'];?></p>
                <p class="item-view-colour"><?= $item['Colour'];?></p>
                <P class="item-view-colour-blob"></p>
                <P class="item-view-size-info">Size:</p>
                <p class="item-view-size"><?= $item['Size'];?></p>
                <!-- <button type="submit" class="add-btn">Add to Cart</button> -->
                <!-- add an option for customer to choose quantity -->
                <?php 
                    if (isset($_POST['btn-add-to-cart'])) {
                        $ADD_TO_CART = "INSERT INTO CART_CONTAINS_ITEM VALUES ('$item_id', 'TEST01234', '1');";
                        // mysqli_query($conn, $ADD_TO_CART);
                        if ($conn->query($ADD_TO_CART) === TRUE) {
                            echo "New record created successfully";
                          } else {
                            echo "Error: " . $ADD_TO_CART . "<br>" . $conn->error;
                          }
                    }
                ?>
                <form method="post">
                    <input type="submit" name="btn-add-to-cart" value="Add to Cart" class="add-btn">
                </form>
                
                <!-- Try to make a toggle for the stuff below -->
                <p class="product-details-title">Product Details:</p>
                <p class="product-details"><?= $item['Description'];?></p>
                <p class="shipping-returns-title">Shipping & returns:</p>
                <p class="shipping-returns"></p>
            </div>
            <?php endwhile; ?>
       </div>
</body>