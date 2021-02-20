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
        <input type="text" id="clientFirstname" name="clientFirstname" id="fname" <?php if(isset($clientFirstname)){echo "value='$clientFirstname'";}  ?>
 required><br>
        <label for="clientLastname">Last Name</label><br>
        <input type="text" id="clientLastname" name="clientLastname" id="lname" <?php if(isset($clientLastname)){echo "value='$clientLastname'";}  ?>
 required><br>
        <label for="clientEmail">Email</label><br>
        <input type="email" id="clientEmail" name="clientEmail" id="email" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?>
 required><br>
        <label for="clientPassword">Password</label>
        <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span><br>
        <input type="password" id="clientPassword" name="clientPassword" id="password" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
        <input type="submit" value="Register">
        <!-- Add the action name - value pair -->
        <input type="hidden" name="action" value="register">
    </form> 
    <?php echo $message; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>