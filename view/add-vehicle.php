<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>



<main class="child_page_main">
    <nav>
        <?php echo $navList; ?> 
    </nav>
    <h1>Add Vehicle</h1>
    <?php
    if (isset($message)) {
    echo $message;
    }
    ?>
    <form action="/phpmotors/vehicles/index.php" method="POST">
        <!-- *Select* Class -->
        <?php echo $classificationList; ?><br>
        <!-- Make -->
        <label for="invMake">Make</label><br>
        <input type="text" id="invMake" name="invMake" value=""><br>
        <!-- Model -->
        <label for="invModel">Model</label><br>
        <input type="text" id="invModel" name="invModel" value=""><br>
        <!-- Description -->
        <label for="invDescription">Description</label><br>
        <textarea rows="5" cols="22" id="invDescription" name="invDescription"></textarea><br>
        <!-- Image Path -->
        <label for="invImage">Image Path</label><br>
        <input type="text" id="invImage" name="invImage" value="/phpmotors/images/no-image.png"><br>
        <!-- Image Thumbnail Path -->
        <label for="invThumbnail">Thumbnail Path</label><br>
        <input type="text" id="invThumbnail" name="invThumbnail" value="/phpmotors/images/no-image.png"><br>
        <!-- Price -->
        <label for="invPrice">Price</label><br>
        <input type="text" id="invPrice" name="invPrice" value=""><br>
        <!-- # in Stock -->
        <label for="invStock"># in Stock</label><br>
        <input type="text" id="invStock" name="invStock" value=""><br>
        <!-- Color -->
        <label for="invColor">Color</label><br>
        <input type="text" id="invColor" name="invColor" value=""><br>
        
        <input type='submit' value="Add Vehicle">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="addVehicle">
    </form>





    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>