<?php
    // If no user is logged in, re-route to the home page 
    if(!$_SESSION['loggedin']) {
        header('Location: /phpmotors');
    }
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/vehicle-update-header.php'; ?>
<nav>
    <?php echo $navList; 
        $date = $review['reviewDate'];
        $date = date("j F\, Y");
    ?> 
</nav>

<main class="child_page_main">
    <h1><?php echo "Delete " . $car . " Review"; ?></h1>
    <p class="subHead"><?php echo "<i>Reviewed on " . $date . "</i>" ?></p><br>
    <p class="error">Deletes cannot be undone. Are you sure you want to continue?</p>


    <form class="marginal" action="/phpmotors/reviews/index.php" method="POST">

    <!-- Description -->
        <label for="deleteReview">Review Text</label><br>
        <textarea id="deleteReview" name="deleteReview" readonly><?php 
        if (isset($text)) {
            echo $text;
        }
        ?></textarea><br>
        <input type='submit' value="Delete">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="deleteReview">
        <input type="hidden" name="confirmation" value="Your review hast been successfully deleted.">
        <input type="hidden" name="reviewId" <?php echo 'value="' . $reviewId . '" ' ?> >
    </form>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>