<?php 
// Point to Composer's autoloader
    require_once 'vendor/autoload.php';

    // Connect
    $m = new MongoDB\Client("mongodb://localhost:27017");

    // Selecting the database
    $mdb = $m->dbexam;
?>