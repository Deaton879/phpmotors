<?php
require_once '../library/connections.php';
require_once '../model/main-model.php';
// Include the vehicle-model 
require_once '../model/vehicles-model.php';

// Get car classification names for creating Navigation, and id's for use in the form select element. 
$classifications = getClassifications();
// Create the navigation bar
$navList = '<ul>';
$navList .= "<li><a href='../index.php' title='View the PHP Motors home page'>Home</a></li>";

foreach ($classifications as $classification) {
    $navList .= "<li><a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}
$navList .= '</ul>';

// Create the (dropdown) select element listing classificationName with Id linked to each element's value attribute
$classificationList = '<label for="classificationId">Class</label><br>';
$classificationList .= '<select name="classificationId" id="classificationId">';
foreach ($classifications as $classification) {
    $classificationList .= "<option value='$classification[classificationId]'>$classification[classificationName]</option>";
}
$classificationList .= '</select>';

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
        $classificationId = filter_input(INPUT_POST, 'classificationId');
        $invMake = filter_input(INPUT_POST, 'invMake');
        $invModel = filter_input(INPUT_POST, 'invModel');
        $invDescription = filter_input(INPUT_POST, 'invDescription');
        $invImage = filter_input(INPUT_POST, 'invImage');
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail');
        $invPrice = filter_input(INPUT_POST, 'invPrice');
        $invStock = filter_input(INPUT_POST, 'invStock');
        $invColor = filter_input(INPUT_POST, 'invColor');

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
        $classificationName = filter_input(INPUT_POST, 'classificationName');

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