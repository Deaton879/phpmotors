<<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>
<main> 
    <nav>
        <?php echo $navList; ?> 
    </nav>

    <!-- Register Form -->
    <h1 class="formHeading">Register</h1>

    <?php 
    if (isset($message)) {
        echo $message;
    }
    ?>
    
    <form method="post" action="/phpmotors/accounts/index.php" class="login_register">
        <label for="clientFirstname">First Name</label><br>
        <input type="text" id="clientFirstname" name="clientFirstname" id="fname" value=""><br>
        <label for="clientLastname">Last Name</label><br>
        <input type="text" id="clientLastname" name="clientLastname" id="lname" value=""><br>
        <label for="clientEmail">Email</label><br>
        <input type="email" id="clientEmail" name="clientEmail" id="email" value=""><br>
        <label for="clientPassword">Password</label><br>
        <input type="password" id="clientPassword" name="clientPassword" id="password" value=""><br>
        <input type="submit" value="Register">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="register">
    </form> 
    <?php echo $message; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>