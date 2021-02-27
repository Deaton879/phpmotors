<?php
    // If no user (with a minimum clientLevel of 3) is logged in, re-route to the home page 
    if(!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] < 3 ) {
        header('Location: /phpmotors');
    }
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>

<nav>
    <?php echo $navList; ?> 
</nav>

<main class="child_page_main">
    <h1>Vehicle Management</h1>
    <ul id="adminList">
        <li><b class="listBold"><a href="/phpmotors/vehicles?action=classification" title="Add a new car classification to the database">Add Classification</a></b></li>
        <li><b class="listBold"><a href="/phpmotors/vehicles?action=vehicle" title="Add a new car to the database">Add Vehicle</a></b></li>
    </ul>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>