<?php

try {

    // Custom user for the website with limited access
    $sUserName = 'website';
    $sPassword = 'Password123';
    $sConnection = "mysql:host=localhost; dbname=dbexam; charset=utf8";

    $aOptions = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    $db = new PDO( $sConnection, $sUserName, $sPassword, $aOptions );

    } catch( PDOException $e) {

    echo 'error';
    // echo $e;
    exit();

}
