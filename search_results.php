<?php include "header.php" ?>
<?php include "connection.php" ?>

<?php
    session_start();    

    $user_id = $_SESSION['user_id'];
    $user_type = $_SESSION['user_type'];
    if(!isset($user_id)){
        header('location:login.php');
    };

    $search_word = $_GET['search_word'];
    // echo $search_word;
    // $SELECT_WHERE_WORDS = "SELECT * FROM item WHERE Category_ID ='SSH';";
    $SELECT_WHERE_WORDS = "SELECT * FROM `item` WHERE description LIKE '%$search_word%'";
    
    $find_words = $conn->query($SELECT_WHERE_WORDS);

    if(mysqli_num_rows($find_words) < 0) {
        echo "Sorry, no matches found...";
    }
?>

<body>
    <section id="new-arrivals">
        <h1>New Arrivals</h1>
        <div class="search-results">
            <?php 
                while($item = mysqli_fetch_assoc($find_words)):
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
</body>
<footer>
<a>About Us</a>
<a>Contact Us</a>
</footer>