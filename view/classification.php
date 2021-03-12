<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>
<nav>
    <?php echo $navList; ?> 
</nav>

<main class="child_page_main">
    <h1><?php echo $classificationName; ?> vehicles</h1>

    <?php if(isset($message)){ echo $message; }?>
    <?php if(isset($vehicleDisplay)){ echo $vehicleDisplay; }?>
    
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>