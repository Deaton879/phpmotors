<?php
// THIS IS THE REVIEWS CONTROLLER

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

// Get car classification names for creating Navigation, and id's for use in the form select element. 
$classifications = getClassifications();
// Create the navigation bar
$navList = buildNav($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {

    // Add a new review
    case 'addReview':

        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);
        
        // Send data to the model
        $addRev = addNewReview($reviewText, $invId, $clientId);
        // Check and report the result
        if($addRev === 1){
            header('Location: /phpmotors/vehicles/?action=inv-display&invId=' . urlencode($invId)); 
            exit;
        } else {
            $message = "<span #formSpan>*Did not successfully post the review*</span>";
            header('location: /phpmotors/accounts/?action=admin');
            exit;
        }
        break;

    // Edit a review
    case 'editReview':
        $text = filter_input(INPUT_GET, 'text', FILTER_SANITIZE_STRING);
        $car = filter_input(INPUT_GET, 'car', FILTER_SANITIZE_STRING);
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        include "../view/edit-review.php";
        break;

    // Handle the review update
    case 'updateReview':

        $confirmation = filter_input(INPUT_POST, 'confirmation', FILTER_SANITIZE_STRING);
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $updateReview = updateReview($reviewText, $reviewId);

        if(!$updateReview === 1) {
            $_SESSION['message'] = "We are unable to process your request at this time.";
            header('location: /phpmotors/accounts/?action=admin');
            exit;
        } else {
            $_SESSION['message'] = $confirmation;
            header('location: /phpmotors/accounts/?action=admin');
            exit;
        }

        
        break;

    // Confirm action to delete a review
    case 'confirmDelete':
        $text = filter_input(INPUT_GET, 'text', FILTER_SANITIZE_STRING);
        $car = filter_input(INPUT_GET, 'car', FILTER_SANITIZE_STRING);
        $reviewId = filter_input(INPUT_GET, 'reviewId', FILTER_SANITIZE_NUMBER_INT);

        include '../view/delete-review.php';
        break;

    // Handle the deleting of a review
    case 'deleteReview':
        $confirmation = filter_input(INPUT_POST, 'confirmation', FILTER_SANITIZE_STRING);
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $deleteReview = deleteReview($reviewId);

        if (!$deleteReview === 1) {
            $_SESSION['message'] = "We are unable to delete your review at this time.";
            header('location: /phpmotors/accounts/?action=admin');
            exit;
        } else {
            $_SESSION['message'] = $confirmation;
            header('location: /phpmotors/accounts/?action=admin');
            exit;
        }
        break;

    // Default statement
    default:
        include '../view/login.php';
        break;
}
?>