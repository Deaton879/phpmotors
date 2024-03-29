<?php
    // If no user (with a minimum clientLevel of 3) is logged in, re-route to the home page 
    if(!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] < 3 ) {
        header('Location: /phpmotors');
    }
?>
<?php // Create the (dropdown) select element listing classificationName with Id linked to each element's value attribute
$classificationList = '<label for="classificationId">Class</label><br>';
$classificationList .= '<select name="classificationId" id="classificationId" required>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'";
    if(isset($classificationId)) {
        if($classification['classificationId'] === $classificationId) {
            $classificationList .= ' selected ';
        }
    }
    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .= '</select>'; ?>
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
        <input type="text" id="invMake" name="invMake" <?php 
        if (isset($invMake)) {
            echo "value='$invMake'";
        }
        ?> required><br>
        <!-- Model -->
        <label for="invModel">Model</label><br>
        <input type="text" id="invModel" name="invModel" <?php 
        if (isset($invModel)) {
            echo "value='$invModel'";
        }
        ?> required><br>
        <!-- Description -->
        <label for="invDescription">Description</label><br>
        <textarea rows="5" cols="22" id="invDescription" name="invDescription" required><?php 
        if (isset($invDescription)) {
            echo "$invDescription";
        }
        ?></textarea><br>
        <!-- Image Path -->
        <label for="invImage">Image Path</label><br>
        <input type="text" id="invImage" name="invImage" value="/phpmotors/images/no-image.png" <?php 
        if (isset($invImage)) {
            echo "value='$invImage'";
        }
        ?> required><br>
        <!-- Image Thumbnail Path -->
        <label for="invThumbnail">Thumbnail Path</label><br>
        <input type="text" id="invThumbnail" name="invThumbnail" value="/phpmotors/images/no-image.png" <?php 
        if (isset($invThumbnail)) {
            echo "value='$invThumbnail'";
        }
        ?> required><br>
        <!-- Price -->
        <label for="invPrice">Price</label><br>
        <input type="text" id="invPrice" name="invPrice" <?php 
        if (isset($invPrice)) {
            echo "value='$invPrice'";
        }
        ?> required><br>
        <!-- # in Stock -->
        <label for="invStock"># in Stock</label><br>
        <input type="text" id="invStock" name="invStock" <?php 
        if (isset($invStock)) {
            echo "value='$invStock'";
        }
        ?> required><br>
        <!-- Color -->
        <label for="invColor">Color</label><br>
        <input type="text" id="invColor" name="invColor" <?php 
        if (isset($invColor)) {
            echo "value='$invColor'";
        }
        ?> required><br>
        
        <input type='submit' value="Add Vehicle">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="addVehicle">
    </form>





    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>