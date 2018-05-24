<?php 

// _config
require_once '_config.php';

if( empty($_GET['iProductId']) ){
    returnHome();
}

$iProductId = $_GET['iProductId'];

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

    $db->commit();

} catch( PDOException $ex ){
    echo $ex;
}

returnHome();