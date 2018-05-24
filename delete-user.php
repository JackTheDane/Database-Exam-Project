<?php 
// _config
require_once '_config.php';

if( empty($_GET['iUserId']) ){
    returnHome();
}

$iUserId = $_GET['iUserId'];

try{
    prepareBindValuesExecute('UPDATE users SET isActive = 0 WHERE iId = :iUserId', [':iUserId' => $iUserId]);
} catch( PDOException $ex ){

}

returnHome();