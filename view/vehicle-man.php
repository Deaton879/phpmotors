<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>

<nav>
    <?php echo $navList; ?> 
</nav>

<main>
    <h1>Vehicle Management</h1>
    <ul>
        <li><a href="/phpmotors/vehicles?action=classification" title="Add a new car classification to the database">Add Classification</a></li>
        <li><a href="/phpmotors/vehicles?action=vehicle" title="Add a new car to the database">Add Vehicle</a></li>
    </ul>
    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>