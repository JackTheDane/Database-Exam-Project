<?php 
// Set currentPage
$currentPage = 'home';

// _config
require_once '_config.php';

if( empty($_GET['iProductId']) ){
    returnHome();
}

$iProductId = $_GET['iProductId'];


// Get list of all users
try {

    /******* MongoDB *******/
    require_once 'database/mongo-db.php';

    // Selecting the collection we want to manipulate
    $cProducts = $mdb->products;

    // Getting and array of arrays from the collection
    $aProduct = $cProducts->findOne(
        ['iId' => $iProductId]
    );

    // $query = "SELECT products.iId, products.sName, products.rPrice, products.iNumberInStore, product_images.sImgPath, product_descriptions.sDescription
    // FROM products
    // LEFT JOIN product_images ON products.iId = product_images.iProductId
    // LEFT JOIN product_descriptions ON products.iId = product_descriptions.iProductId
    // WHERE products.iId = $iProductId
    // AND products.isActive = 1";

    // $stmt = prepareBindValuesExecute($query);
    // $aProduct = $stmt->fetch();

} catch( PDOException $ex ) {
    echo $ex;
    exit();
}

if( !empty( $_SESSION['iUserId'] ) ){
    try{
        // Get wishlist
        $query = 'SELECT iProductId FROM user_wishlist WHERE iUserId = :iUserId';
    
        $stmt = prepareBindValuesExecute($query, [':iUserId' => $_SESSION['iUserId']]);
    
        // Returns flat array
        $aaProductsInWishlist = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
    
    } catch( PDOException $ex ) {
        echo $ex;
        exit();
    }
}


include_once 'components/_header.php'; ?>


<div class="container mt-5">
    <div id="product" class="row">
        <?php

            if( $aProduct['sImgPath'] !== null ){
                $sProductImage = $aProduct['sImgPath'];
            } else {
                $sProductImage = 'standardProductImage.png';
            }

            $sDescription = $aProduct['sDescription'] !== null ? $aProduct['sDescription'] : '';
            
            ?>
        <div class="col-md-6">
            <h1 class="mb-3">
                <?php echo $aProduct['sName'] ?>
            </h1>
            <h3>
                <?php echo $aProduct['rPrice'] ?> kr
            </h3>
            <p class="my-5">
                <?php echo $sDescription ?>
            </p>
            <div class="d-flex align-items-end mb-3">
                <?php if( $aProduct['iNumberInStore'] <= 0 ){ ?>
                <a href="" class="btn btn-success btn-lg disabled">
                    Out of stock
                </a>
                <?php } else { ?>
                <a href="confirm-order.php?iProductId=<?php echo $aProduct['iId'] ?>" class="btn btn-success btn-lg">
                    Buy item
                </a>
                <?php } ?>

                <?php if( !empty( $_SESSION['iUserId'] ) ){
                if( in_array( $aProduct['iId'], $aaProductsInWishlist ) ){ ?>
                    <a href="delete-product-from-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&redir=view-product.php?iProductId=<?php echo $aProduct['iId']; ?>" class="btn ml-3 btn-info">
                        <i class="fas fa-heart"></i>
                        Remove from wishlist
                    </a>
                <?php } else { ?>
                    <a href="add-product-to-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&redir=view-product.php?iProductId=<?php echo $aProduct['iId']; ?>" class="btn ml-3 btn-outline-info">
                        <i class="far fa-heart"></i>
                        Add to wishlist
                    </a>
                <?php } 
                } ?>
            </div>
            <small>På lager: <?php echo $aProduct['iNumberInStore']; ?></small>

        </div>
        <div class="col-md-4 offset-md-2">
            <img src="product_images/<?php echo $sProductImage; ?>">
        </div>
    </div>
</div>


<?php include_once 'components/_footer.php'; ?>