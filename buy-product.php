<?php 

// _config
require_once '_config.php';


if( empty($_GET['iProductId']) ){
    returnHome();
}

// Redirects user to New User screen, if not logged in
if( empty($_SESSION['iUserId']) ){
    header('Location: sign-up.php?redir=view-product.php?iProductId='.$_GET['iProductId']);
}

$iProductId = $_GET['iProductId'];

// MongoDB
require_once 'database/mongo-db.php';

// Selecting the collection we want to manipulate
$cProducts = $mdb->products;

try{
    $db->beginTransaction();

    $query = 'INSERT INTO user_order_history (iId, iUserId, iProductId, rAmountPaid) VALUES(null, :iUserId, :iProductId1, (SELECT rPrice FROM products WHERE iId=:iProductId2))';
    $stmt = prepareBindValues($query, [':iUserId' => $_SESSION['iUserId'], ':iProductId1' => $iProductId, ':iProductId2' => $iProductId]);

    if( !$stmt->execute() ){
        $db->rollBack();
    }

    $query = 'UPDATE products SET iNumberInStore = iNumberInStore-1 WHERE iId = :iProductId AND iNumberInStore > 0';
    $stmt = prepareBindValues($query, [':iProductId' => $iProductId]);

    if( !$stmt->execute() ){
        $db->rollBack();
    }

    // Remove from wishlist
    $query = 'DELETE FROM user_wishlist WHERE iUserId = :iUserId AND iProductId = :iProductId';
    $stmt = prepareBindValues($query, [':iProductId' => $iProductId, ':iUserId' => $_SESSION['iUserId']]);

    if( !$stmt->execute() ){
        $db->rollBack();
    }

    $db->commit();

    // If all queries were successful, decrease number in MongoDB by one
    $cProducts->updateOne(
        ['iId' => $iProductId],
        ['$inc' => [
            'iNumberInStore' => -1
        ]]
    );

} catch( PDOException $ex ){
    echo $ex;
    exit();
}

returnHome();