<?php 

function checkEmail($clientEmail) {
    $valEmail = filter_var($clientEmail, FILTER_SANITIZE_EMAIL);
    return $valEmail;
}

// Check the password for a minimum of 8 characters,
// at least one 1 capital letter, at least 1 number and
// at least 1 special character
function checkPassword($clientPassword){
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^\s]){8,}$/';
    return preg_match($pattern, $clientPassword);
}

// Build the Navigation list using the classification information
function buildNav($classifications) {
    // Create the navigation bar
    $navList = '<ul>';
    $navList .= "<li><a href='/phpmotors/' title='View the PHP Motors home page'>Home</a></li>";

    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/vehicles/?action=classification&classificationName=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
    }
    $navList .= '</ul>';

    return $navList;
}

// Build the classifications select list 
function buildClassificationList($classifications){ 
    $classificationList = '<select name="classificationId" id="classificationList">'; 
    $classificationList .= "<option>Choose a Classification</option>"; 
    foreach ($classifications as $classification) { 
        $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>"; 
    } 
    $classificationList .= '</select>'; 
    return $classificationList; 
}


// Get vehicles by classificationId 
function getInventoryByClassification($classificationId){ 
    $db = phpmotorsConnect(); 
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $inventory; 
}

function buildVehicleDisplay($vehicles, $class) {
    $dv = '<ul id="inv-display">';
    
    foreach ($vehicles as $vehicle) {
        $price = number_format($vehicle['invPrice'], 2, '.',',');
        $dv .= '<li>';
        $dv .= "<div class='thumbContainer'><a href='/phpmotors/vehicles?action=inv-display&invId=$vehicle[invId]'><img class='carThumb' src='$vehicle[invThumbnail]' alt='Image of $vehicle[invMake] $vehicle[invModel] on phpmotors.com'></a></div>";
        $dv .= '<hr>';
        $dv .= "<span><a href='/phpmotors/vehicles?action=inv-display&invId=$vehicle[invId]'>$vehicle[invMake] $vehicle[invModel]</a></span>";
        $dv .= "<span>$$price</span>";
        $dv .= '</li>';
    }
    $dv .= '</ul>';
    return $dv;
}

function buildVehicleDetails($carId, $class) {
    $price = number_format($carId['invPrice'], 2, '.',',');
    $dv = "<div class='form'><h2>$carId[invMake] $carId[invModel] </h2>";
    $dv .= "<div class='imgContainer'><img class='carImg' src='$carId[invImage]' alt='image of $carId[invMake] $carId[invModel] on phpmotors.com'></div>";
    $dv .= "<h3 class='price'>Price: $$price </h3>";
    $dv .= "<hr>";
    $dv .= "<div class='description'><p><b>Car Type:</b> $class </p>";
    if ($carId['invDescription']) {
        $dv .= "<p><b>Description:</b> $carId[invDescription] </p>";
    }
    $dv .= "<p><b>Stock:</b> $carId[invStock] </p>";
    $dv .= "<p><b>Color:</b> $carId[invColor] </p></div></div>";

    return $dv;

}
    



?>