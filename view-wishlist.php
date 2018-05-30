<?php 
// Set currentPage
$currentPage = 'view-wishlist';

// _config
require_once '_config.php';

try{
    // Get wishlist
    $query = 'SELECT iProductId FROM user_wishlist WHERE iUserId = :iUserId';

    $stmt = prepareBindValues($query, [':iUserId' => $_SESSION['iUserId']]);

    if( $stmt->execute() ){
        // Returns flat array
        $aaProductsInWishlist = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);

        if( !empty($aaProductsInWishlist) ){

            $sProductsInWishlist = implode(',', $aaProductsInWishlist);
    
            // Get list of all users
            try {
    
                $query = "SELECT products.iId, products.sName, products.rPrice, product_images.sImgPath
                FROM products
                LEFT JOIN product_images ON products.iId = product_images.iProductId
                WHERE isActive = 1 AND products.iId IN ($sProductsInWishlist)";
    
                $stmt = $db->prepare($query);
    
                $stmt->execute();
    
                $aaProducts = $stmt->fetchAll();
    
            } catch( PDOException $ex ) {
                echo $ex;
                exit();
            }
        } else {
            $aaProducts = [];
        }

    }

} catch( PDOException $ex ) {
    echo $ex;
    exit();
}



include_once 'components/_header.php'; ?>


<div class="container mt-5">
    <div id="productCards" class="row">
        <?php foreach ($aaProducts as $aProduct) {
            
            $sProductImage = $aProduct['sImgPath'] !== null ? $aProduct['sImgPath'] : 'standardProductImage.png';
            
            ?>
            <div class="col-md-4">
                <div class="card" style="width: 18rem;">

                    <?php if( in_array( $aProduct['iId'], $aaProductsInWishlist ) ){ ?>
                        <a href="delete-product-from-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&sReturnPage=view-wishlist" class="btn btn-info btnAddToWishlist">
                            <i class="fas fa-heart"></i>
                        </a>
                    <?php } else { ?>
                        <a href="add-product-to-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&sReturnPage=view-wishlist" class="btn btn-outline-info btnAddToWishlist">
                            <i class="far fa-heart"></i>
                        </a>
                    <?php } ?>

                    

                    <a href="view-product.php?iProductId=<?php echo $aProduct['iId'] ?>">
                        <div class="card-img-top" style="background-image: url('product_images/<?php echo $sProductImage; ?>')"></div>
                        <div class="card-body">
                            <h5 class="card-title mb-0"><?php echo $aProduct['sName'] ?> <span><?php echo $aProduct['rPrice'] ?> kr</span></h5>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<?php include_once 'components/_footer.php'; ?>