<?php 
// _config
require_once '_config.php';

if( empty($_GET['iProductId']) ){
    returnHome();
}

$iProductId = $_GET['iProductId'];

try{
    $query = 'INSERT INTO user_wishlist (iUserId, iProductId) VALUES(:iUserId, :iProductId)';

    prepareBindValuesExecute($query, [':iProductId' => $iProductId, ':iUserId' => $_SESSION['iUserId']]);
} catch( PDOException $ex ){
    echo $ex;
    exit();
}

if( !empty( $_GET['redir']) ){
    
    header("Location: ".$_GET['redir']);

} else {
    returnHome();
}