<?php 
// _config
require_once '_config.php';

if( empty($_GET['iCategoryId']) ){
    returnHome();
}

$iCategoryId = $_GET['iCategoryId'];

try{
    prepareBindValuesExecute('UPDATE product_categories SET isActive = 0 WHERE iId = :iCategoryId', [':iCategoryId' => $iCategoryId]);
} catch( PDOException $ex ){

}

header('Location: view-categories.php');