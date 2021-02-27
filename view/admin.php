<?php
    // If no user logged in, re-route to the home page
    if(!$_SESSION['loggedin']) {
        header('Location: /phpmotors');
    }
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>
<nav>
    <?php echo $navList; ?> 
</nav>

<main class="child_page_main">
    <h1><?php echo $_SESSION['clientData']['clientFirstname'], " ", $_SESSION['clientData']['clientLastname'] ?></h1>
    <p id="loggedin">You are logged in.</p>
    <ul id="adminList">
        <li><?php echo '<b class="listBold">First Name: </b><i class="listItalic">', $_SESSION['clientData']['clientFirstname'], "</i>" ?></li>
        <li><?php echo '<b class="listBold">Last Name: </b><i class="listItalic">', $_SESSION['clientData']['clientLastname'], "</i>" ?></li>
        <li><?php echo '<b class="listBold">Email Address: </b><i class="listItalic">', $_SESSION['clientData']['clientEmail'], "</i>" ?></li>
        <li><?php echo '<b class="listBold">Admin Level: </b><i class="listItalic">', $_SESSION['clientData']['clientLevel'], "</i>" ?></li>
        <?php 
            if($_SESSION['clientData']['clientLevel'] > 1) {
                echo "<li><a href='/phpmotors/vehicles/' title='Click to manage vehicles'>Manage Vehicles</a></li>";
            }
        ?>
    </ul>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>