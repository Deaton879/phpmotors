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
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/vehicle-delete-header.php'; ?>

<main class="child_page_main">
    <nav>
        <?php echo $navList; ?> 
    </nav>
    <h1><?php 
        if(isset($invInfo['invMake']) && isset($invInfo['invModel'])){ 
            echo "Delete $invInfo[invMake] $invInfo[invModel]";} 
        elseif(isset($invMake) && isset($invModel)) { 
            echo "Delete $invMake $invModel"; }
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
        <input type="text" name="invMake" id="invMake" readonly <?php if(isset($invMake)){ echo "value='$invMake'"; } elseif(isset($invInfo['invMake'])) {echo "value='$invInfo[invMake]'"; }?>><br>
        <!-- Model -->
        <label for="invModel">Model</label><br>
        <input type="text" name="invModel" id="invModel" readonly <?php if(isset($invModel)){ echo "value='$invModel'"; } elseif(isset($invInfo['invModel'])) {echo "value='$invInfo[invModel]'"; }?>><br>
        <!-- Description -->
        <textarea name="invDescription" id="invDescription" readonly ><?php if(isset($invDescription)){ echo $invDescription; } elseif(isset($invInfo['invDescription'])) {echo $invInfo['invDescription']; }?></textarea><br>

        <input type="submit" name="submit" value="Delete Vehicle">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="deleteVehicle">
        <input type="hidden" name="invId" value="<?php if(isset($invInfo['invId'])){ echo $invInfo['invId'];}?>">
    </form>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/vehicle-update-footer.php'; ?>