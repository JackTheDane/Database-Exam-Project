<?php 
// _config
require_once '_config.php';

if( empty($_GET['iProductId']) ){
    returnHome();
}

$iProductId = $_GET['iProductId'];

try{
    prepareBindValuesExecute('UPDATE user_wishlist SET isActive = 0 WHERE iProductId = :iProductId AND iUserId = :iUserId', [':iProductId' => $iProductId, ':iUserId' => $_SESSION['iUserId']]);
} catch( PDOException $ex ){
    exit();
}

if( isset(  $_GET['sReturnPage']) ){

    if( $_GET['sReturnPage'] === 'view-product' ){
        header("Location: view-product.php?iProductId=$iProductId");
    } else if( $_GET['sReturnPage'] === 'view-wishlist' ){ 
        header("Location: view-wishlist.php");
    } else {
        returnHome();
    }

} else {
    returnHome();
}
