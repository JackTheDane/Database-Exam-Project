<?php

function returnHome(){
    header("Location: index.php");
}

session_start();

$debugMode = true;

// Utility functions
function prepareBindValues($sQuery, $aValuesToBind = null){
    global $db;

    $stmt = $db->prepare($sQuery);
    
    // Checks that an array of values has been passed
    if( !empty($aValuesToBind) && is_array($aValuesToBind) ){

        // If so, bind the values
        foreach ($aValuesToBind as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    }

    return $stmt;
}

function prepareBindValuesExecute($sQuery, $aValuesToBind = null){
    $stmt = prepareBindValues($sQuery, $aValuesToBind);

    $stmt->execute();

    return $stmt;
}

// database
require_once 'database/database.php';