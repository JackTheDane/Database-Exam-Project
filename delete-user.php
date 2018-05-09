<?php 

require_once 'database.php';

function returnHome(){
    header("Location: index.php");
}

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