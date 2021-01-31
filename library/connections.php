<?php
/*
Proxy connection to PHPmotors database
*/

function phpmotorsConnect() {

    $server = 'mysql';
    $dbname = 'phpmotors';
    $username = 'iClient';
    $password = 'TZKwF2RyWhW4nfUu';
    $dsn = "mysql:host=$server;dbname=$dbname";
    $option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try {
        $link = new PDO($dsn, $username, $password, $option);
        return $link;
        //echo 'It worked!';
    } catch(PDOException $e) {
        header('Location: /phpmotors/view/500.php');
        exit;
        //echo "It didn't work, error: " . $e->getMessage();
    }
    
}
//phpmotorsConnect();

?>