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
    // $SELECT_WHERE_TYPE = "SELECT * FROM `model` AS M, item AS I WHERE M.description LIKE '%$search_word%' AND I.Model_ID = M.Model_ID AND I.Size = 'S'";
    // $SELECT_WHERE_COLOUR ="SELECT * FROM `item` AS I, model AS M WHERE I.colour LIKE '%$search_word%' AND I.Model_ID = M.Model_ID AND I.Size = 'S'";
    // $find_types = $conn->query($SELECT_WHERE_TYPE);
    // $find_colours = $conn->query($SELECT_WHERE_COLOUR);

    $word = "%$search_word%";
    $stmt_type = $conn->prepare("SELECT * FROM `model` AS M, item AS I WHERE M.description LIKE ? AND I.Model_ID = M.Model_ID AND I.Size = 'S'");
    $stmt_colour = $conn->prepare("SELECT * FROM `item` AS I, model AS M WHERE I.colour LIKE ? AND I.Model_ID = M.Model_ID AND I.Size = 'S'");

    $stmt_type->bind_param("s", $word); // here we can use only a variable
    $stmt_type->execute();

    $stmt_colour->bind_param("s", $word); // here we can use only a variable
    $stmt_colour->execute();

    $result_type = $stmt_type->get_result(); // get the mysqli result
    $row_type = $result_type->fetch_assoc();

    $result_colour = $stmt_colour->get_result(); // get the mysqli result
    $row_colour = $result_colour->fetch_assoc();
?>

<body>
    <section id="new-arrivals">
        <?php if(($row_type) || ($row_colour)): ?>
            <h1>Search results matching: '<?= $search_word ?>'</h1>
        <?php else: ?>
            <h1>Sorry, no matches found for '<?= $search_word ?>'</h1>
        <?php endif; ?>
        <div class="search-results">
            <?php 
                while(($item = $result_type->fetch_assoc()) || ($item = $result_colour->fetch_assoc())):
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