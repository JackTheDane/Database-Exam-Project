<?php require_once 'database/database.php';

try {

    // Custom user for the website with limited access
    $sUserName = 'root';
    $sPassword = '';
    $sConnection = "mysql:host=localhost; dbname=mysql; charset=utf8";

    $aOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    $db = new PDO( $sConnection, $sUserName, $sPassword, $aOptions );

    // Get general log
    $stmt = $db->prepare("SELECT argument, event_time FROM `general_log` WHERE command_type = 'Query' AND user_host LIKE 'website%';");
    $stmt->execute();

    $aLog = $stmt->fetchAll();

    foreach ($aLog as $log ) {
        echo '<div>'.$log['argument'].' Happend at '.$log['event_time'].'</div>';
    }

    } catch( PDOException $e) {
}