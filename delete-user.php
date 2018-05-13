<?php 
// _config
require_once '_config.php';

if( empty($_GET['iUserId']) ){
    returnHome();
}

$iUserId = $_GET['iUserId'];

try{
    $stmt = $db->prepare('DELETE FROM users WHERE iId = :iUserId');
    $stmt->bindValue(':iUserId', $iUserId);
    $stmt->execute();
} catch( PDOException $ex ){

}

returnHome();