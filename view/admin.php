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
    <?php 
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        echo "<p class='error'>", $message, "</p>";
    }
    ?>
    <ul id="adminList">
        <li><?php echo '<b class="listBold">First Name: </b><i class="listItalic">', $_SESSION['clientData']['clientFirstname'], "</i>" ?></li>
        <li><?php echo '<b class="listBold">Last Name: </b><i class="listItalic">', $_SESSION['clientData']['clientLastname'], "</i>" ?></li>
        <li><?php echo '<b class="listBold">Email Address: </b><i class="listItalic">', $_SESSION['clientData']['clientEmail'], "</i>" ?></li>
    </ul><br>
    <div class="marginal"><h2>Account Management</h2><p>Use the link below to manage your account information.</p>
    <span><a href="/phpmotors/accounts?action=updateClient" title="Click to manage your account">Update Account Info</a></span></div>
    <?php 
            if($_SESSION['clientData']['clientLevel'] > 1) {
                echo "<div class='marginal'><h2>Vehicle Management</h2><p>Use the link below to administer inventory</p>
                <span><a href='/phpmotors/vehicles/' title='Click to manage vehicles'>Manage Vehicles</a></span></div>";
            }
        ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>