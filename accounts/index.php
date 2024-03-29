<?php
// Accounts controller
// Create or access a Session
session_start();
require_once '../library/connections.php';

require_once '../model/main-model.php';
// Get the accounts model
require_once '../model/accounts-model.php';
// Get the functions library
require_once '../library/functions.php';
// Get the reviews model
require_once '../model/reviews-model.php';
// Get the vehicles model
require_once '../model/vehicles-model.php';

$classifications = getClassifications();
// Create the navigation bar
$navList = buildNav($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {

    case 'login':
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientEmail = checkEmail($clientEmail);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $passwordCheck = checkPassword($clientPassword);

        // Run basic checks, return if errors
        if (empty($clientEmail) || empty($passwordCheck)) {
            $message = '<p class="notice">Please provide a valid email address and password.</p>';
            include '../view/login.php';
            exit;
        }
        
        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error
        // and return to the login view
        if(!$hashCheck) {
            $message = '<p class="notice">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        /*Delete the firstname cookie
        unset($_COOKIE[$cookieFirstname]);*/
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        // Send them to the admin view
        header('location: /phpmotors/accounts/?action=admin');
        exit;

    case 'newacct':
        include '../view/register.php';
        break;
        
    case 'register':
        /*
        echo 'You are in the register case statement.';
        break;
        */    
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        
        $clientEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);
        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if($existingEmail){
            $message = '<p class="notice">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }
        // Check for any missing data
        if(empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($checkPassword)) {
            $message = '<span id="formSpan">*Please fill all empty fields in the form.</span>';
            include '../view/register.php';
            exit;
        }
        
        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        // Send the data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);
        
        // Check and report the result
        if($regOutcome === 1){
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $_SESSION['message'] = "Thanks for registering $clientFirstname. Please use your email and password to login.";
            header('Location: /phpmotors/accounts/?action=login');
            exit;
        } else {
            $message = "<p>Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        break;

    // ADMIN case 
    case 'admin':
        $clientId = $_SESSION['clientData']['clientId'];
        $oldReviews = getAllReviews($clientId);
        $cars = array();
        if ($_SESSION['loggedin']) {            
            // Get the car make/model for each review, and create an array containing the car titles for each review
            foreach($oldReviews as $review) {
                print_r($review['reviewId']);
                $carInfo = getInvItemInfo($review['invId']);
                $carName = $carInfo["invMake"] . " " . $carInfo["invModel"];
                array_push($cars, $carName);
            }
            
            $buildPastReviews = buildPastReviews($oldReviews, $cars);
            include '../view/admin.php';
            break;
        } else { 
            header('Location: /phpmotors');
        }
        break;

    case 'updateClient':
        include '../view/client-update.php';
        break;

    case 'newPersonal':

        $clientFirst = filter_input(INPUT_POST, 'clientFirst', FILTER_SANITIZE_STRING);
        if($clientFirst != $_SESSION['clientData']['clientFirstname']) {
            $_SESSION['clientData']['clientFirstname'] = $clientFirst;
        }

        $clientLast = filter_input(INPUT_POST, 'clientLast', FILTER_SANITIZE_STRING);
        if($clientLast != $_SESSION['clientData']['clientLastname']) {
            $_SESSION['clientData']['clientLastname'] = $clientLast;
        }

        
        $clientE = filter_input(INPUT_POST, 'clientE', FILTER_SANITIZE_EMAIL);    
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        // Check for any missing data
        if(empty($clientFirst) || empty($clientLast) || empty($clientE)) {
            $message = '<span id="formSpan">*Please fill all empty fields in the form.</span>';
            include '../view/client-update.php';
            exit;
        }

        if($clientE != $_SESSION['clientData']['clientEmail']) {
            $clientE = checkEmail($clientE);
            $existingE = checkExistingEmail($clientE);
            // Check for existing email address in the table
            if($existingE = 0){
                $message = '<p class="notice">That email address is already in use. Please try again.</p>';
                include '../view/client-update.php';
                exit;
            }
            else {
                $_SESSION['clientData']['clientEmail'] = $clientE;
                
            }
            
        } 

        // Send the data to the model
        $updatedOutcome = updateClient($clientFirst, $clientLast, $clientE, $clientId);
        
        // Check and report the result
        if($updatedOutcome === 1){
            $_SESSION['message'] = "<b>$clientFirst, you've successfully updated your account information.</b>";
            header('Location: /phpmotors/accounts/?action=admin');
            exit;
        } else {
            $_SESSION['message'] = "<b>Sorry, but we could not update your information at this time. Please try again later.</b>";
            include '../view/admin.php';
            exit;
        }

        break;


    case 'newPass':

        $clientPass = filter_input(INPUT_POST, 'clientPass', FILTER_SANITIZE_STRING);
        $checkPass = checkPassword($clientPass);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        
        // Check for any missing data
        if(empty($checkPass)) {
            $message1 = '<span id="formSpan">*Please submit a new password to proceed.</span>';
            include '../view/client-update.php';
            exit;
        }

        $idData = getClientById($clientId);

        // Hash the checked password
        $hashPass = password_hash($clientPass, PASSWORD_DEFAULT);

        // Send the data to the model
        $updatePass = updatePass($hashPass, $clientId);
        
        // Check and report the result
        if($updatePass === 1){
            $_SESSION['message'] = " $idData[clientFirstname], your password has been succesfully updated.";
            header('Location: /phpmotors/accounts/?action=admin');
            exit;
        } else {
            $_SESSION['message'] = "<p>Sorry, but we could not update your password at this time. Please try again later.</p>";
            include '../view/admin.php';
            exit;
        }

        break;


    // LOGOUT case
    case 'logout':
        // Unset all of the session variables.
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();
    default:
        include '../view/login.php';
        break;
}
?>