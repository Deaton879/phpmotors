<?php
// Accounts controller

require_once '../library/connections.php';

require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';

$classifications = getClassifications();
$navList = '<ul>';
$navList .= "<li><a href='../index.php' title='View the PHP Motors home page'>Home</a></li>";

foreach ($classifications as $classification) {
    $navList .= "<li><a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
}

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

$navList .= '</ul>';

switch ($action) {
    case 'login':
        include '../view/login.php';
        break;
    case 'signin':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail');
        $clientPassword = filter_input(INPUT_POST, 'clientPassword');
        echo "clientEmail ", $clientEmail, "<br>clientPassword ", $clientPassword;
        break;
    case 'register':
        /*
        echo 'You are in the register case statement.';
        break;
        */    
        $clientFirstname = filter_input(INPUT_POST, 'clentFirstname');
        $clientLastname = filter_input(INPUT_POST, 'clentLastname');
        $clientEmail = filter_input(INPUT_POST, 'clientEmail');
        $clientPassword = filter_input(INPUT_POST, 'clientPassword');
        // Check for any missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientPassword)) {
            $message = '<span id="formSpan">*Please fill all empty fields in the form.</span>';
            include '../view/register.php';
            exit;
        }
        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword);
        
        // Check and report the result
        if($regOutcome === 1){
            $message = "<p>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            include '../view/login.php';
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        break;
    
    default:
        break;
}
?>