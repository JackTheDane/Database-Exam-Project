<?php 
// _config
require_once '_config.php';

if( empty($_GET['iProductId']) ){
    returnHome();
}

$iProductId = $_GET['iProductId'];

try{
    $query = 'DELETE FROM user_wishlist WHERE iProductId = :iProductId AND iUserId = :iUserId';
    prepareBindValuesExecute($query, [':iProductId' => $iProductId, ':iUserId' => $_SESSION['iUserId']]);
} catch( PDOException $ex ){
    exit();
}

if( !empty( $_GET['redir']) ){
    
    header("Location: ".$_GET['redir']);

} else {
    returnHome();
}
