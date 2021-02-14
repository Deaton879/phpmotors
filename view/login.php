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
    <form action="/phpmotors/accounts/" method="post" class="login_register">
        <label for="clientEmail">Email</label><br>
        <input type="email" id="clientEmail" name="clientEmail" value=""><br>
        <label for="clientPassword">Password</label><br>
        <input type="password" id="clientPassword" name="clientPassword" value=""><br>
        <input type="submit" value="Submit">
    </form> 
    <div class="clickLink"><a href="/phpmotors/accounts?action=register" title="Register a new account" id="newAccount">Not a member yet?</a></div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>
