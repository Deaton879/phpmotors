<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>
<main class="child_page_main"> 
    <nav>
        <?php echo $navList; ?> 
    </nav>

    <!-- Log-in Form -->

    <h1>Sign In</h1>
    <?php
    if (isset($message)) {
    echo $message;
    }
    ?>
    <form action="/phpmotors/accounts/index.php" method="post" class="login_register">
        <label for="clientEmail">Email</label><br>
        <input type="email" id="clientEmail" name="clientEmail" <?php if(isset($clientEmail)){echo "value='$clientEmail'";}  ?> required><br>
        <label for="clientPassword">Password</label>
        <br><span class="passParam">*(Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character)</span><br>
        <input type="password" id="clientPassword" name="clientPassword" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
        <input type="hidden" id="action" name="action" value="login">
        <input type="submit" value="Submit">
    </form> 
    <div class="clickLink"><a href="/phpmotors/accounts?action=register" title="Register a new account" id="newAccount">Not a member yet?</a></div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>
