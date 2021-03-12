<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="UTF-8">
    <title><?php echo $classificationName; ?> vehicles | PHP Motors, Inc.</title>
    <link href="/phpmotors/css/styles.css" type="text/css" rel="stylesheet" media="screen">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div id="wrapper">
        <header>
            <div id="top-header">
                <img src="/phpmotors/images/site/logo.png" alt="PHP Motors logo" id="logo">
                <div id="accountLinks">
                    <?php 
                        if($_SESSION['loggedin']) {
                            echo "<span id='welcome'><a href='/phpmotors/accounts?action=admin' title='Account Management'>Welcome ", $_SESSION['clientData']['clientFirstname'],"</a></span>";
                            echo "<a href='/phpmotors/accounts?action=logout' title='Logout from your account'>Logout</a>";
                        }
                        else {
                            echo "<a href='/phpmotors/accounts?action=login' title='Login or Register with PHP Motors'>My Account</a>";
                        }
                    ?>
                    
                </div>
            </div>
        </header>
        
