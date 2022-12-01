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
    $SELECT_WHERE_TYPE = "SELECT * FROM `model` AS M, item AS I WHERE M.description LIKE '%$search_word%' AND I.Model_ID = M.Model_ID AND I.Size = 'S'";
    $SELECT_WHERE_COLOUR ="SELECT * FROM `item` AS I, model AS M WHERE I.colour LIKE '%$search_word%' AND I.Model_ID = M.Model_ID AND I.Size = 'S'";
    $find_types = $conn->query($SELECT_WHERE_TYPE);
    $find_colours = $conn->query($SELECT_WHERE_COLOUR);

?>

<body>
    <section id="new-arrivals">
        <?php if((mysqli_num_rows($find_types) > 0) || (mysqli_num_rows($find_colours) > 0)): ?>
            <h1>Search results matching: '<?= $search_word ?>'</h1>
        <?php else: ?>
            <h1>Sorry, no matches found for '<?= $search_word ?>'</h1>
        <?php endif; ?>
        <div class="search-results">
            <?php 
                while(($item = mysqli_fetch_assoc($find_types)) || ($item = mysqli_fetch_assoc($find_colours))):
            ?>
            <div class="item">
                <?php $item_id = $item['Model_ID'] ?>
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