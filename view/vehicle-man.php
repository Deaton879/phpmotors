<?php
    // If no user (with a minimum clientLevel of 3) is logged in, re-route to the home page 
    if(!$_SESSION['loggedin'] || $_SESSION['clientData']['clientLevel'] < 2 ) {
        header('Location: /phpmotors');
        exit;
    }
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
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
    <div class="marginal">
        <?php
            if (isset($message)) { 
            echo $message; 
            } 
            if (isset($classificationList)) { 
            echo '<h2>Vehicles By Classification</h2>'; 
            echo '<p>Choose a classification to see those vehicles</p>'; 
            echo $classificationList; } 
        ?>
        <noscript>
            <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
        </noscript>
        <table id="inventoryDisplay"></table>
    </div>
    
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/vehicle-man-footer.php'; ?>