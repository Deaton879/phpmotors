<?php
    // If no user is logged in, re-route to the home page 
    if(!$_SESSION['loggedin']) {
        header('Location: /phpmotors');
    }
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/vehicle-update-header.php'; ?>
<nav>
    <?php echo $navList; ?> 
</nav>

<main class="child_page_main">
    <h1><?php echo $car . " Review"; ?></h1>

    <form class="marginal" action="/phpmotors/reviews/index.php" method="POST">

    <!-- Description -->
        <label for="reviewText">Review Text</label><br>
        <textarea rows="5" cols="50" id="reviewText" name="reviewText" required><?php 
        if (isset($text)) {
            echo $text;
        }
        ?></textarea><br>
        <input type='submit' value="Confirm Changes">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="updateReview">
        <input type="hidden" name="confirmation" value="You have successfully updated your review!">
        <input type="hidden" name="reviewId" <?php echo 'value="' . $reviewId . '" ' ?> >
    </form>


<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>