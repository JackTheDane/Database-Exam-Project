<?php

function returnHome(){
    header("Location: index.php");
}

if( empty($_POST['sFirstName']) ){
    returnHome();
}

if( empty($_POST['sLastName']) ){
    returnHome();
}

if( empty($_POST['sEmail']) ){
    returnHome();
}

$sFirstName = $_POST['sFirstName'];
$sLastName = $_POST['sLastName'];
$sEmail = $_POST['sEmail'];


require_once 'database.php';

$cUsers->insertOne( ['sFirstName' => $sFirstName, 'sLastName' => $sLastName, 'sEmail' => $sEmail] );

returnHome();