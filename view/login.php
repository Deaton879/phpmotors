<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>
<main> 
    <nav>
        <?php echo $navList; ?> 
    </nav>

    <!-- Sign-in Form -->

    <h1 class="formHeading">Sign In</h1>
    <form action="/phpmotors/accounts/" class="login_register">
        <label for="clientEmail">Email</label><br>
        <input type="text" id="clientEmail" name="clientEmail" value=""><br>
        <label for="clientPassword">Password</label><br>
        <input type="text" id="clientPassword" name="clientPassword" value=""><br>
        <input type="submit" value="Submit">
    </form> 
    <div class="clickLink"><a href="/phpmotors/accounts?action=register" title="Register a new account" id="newAccount">Not a member yet?</a></div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>
