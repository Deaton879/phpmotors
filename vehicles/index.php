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

// Get car classification names for creating Navigation, and id's for use in the form select element. 
$classifications = getClassifications();
// Create the navigation bar
$navList = buildNav($classifications);

// Create the (dropdown) select element listing classificationName with Id linked to each element's value attribute
/*
$classificationList = '<label for="classificationId">Class</label><br>';
$classificationList .= '<select name="classificationId" id="classificationId" required>';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
}
$classificationList .= '</select>';
*/

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
        
    case 'classification':
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

    default:
        include '../view/vehicle-man.php';
        break;
}
?>