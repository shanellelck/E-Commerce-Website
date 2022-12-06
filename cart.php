<?php include "header.php" ?>
<?php include "connection.php" ?>

<?php
    session_start();    

    $user_id = $_SESSION['user_id'];

    if(!isset($user_id)){
        header('location:login.php');
    };

    // $SELECT_ITEMS_IN_CART = "SELECT * FROM cart_contains_item WHERE Customer_ID ='$user_id';";  // and join with item table too
    $SELECT_ITEMS_IN_CART = "SELECT * FROM cart_contains_item AS C, item AS I, model as M WHERE C.Customer_ID ='$user_id' AND I.Item_ID = C.Item_ID AND I.Model_ID = M.Model_ID;";
    $items_in_cart = $conn->query($SELECT_ITEMS_IN_CART);
    // $TOTAL = "SELECT SUM(Price) FROM cart_contains_item AS C, item AS I WHERE C.Customer_ID ='$user_id' AND I.Item_ID = C.Item_ID;";
    // $total_in_cart = $conn->query($TOTAL);
    // $tot = mysqli_fetch_array($total_in_cart);

    // part below is pulling from CART table for information about 'total'
    $SELECT_FINAL_CART = "SELECT * FROM cart AS C WHERE C.Customer_ID ='$user_id';"; 
    $items_in_final_cart = mysqli_fetch_assoc($conn->query($SELECT_FINAL_CART));
?>

<!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
<head>
    <link rel="stylesheet" type="text/css" href="style-cart.css">
</head>
<div class ="small-container cart-page">
    <h2 style = "font-size: 40px;"> Shopping Cart</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Colour</th>
            <th>Size</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>   
        
        <?php 
            while($item = mysqli_fetch_assoc($items_in_cart)):
        ?>   
        <tr>
            <td>
                <div class= "cart-info">
                    <img src="<?= $item['Image'];?>"/>
                    <div>
                    
                    <p class="item-name-cart"><?= $item['Name'];?></p>
                    <small class="item-price-cart">Price: $<?= $item['Price'];?></small>
                    <br>
                    <?php 
                        $button_name = $item['Item_ID'];
                        if (isset($_POST[$button_name])) {
                            $item_id = $item['Item_ID'];
                            $item_quantity = $item['Quantity_In_Cart'];
                            $item_price = $item['Price'];
                            $REMOVE_FROM_CART = "DELETE FROM cart_contains_item WHERE Item_ID = '$item_id' AND Customer_ID = '$user_id';";
                            $UPDATE_CART = "UPDATE CART SET Total_Price=Total_Price-('$item_price'*'$item_quantity'), Total_Number_Of_Item=Total_Number_Of_Item-'$item_quantity' WHERE Customer_ID = '$user_id';";
                            
                            if (($conn->query($UPDATE_CART)) && ($conn->query($REMOVE_FROM_CART)) == TRUE) {
                                header("location:cart.php");
                            }
                        }
                    ?>
                    <form method="post">
                        <input type="submit" name="<?php echo $button_name; ?>" value="Remove" class="remove-btn">
                    </form>
                    </div>
                </div>
            </td>
            <?php $item_colour = $item['Colour'];
                  $item_size = $item['Size'];
                  $item_quantity = $item['Quantity_In_Cart'];
                  $quantity_avail = $item['Quantity'] ?>
            <td>Colour: <?= $item_colour?></td>
            <td>Size: <?= $item_size?></td>
            <td><input type ="number" value = <?= $item_quantity ?> min = '1' <?= $quantity_avail ?>></td>
            <td>$<?= $item['Price'] * $item['Quantity_In_Cart'];?></td>
        </tr>     
        <?php endwhile; ?>
    </table>
    <br>
    <div class = "total-price">
        <table>
            <?php $items_in_final_cart['Total_Price'] ?>
            <?php $tax = $items_in_final_cart['Total_Price'] * 0.05 ?>
            <tr>
                <td>Subtotal</td>
                <td>$<?= $items_in_final_cart['Total_Price'] ?></td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>$<?= $tax?></td>
            </tr>
            <tr>
                <td>Total</td>
                <td>$<?= $items_in_final_cart['Total_Price'] + $tax ?></td>
            </tr>
        </table>
        <div class =  "checkout-btn">
            <a href = "checkout.php" class = "btn btn-outline-primary">Proceed to checkout</a>
        </div>
    </div>
        
</div>
