<?php
// Get the database connection file
require_once './library/connections.php';
// Get the PHP Motors model for use as needed
require_once './model/main-model.php';
// Get the functions library
require_once './library/functions.php';

// Get car classification names for creating Navigation, and id's for use in the form select element. 
$classifications = getClassifications();
// Create the navigation bar
$navList = buildNav($classifications);

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

switch ($action) {
    case 'template':
        include './view/template.php';
        break;

    default:
        include './view/home.php';
        break;
}
?>
