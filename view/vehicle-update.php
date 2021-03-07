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
    } elseif(isset($invInfo['classificationId'])){
        if($classification['classificationId'] === $invInfo['classificationId']){
         $classificationList .= ' selected ';
        }
       }
    $classificationList .= ">$classification[classificationName]</option>";
}
$classificationList .= '</select>'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/vehicle-update-header.php'; ?>

<main class="child_page_main">
    <nav>
        <?php echo $navList; ?> 
    </nav>
    <h1><?php 
        if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
            echo "Modify $invInfo[invMake] $invInfo[invModel]";} 
        elseif(isset($invMake) && isset($invModel)) { 
            echo "Modify $invMake $invModel"; }
        ?></h1>
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
        <input type="text" name="invMake" id="invMake" required <?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>><br>
        <!-- Model -->
        <label for="invModel">Model</label><br>
        <input type="text" name="invModel" id="invModel" required <?php if(isset($invModel)){ echo "value='$invModel'"; } elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>><br>
        <!-- Description -->
        <textarea name="invDescription" id="invDescription" required><?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea><br>
        <!-- Image Path -->
        <label for="invImage">Image Path</label><br>
        <input type="text" id="invImage" name="invImage" <?php if(isset($invImage)){ echo "value='$invImage'"; } elseif(isset($invInfo['invImage'])) {echo "value='$invInfo[invImage]'"; }?> required><br>
        <!-- Image Thumbnail Path -->
        <label for="invThumbnail">Thumbnail Path</label><br>
        <input type="text" id="invThumbnail" name="invThumbnail" <?php if(isset($invThumbnail)){ echo "value='$invThumbnail'"; } elseif(isset($invInfo['invThumbnail'])) {echo "value='$invInfo[invThumbnail]'"; }?> required><br>
        <!-- Price -->
        <label for="invPrice">Price</label><br>
        <input type="text" id="invPrice" name="invPrice" <?php if(isset($invPrice)){ echo "value='$invPrice'"; } elseif(isset($invInfo['invPrice'])) {echo "value='$invInfo[invPrice]'"; }?> required><br>
        <!-- # in Stock -->
        <label for="invStock"># in Stock</label><br>
        <input type="text" id="invStock" name="invStock" <?php if(isset($invStock)){ echo "value='$invStock'"; } elseif(isset($invInfo['invStock'])) {echo "value='$invInfo[invStock]'"; }?> required><br>
        <!-- Color -->
        <label for="invColor">Color</label><br>
        <input type="text" id="invColor" name="invColor" <?php if(isset($invColor)){ echo "value='$invColor'"; } elseif(isset($invInfo['invColor'])) {echo "value='$invInfo[invColor]'"; }?> required><br>
        
        <input type="submit" name="submit" value="Update Vehicle">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="updateVehicle">
        <input type="hidden" name="invId" value="
        <?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];} 
        elseif(isset($invId)){ echo $invId; } ?>
        ">
    </form>





    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/vehicle-update-footer.php'; ?>