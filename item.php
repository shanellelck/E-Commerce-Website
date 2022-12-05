<?php include "header.php" ?>
<?php include "connection.php" ?>
<?php
    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

    $item_id = $_GET['item_id'];
    // echo $item_id;
    
    $SELECT_NEW_ARRIVALS = "SELECT * FROM model WHERE Model_ID = '$item_id';";
    $new_arrivals = $conn->query($SELECT_NEW_ARRIVALS);

    $SELECT_MODEL_ITEMS = "SELECT * FROM model AS M, item as I WHERE M.Model_ID = I.Model_ID;";
    $find_model_items = $conn->query($SELECT_MODEL_ITEMS);

    // $SELECT_SIZES = "SELECT * FROM size WHERE Item_ID = '$item_id'";
    // $find_sizes = $conn->query($SELECT_SIZES);

    $SELECT_REVIEWS = "SELECT * FROM review WHERE Model_ID = '$item_id';";
    $find_reviews = $conn->query($SELECT_REVIEWS);

    
?>


<body>
       <div class="item-details">
            <?php 
                while($model = mysqli_fetch_assoc($new_arrivals)):
            ?>
            <div class="item-img">
                <img src="<?= $model['Image'];?>"/>
            </div>
            <div class="item-view">
                <p class="item-view-name"><?= $model['Name'];?></p>
                <p class="item-view-price">$<?= $model['Price'];?></p>
                <div class="review-line">
                    <!-- include the stars here -->
                    <a href="#review-section">Rating</a>
                </div>
                <p class="item-view-colour"><?= $model['Colour'];?></p>
                <P class="item-view-colour-blob"></p>
                <P class="item-view-size-info">Size:</p>
                <div class="sizes">
                   <?php $item = mysqli_fetch_assoc($find_model_items);
                //    this part below might just be nonsense right now so just ignore it
                        if ($size['S'] == NULL || $size['S'] == '0'){
                            $size_s = 'not-available';
                        }else $size_s = 'available';
                        if ($size['M'] == NULL || $size['M'] == '0'){
                            $size_m = 'not-available';
                        }else $size_m = 'available';
                        if ($size['L'] == NULL || $size['L'] == '0'){
                            $size_l = 'not-available';
                        }else $size_l = 'available';
                        if ($size['XL'] == NULL || $size['XL'] == '0'){
                            $size_xl = 'not-available';
                        }else $size_xl = 'available';
                        ?>
                    <?php 
                        
                        if (isset($_POST['btn-size-s'])) {
                            $SELECT_ID = "SELECT * FROM model AS M, item as I WHERE I.Model_ID = '$item_id' AND M.Model_ID = I.Model_ID AND I.Size = 'S';";
                            $find_id = $conn->query($SELECT_ID);
                            $final_id = mysqli_fetch_assoc($find_id);
                            $final_item_id = $final_id['Item_ID'];
                            $final_size = 'S';
                            // echo $final_item_id;           
                        } elseif (isset($_POST['btn-size-m'])) {
                            $SELECT_ID = "SELECT * FROM model AS M, item as I WHERE I.Model_ID = '$item_id' AND M.Model_ID = I.Model_ID AND I.Size = 'M';";
                            $find_id = $conn->query($SELECT_ID);
                            $final_id = mysqli_fetch_assoc($find_id);
                            $final_item_id = $final_id['Item_ID'];
                            $final_size = 'M';
                            // echo $final_item_id;
                        } elseif (isset($_POST['btn-size-l'])) {
                            $SELECT_ID = "SELECT * FROM model AS M, item as I WHERE I.Model_ID = '$item_id' AND M.Model_ID = I.Model_ID AND I.Size = 'L';";
                            $find_id = $conn->query($SELECT_ID);
                            $final_id = mysqli_fetch_assoc($find_id);
                            $final_item_id = $final_id['Item_ID'];
                            $final_size = 'L';
                            // echo $final_item_id;
                        } elseif (isset($_POST['btn-size-xl'])) {
                            $SELECT_ID = "SELECT * FROM model AS M, item as I WHERE I.Model_ID = '$item_id' AND M.Model_ID = I.Model_ID AND I.Size = 'XL';";
                            $find_id = $conn->query($SELECT_ID);
                            $final_id = mysqli_fetch_assoc($find_id);
                            $final_item_id = $final_id['Item_ID'];
                            $final_size = 'XL';
                            // echo $final_item_id;
                        }
                    ?>
                    <form method="post">
                        <input type="submit" name="btn-size-s" value="S" class=<?=$size_s?> >
                        <input type="submit" name="btn-size-m" value="M" class=<?=$size_m?>>
                        <input type="submit" name="btn-size-l" value="L" class=<?=$size_l?>>
                        <input type="submit" name="btn-size-xl" value="XL" class=<?=$size_l?>>
                    </form>

                </div>
                <!-- <button type="submit" class="add-btn">Add to Cart</button> -->
                <!-- add an option for customer to choose quantity -->
                
                <?php 
                    if (isset($_POST['btn-add-to-cart'])) {
                        $final_item_id = $_POST['id'];
                        $final_item_size = $_POST['size'];
                        // echo $final_item_id;
                        // echo $final_item_size;
                        // echo $final_size;
                        // $SELECT_ITEM = "SELECT * FROM model AS M, item as I WHERE M.Model_ID = I.Model_ID, I.size = '$final_size';";
                        // $find_item = $conn->query($SELECT_MODEL_ITEMS);
                        // if (mysqli_fetch_array($find_item)) {
                        //     $item = mysqli_fetch_assoc($find_item);
                        //     $item_id = $item['Item_ID'];
                        //     echo $item_id;
                        // }
                        $FIND_IN_CART = "SELECT * FROM CART_CONTAINS_ITEM WHERE Item_ID = '$final_item_id' AND Customer_ID = '$user_id';";  // check if item added is already in the cart, then just update quantity
                        $item_price = $item['Price'];
                        $UPDATE_FINAL_CART = "UPDATE CART SET Total_Price=Total_Price+$item_price, Total_Number_Of_Item=Total_Number_Of_Item+1 WHERE Customer_ID = '$user_id';";
                        $item_in_cart = $conn->query($FIND_IN_CART);
                        if (mysqli_fetch_array($item_in_cart)) {
                            $UPDATE_CART  = "UPDATE cart_contains_item SET Quantity_In_Cart=Quantity_In_Cart+1 WHERE Item_ID = '$final_item_id' AND Customer_ID = '$user_id';";
                            if ($conn->query($UPDATE_CART)  && $conn->query($UPDATE_FINAL_CART) == TRUE) {
                                echo "Item added to cart successfully";
                              } else {
                                echo "Error: " . $ADD_TO_CART . "<br>" . $conn->error;
                              }
                        } else {
                            $ADD_TO_CART = "INSERT INTO CART_CONTAINS_ITEM VALUES ('$final_item_id', '$user_id', '1', '$final_item_size');";
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
                <!-- <form method="post">
                    <input type="submit" name="btn-add-to-cart" value="Add to Cart" class="add-btn">
                </form> -->
                <?php if ($_SESSION['user_type'] == 'customer'): ?> 
                    <form method="post">
                        <input type="submit" name="btn-add-to-cart" value="Add to Cart" class="add-btn">
                        <input type='hidden' name='id' value='<?=$final_item_id?>'>
                        <input type='hidden' name='size' value='<?=$final_size?>'>
                    </form>
                <?php elseif ($_SESSION['user_type'] == 'admin'): ?>
                    <div class="admin-btn">
                        <form method="post">
                            <input type="submit" name="btn-update" value="Update" class="update-btn">
                        </form>
                        <form method="post">
                            <input type="submit" name="btn-remove" value="Remove" class="remove-btn">
                        </form>
                    </div>
                <?php endif; ?>
                
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
</body>