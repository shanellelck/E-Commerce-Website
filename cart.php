<?php include "header.php" ?>
<link rel="stylesheet" type="text/css" href="style.css">
<div class ="small-container cart-page">
    <h2 style = "font-size: 40px;"> Shopping Cart</h2>
    <table>
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Subtotal</th>
        </tr>   
        <tr>
            <td>
                <div class= "cart-info">
                <img src = "image1.jpg" >
                    <div>
                        <p> Blue Dress</p>
                        <small>Price: $50.00</small>
                        <br>
                        <a href = "">Remove</a>
                    </div>
                </div>
            </td>
            <td><input type ="number" value = "1"></td>
            <td>$50.00</td>
        </tr>     
        <tr>
            <td>
                <div class= "cart-info">
                <img src = "image1.jpg" >
                    <div>
                        <p> Blue Dress</p>
                        <small>Price: $50.00</small>
                        <br>
                        <a href = "">Remove</a>
                    </div>
                </div>
            </td>
            <td><input type ="number" value = "1"></td>
            <td>$50.00</td>
        </tr>     

    </table>
    <div class = "total-price">
        <table>
            <tr>
                <td>Subtotal</td>
                <td>$100 </td>
            </tr>
            <tr>
                <td>Tax</td>
                <td>$20 </td>
            </tr>
            <tr>
                <td>Total</td>
                <td>$120 </td>
            </tr>
        </table>
</div>
