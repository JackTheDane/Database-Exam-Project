<?php

function returnHome(){
    header("Location: index.php");
}

$debugMode = true;

$sqlQuery = '';

// Utility functions
function prepareAndBindSQL($sQuery, $aValuesToBind = null){
    global $sqlQuery;
    global $db;

    $stmt = $db->prepare($sQuery);
    
    if( !empty($aValuesToBind) && is_array($aValuesToBind) ){

        foreach ($aValuesToBind as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        
        // Make a second variable, with the prepared SQL Query as a string
        $sqlQuery = strtr($sQuery, $aValuesToBind);
    } else {
        $sqlQuery = $sQuery;
    }

    return $stmt;
}

// database
require_once 'database/database.php';