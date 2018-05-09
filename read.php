<?php

// database
require_once 'database.php';

// read
try {
    
    $stmt = $db->prepare( 'SELECT * FROM test' );
    $stmt->execute();
    $aUsers = $stmt->fetchAll();
    foreach( $aUsers as $aUser ){
        echo "ID: {$aUser['iId']} - NAME: {$aUser['sName']}";
    }

} catch( PDOException $ex ) {
    echo 'EXCEPTION';
    exit();
}
