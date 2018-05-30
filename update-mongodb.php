<?php

/******* MySQL *******/

// _config
require_once '_config.php'; // Contains MySQL connection as $db

/******* MongoDB *******/

require_once 'database/mongo-db.php';

// Selecting the collection we want to manipulate
$cProducts = $mdb->products;

$aaSQLProducts = [];
$aaSQLProductCategories = [];

try{
    $query = 'SELECT * FROM all_product_data';
    
    $stmt = prepareBindValues($query);
    
    
    if( ($stmt->execute()) ){
        $aaSQLProducts = $stmt->fetchAll();

        // Get all product_categories
        $query = 'SELECT * FROM product_category_relationships_with_names';
        $stmt = prepareBindValuesExecute($query);
        $aaSQLProductCategories = $stmt->fetchAll();

        for ($i=0; $i < count($aaSQLProducts); $i++) {

            // Convert iNumberInStore to an integer
            $aaSQLProducts[$i]['iNumberInStore'] = intval( $aaSQLProducts[$i]['iNumberInStore'] );

            foreach ($aaSQLProductCategories as $aProductCategory) {
                $iCategoryId = $aProductCategory['iCategoryId'];
                $sCategoryName = $aProductCategory['sName'];

                
                if( $aProductCategory['iProductId'] === $aaSQLProducts[$i]['iId'] ){
                    
                    if( array_key_exists('ajCategories', $aaSQLProducts[$i]) && is_array( $aaSQLProducts[$i]['ajCategories'] ) ){
                        array_push( $aaSQLProducts[$i]['ajCategories'], json_decode( '{"iId": "'.$iCategoryId.'", "sName": "'.$sCategoryName.'" }' ) );
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

// Get product categories
try{
    $query = 'SELECT iId, sName FROM product_categories WHERE isActive = 1';
    $stmt = prepareBindValuesExecute($query);

    $aaProductCategories = $stmt->fetchAll();
} catch(PDOException $ex) {
    echo $ex;
    exit();
}

try{
    $cProductCategories = $mdb->product_categories;

    $cProductCategories->deleteMany(
        []
    );

    $cProductCategories->insertMany(
        $aaProductCategories
    );
} catch(PDOException $ex) {
    echo $ex;
    exit();
}

returnHome();