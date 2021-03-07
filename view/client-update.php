<?php
    // If no user (with a minimum clientLevel of 3) is logged in, re-route to the home page 
    if(!$_SESSION['loggedin']) {
        header('Location: /phpmotors');
    }
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/header.php'; ?>

<main class="child_page_main">
    <nav>
        <?php echo $navList; ?> 
    </nav>
    <h1>Update Account Information</h1>
    <div class="marginal">
        <h3>Update Contact Info</h3>

        <!-- -->
        <?php 
        if (isset($message)) {
            echo $message;
        }
        ?>
        <form action="/phpmotors/accounts/index.php" method="POST">
            <label for="clientFirst">First Name</label><br>
            <input type="text" id="clientFirst" name="clientFirst" required value="<?php if(isset($clientFirst)){echo $clientFirst;} elseif(isset($_SESSION['clientData']['clientFirstname'])){echo $_SESSION['clientData']['clientFirstname'];} ?>"><br>
            <label for="clientLast">Last Name</label><br>
            <input type="text" id="clientLast" name="clientLast" required value="<?php if(isset($clientLast)){echo $clientLast;} elseif(isset($_SESSION['clientData']['clientLastname'])){echo $_SESSION['clientData']['clientLastname'];} ?>"><br>
            <label for="clientE">Email</label><br>
            <input type="email" id="clientE" name="clientE" required value="<?php if(isset($clientE)){echo $clientE;}  elseif(isset($_SESSION['clientData']['clientEmail'])){echo $_SESSION['clientData']['clientEmail'];} ?>"><br>
            <br><input type="submit" value="Update Info" class="form-button">
            <input type="hidden" name="action" value="newPersonal">
            <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId'];?>">
        </form>
        <?php 
        if (isset($message1)) {
            echo $message1;
        }
        ?>
        <br><h3>Update Password</h3>
        <form action="/phpmotors/accounts/index.php" method="POST">
            <span><b>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</b></span><br>
            <br><span><b>* Note, existing password will be replaced upon submission.</b></span><br>
            <br><label for="clientPass">Password</label><br>
            <input type="password" id="clientPass" name="clientPass" required pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"><br>
            <br><input type="submit" value="Update Password" class="form-button">
            <input type="hidden" name="action" value="newPass">
            <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId'];?>">
        </form>
    </div>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/modules/footer.php'; ?>