<?php include "header.php" ?>
<?php include "connection.php" ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style-checkout.css">

</head>
<body>
<?php 
    session_start();
   
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
    }else{
        $user_id ='';
        header('location:index.php');
    }
  
?>
    <h1 class="title">Welcome to The Store</h1>
    
    <div class ="small-container order-page">
       <style>
        
.flex-container{
    width: auto;
    height: auto;
    display: flex;
    flex-direction: row;
    flex-wrap: wrap;
    justify-content:center;
}
.flex-box{
    width: auto;
    height:auto;
    font-size:20px;
    text-align: center;
    border-radius: 20px;
    margin: 10px;
    border: .2rem solid black;

}
.flex-child{
    flex:1;
    width: auto;
    height:auto;
    font-size:20px;
    text-align: center;
    border-radius: 20px;
    margin: 10px;
    border: .2rem solid black;

}
.flex-child: first-child{
    margin-right: 20px;
}
</style>
        <div class="flex-container">
        
            <div class = "flex-box">
                <p>We are proud to bring a special shopping experience to Calgary. Since 2014, The Store continues to be different from other retail stores with our beautiful store displays, carefully curated boutique clothing for all ages, and locally sourced featured products. Visit us in-store or shop online and find our collection of Clothing and Gifts.</p> 
                    <p>Locally Owned and Operated in Calgary, AB.</p>
            </div>
            <div class = "flex-child" align = "left" style = "width:50%">
                <h3>Store Hours</h3>
                <p>Monday: Closed</p>
                <p>Tuesday to Friday: 11:00 am - 6:00 pm</p>
                <p>Saturday: 11:00 am - 5:00 pm</p>
                <p>Sunday: 11:00 am - 4:00 pm</p>
            </div>
            <div class = "flex-child" style = "width:50%"   align = "right">
                <h3>Store location</h3>
                <p><i class="fas fa-map-marker-alt"></i><span><?php echo " 3625 Shaganappi Trail NW, Calgary, AB T3A 0E2";?></span></p>
                <p>Phone: 403-457-4778</p>
                <p>Email: info@TheStore.com</p>
            </div>
        </div>
    </div>
</body>
</html>


