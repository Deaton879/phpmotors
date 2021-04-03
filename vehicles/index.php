<?php
// Create or access a Session
session_start();
// Get the dtabase connection file
require_once '../library/connections.php';
// Get the acme model
require_once '../model/main-model.php';
// Include the vehicle-model 
require_once '../model/vehicles-model.php';
// Get the functions library
require_once '../library/functions.php';
// Include the reviews-model
require_once '../model/reviews-model.php';
// Include the accounts-model
require_once '../model/accounts-model.php';

// Get car classification names for creating Navigation, and id's for use in the form select element. 
$classifications = getClassifications();
// Create the navigation bar
$navList = buildNav($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'vehicle':
        $message='<span id="formSpan">*Note all fields are Required*</span>';
        include '../view/add-vehicle.php';
        break;

    case 'addVehicle':
        // Create variables to store all the form's data fields
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);

        // Notify user all fields must be completed if form is submitted prematurely.
        if(empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription)
                || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<span id="formSpan">*Please fill all empty fields in the form*</span>';
            include '../view/add-vehicle.php';
            exit;
        }
        // Send data to the Model
        $regVehicle = regVehicle($classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor);

        // Check and report the result
        if($regVehicle === 1){
            $message = "<span #formSpan>The $invMake $invModel was added successfully!</span>";
            include '../view/add-vehicle.php';
            exit;
        } else {
            $message = "<span #formSpan>*Did not successfully add a new vehicle*</span>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;
        
    case 'newClassification':
        include '../view/add-classification.php';
        break;

    case 'addClassification':
        // Store the new Vehicle Classification
        $classificationName = filter_input(INPUT_POST, 'classificationName', FILTER_SANITIZE_STRING);

        if(empty($classificationName)) {
            $message = '<span id="formSpan">*Enter the new vehicle classification*</span>';
            include '../view/add-classification.php';
            exit;
        }
        // Send data to the model
        $regClass = regClassification($classificationName);
        // Check and report the result
        if($regClass === 1){
            include
            header('Location: ../vehicles/index.php');
            exit;
        } else {
            $message = "<span #formSpan>*Did not successfully add a new classification*</span>";
            include '../view/add-classification.php';
            exit;
        }
        break;

    /* * ********************************** 
    * Get vehicles by classificationId 
    * Used for starting Update & Delete process 
    * ********************************** */ 
    case 'getInventoryItems': 
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId); 
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray); 
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if(count($invInfo)<1){
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-update.php';
        exit;
        break;

    case 'del':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $invInfo = getInvItemInfo($invId);
        if (count($invInfo) < 1) {
		    $message = 'Sorry, no vehicle information could be found.';
	    }
	    include '../view/vehicle-delete.php';
	    exit;
        break;

    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        
        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            //echo $classificationId, $invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor;
            $message = '<p>Please complete all information to update the vehicle! Double check the classification of the vehicle.</p>';
            include '../view/vehicle-update.php';
            exit;
        }
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        if ($updateResult) {
            $message = "<p>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p>Error. The new vehicle was not updated.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
        break;


    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_STRING);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        
        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations the, $invMake $invModel was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invMake $invModel was not
        deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;

    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_STRING);
        $vehicles = getVehiclesByClassification($classificationName);
        if(!count($vehicles)){
            $message = "<p class='notice'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehicleDisplay = buildVehicleDisplay($vehicles, $classificationName);
        }
        //echo $vehicleDisplay;
        //exit;
        include '../view/classification.php';
        break;

    // Display specific vehicle view
    case 'inv-display':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $carId = getInvItemInfo($invId);
        $class = getClassName($carId['classificationId']);
        $thumbnails = getThumbnails($invId);
        $reviews = getReviewsByInventoryId($invId);
        $screenNames = array();

        
        foreach($reviews as $review) {
            $client = buildScreenName($review["clientId"]);
            
            $screenName = substr($client['clientFirstname'], 0,1) . $client['clientLastname'];
            array_push($screenNames, $screenName);
        }

        if(!$carId) {
            $message = "<p class='notice'>Sorry, we're having trouble finding that vehicle in our inventory.<br> Please try again later.</p>";
            
        }else {$infoDisplay = buildVehicleDetails($carId, $class['classificationName'], $thumbnails, $reviews, $screenNames);}
        
        include '../view/vehicle-detail.php';
        break;

    default:
        $classificationList = buildClassificationList($classifications);

        include '../view/vehicle-man.php';
        break;
}
?>