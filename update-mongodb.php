<?php

/******* MySQL *******/

// _config
require_once '_config.php';

/******* MongoDB *******/

// Point to Composer's autoloader
require_once 'vendor/autoload.php';

// Connect
$m = new MongoDB\Client("mongodb://localhost:27017");

// Selecting the database
$mdb = $m->dbexam;

// Selecting the collection we want to manipulate
$cProducts = $mdb->products;

// Getting and array of arrays from the collection
$aaProducts = $cProducts->find();

$aaSQLProducts = [];
$aaSQLProductCategories = [];

try{
    $query = 'SELECT products.iId, products.sName, products.iNumberInStore, products.rPrice, product_descriptions.sDescription, product_images.sImgPath
        FROM products 
        LEFT JOIN product_descriptions
            ON products.iId = product_descriptions.iProductId
        LEFT JOIN product_images
            ON products.iId = product_images.iProductId
        WHERE isActive = 1';
    
    $stmt = prepareBindValues($query);
    
    
    if( ($stmt->execute()) ){
        $aaSQLProducts = $stmt->fetchAll();

        // Get all product_categories
        $query = 'SELECT product_category_relationship.*, product_categories.sName FROM product_category_relationship
        LEFT JOIN product_categories ON product_category_relationship.iCategoryId = product_categories.iId AND product_categories.isActive = 1';
        $stmt = prepareBindValuesExecute($query);
        $aaSQLProductCategories = $stmt->fetchAll();

        for ($i=0; $i < count($aaSQLProducts); $i++) {

            foreach ($aaSQLProductCategories as $aProductCategory) {
                $iCategoryId = $aProductCategory['iCategoryId'];
                $sCategoryName = $aProductCategory['sName'];

                
                if( $aProductCategory['iProductId'] === $aaSQLProducts[$i]['iId'] ){
                    
                    if( array_key_exists('ajCategories', $aaSQLProducts[$i]) && is_array( $aaSQLProducts[$i]['ajCategories'] ) ){
                        array_push( $aaSQLProducts[$i]['ajCategories'], json_decode( '{"iId": "'.$iCategoryId.'", "sName": "'.$sCategoryName.'" }' ) );
                        // print_r($aaSQLProducts[$i]['ajCategories']);
                    } else {
                        $aaSQLProducts[$i]['ajCategories'] = [json_decode( '{"iId": "'.$iCategoryId.'", "sName": "'.$sCategoryName.'" }' )];
                    }
                }
            }
        }

    }

} catch(PDOException $ex) {
    echo $ex;
    exit();
}


// Add items to MongoDB
try{
    $cProducts->deleteMany(
        []
    );

    $cProducts->insertMany(
        $aaSQLProducts
    );
} catch(PDOException $ex) {
    echo $ex;
    exit();
}

returnHome();