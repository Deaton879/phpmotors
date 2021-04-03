<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/vehicle-update-header.php'; ?>
<nav>
    <?php echo $navList; ?> 
</nav>

<main id="backToTop" class="vehicle-detail-main">

    <?php if(isset($message)){ echo $message; }?>
    <?php if(isset($infoDisplay)){ echo $infoDisplay; }?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>
