<?php

// database
require_once 'database.php';

// read
try {
    
    $sRead = $db->prepare( 'SELECT * FROM test' );
    $sRead->execute();
    $aUsers = $sRead->fetchAll();
    foreach( $aUsers as $aUser ){
        echo "ID: {$aUser['iId']} - NAME: {$aUser['sName']}";
    }

} catch( PDOException $ex ) {
    echo 'EXCEPTION';
    exit();
}
