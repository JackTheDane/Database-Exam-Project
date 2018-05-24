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

    // Get general log. Selects the first 20 argument and event_time of the website user
    $stmtLog = $dbLog->prepare("call get_general_log;");
    $stmtLog->execute();

    $aLog = $stmtLog->fetchAll();

} catch( PDOException $e) {

}