<?php 

$aLog = array();

try {

    global $aLog;

    // Custom user for the website with limited access
    $sUserName = 'root';
    $sPassword = '';
    $sConnection = "mysql:host=localhost; dbname=mysql; charset=utf8";

    $aOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    $dbLog = new PDO( $sConnection, $sUserName, $sPassword, $aOptions );

    // Get general log. Selects the first 10 argument and event_time of the website user

    $stmtLog = $dbLog->prepare("SELECT argument, event_time FROM `general_log` WHERE command_type = 'Query' AND user_host LIKE 'website%' ORDER BY event_time DESC LIMIT 10;");
    $stmtLog->execute();

    $aLog = $stmtLog->fetchAll();

} catch( PDOException $e) {

}