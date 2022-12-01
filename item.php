<?php include "header.php" ?>
<?php include "connection.php" ?>
<?php
    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

    $item_id = $_GET['item_id'];
    
    $SELECT_NEW_ARRIVALS = "SELECT * FROM item WHERE Item_ID = '$item_id';";
    $new_arrivals = $conn->query($SELECT_NEW_ARRIVALS);

    $SELECT_REVIEWS = "SELECT * FROM review WHERE Item_ID = '$item_id';";
    $find_reviews = $conn->query($SELECT_REVIEWS);
    
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
                <div class="review-line">
                    <!-- include the stars here -->
                    <a href="#review-section">Rating</a>
                </div>
                <p class="item-view-colour"><?= $item['Colour'];?></p>
                <P class="item-view-colour-blob"></p>
                <P class="item-view-size-info">Size:</p>
                <p class="item-view-size"><?= $item['Size'];?></p>
                <!-- <button type="submit" class="add-btn">Add to Cart</button> -->
                <!-- add an option for customer to choose quantity -->
                <?php 
                    if (isset($_POST['btn-add-to-cart'])) {
                        $FIND_IN_CART = "SELECT * FROM CART_CONTAINS_ITEM WHERE Item_ID = '$item_id' AND Customer_ID = '$user_id';";  // check if item added is already in the cart, then just update quantity
                        $item_price = $item['Price'];
                        $UPDATE_FINAL_CART = "UPDATE CART SET Total_Price=Total_Price+$item_price, Total_Number_Of_Item=Total_Number_Of_Item+1 WHERE Customer_ID = '$user_id';";
                        $item_in_cart = $conn->query($FIND_IN_CART);
                        if (mysqli_fetch_array($item_in_cart)) {
                            $UPDATE_CART  = "UPDATE cart_contains_item SET Quantity=Quantity+1 WHERE Item_ID = '$item_id' AND Customer_ID = '$user_id';";
                            if ($conn->query($UPDATE_CART)  && $conn->query($UPDATE_FINAL_CART) == TRUE) {
                                echo "Item added to cart successfully!";
                              } else {
                                echo "Error: " . $ADD_TO_CART . "<br>" . $conn->error;
                              }
                        } else {
                            $ADD_TO_CART = "INSERT INTO CART_CONTAINS_ITEM VALUES ('$item_id', '$user_id', '1');";
                            $item_price = $item['Price'];
                            $CREATE_FINAL_CART = "INSERT INTO CART VALUES ('$user_id', '$item_price', '1');";
                            $UPDATE_FINAL_CART = "UPDATE CART SET Total_Price=Total_Price+$item_price, Total_Number_Of_Item=Total_Number_Of_Item+1 WHERE Customer_ID = '$user_id';";
                            if ($conn->query($ADD_TO_CART) && ($conn->query($CREATE_FINAL_CART) || $conn->query($UPDATE_FINAL_CART))) {
                                echo "Item added to cart successfully!";
                              } else {
                                echo "Error 2: " . $ADD_TO_CART . "<br>" . $conn->error;
                              }
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
       <div class="recommended-items">
            <!-- include sql statements here to find similar items -->
       </div>
       <div id="review-section" class="review-details">
            <p>Reviews</p>
            <div class="review-summary">
                <div class="stars">
                    <a href="#5stars"></a>
                </div>
                <form method="post">
                    <input type="submit" name="btn-write" value="Write a Review" class="write-btn">
                </form>
            </div>
            <?php 
                while($review = mysqli_fetch_assoc($find_reviews)):
            ?>
            <p class="review-title"><?= $review['Title'] ?></p>
            <p class="review-para"><?= $review['Comment'] ?></p>
            <?php endwhile; ?>
        </div>
       <?php if ($_SESSION['user_type'] == 'admin'): ?>
       <div class="admin-btn">
            <form method="post">
                <input type="submit" name="btn-update" value="Update" class="update-btn">
            </form>
            <form method="post">
                <input type="submit" name="btn-remove" value="Remove" class="remove-btn">
            </form>
       </div>
       <?php endif; ?>
</body>