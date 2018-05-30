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


