<?php 
// Set currentPage
$currentPage = 'view-wishlist';

// _config
require_once '_config.php';

try{

    $query = "SELECT products.iId, products.sName, products.rPrice, product_images.sImgPath
    FROM products
    LEFT JOIN product_images ON products.iId = product_images.iProductId
    INNER JOIN user_wishlist ON user_wishlist.iUserId = :iUserId AND products.iId = user_wishlist.iProductId
    WHERE isActive = 1";

    $stmt = prepareBindValuesExecute($query, [':iUserId' => $_SESSION['iUserId']]);

    $aaProducts = $stmt->fetchAll();

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
                    <a href="delete-product-from-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&redir=view-wishlist.php" class="btn btn-info btnAddToWishlist">
                        <i class="fas fa-heart"></i>
                    </a>

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