<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>

<nav>
    <?php echo $navList; ?> 
</nav>

<main class="child_page_main">
    <h1>Add Car Classification</h1>
    <?php
    if (isset($message)) {
    echo $message;
    }
    ?>
    <form action="/phpmotors/vehicles/index.php" method="POST">
        <label for="classificationName">Classification Name</label><br>
        <input type="text" name="classificationName" id="classificationName" <?php 
        if (isset($invMake)) {
            echo "value='$invStock'";
        }
        ?> required><br><br>
        <input type="submit" name="submit" value="Add Classification">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="addClassification">
    </form>
    

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>