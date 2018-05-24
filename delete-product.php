<?php 
// _config
require_once '_config.php';

if( empty($_GET['iProductId']) ){
    returnHome();
}

$iProductId = $_GET['iProductId'];

try{
    prepareBindValuesExecute('UPDATE products SET isActive = 0 WHERE iId = :iProductId', [':iProductId' => $iProductId]);
} catch( PDOException $ex ){

}

include_once 'update-mongodb.php';

returnHome();