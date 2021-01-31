<<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>
<main> 
    <nav>
        <?php echo $navList; ?> 
    </nav>

    <!-- Register Form -->
    <h1 class="formHeading">Register</h1>
    <form action="/phpmotors/accounts/index.php" class="login_register">
        <label for="clientFirstname">First Name</label><br>
        <input type="text" id="clientFirstname" name="clientFirstname" value=""><br>
        <label for="clientLastname">Last Name</label><br>
        <input type="text" id="clientLastname" name="clientLastname" value=""><br>
        <label for="clientEmail">Email</label><br>
        <input type="text" id="clientEmail" name="clientEmail" value=""><br>
        <label for="clientPassword">Password</label><br>
        <input type="text" id="clientPassword" name="clientPassword" value=""><br>
        <input type="submit" value="Register">
    </form> 
    <?php echo $message; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>