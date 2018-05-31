<?php 
// Set currentPage
$currentPage = 'home';

// _config
require_once '_config.php';

// Get all GET parameters previously passed
$aUrlQuery = $_GET;

// Get list of all users
try {

    /******* MongoDB *******/
    require_once 'database/mongo-db.php';

    // Selecting the collection we want to manipulate
    $cProducts = $mdb->products;

    $sSearch = '';
    $options = [];
    $mdbQueryOptions = [];

    // Check for search parameters
    if( !empty( $_GET['orderBy'] ) ){

        if( $_GET['orderBy'] == 'highestPrice' ){
            $aSortBy = [
                'rPrice' => -1
            ];

        } else if ( $_GET['orderBy'] == 'lowestPrice') {
            $aSortBy = [
                'rPrice' => 1
            ];
        }

        // Set query options
        $options['sort'] = $aSortBy;
    }

    // Getting and array of arrays from the collection
    if( !empty($_GET['sSearch']) ){
        $sSearch = $_GET['sSearch'];

        $mdbQueryOptions['sName'] = [ '$regex' => '/*'.$sSearch.'/*', '$options' => 'i' ];
    }

    if( !empty($_GET['productCategoryId']) ){
        $productCategoryId = $_GET['productCategoryId'];

        $mdbQueryOptions['ajCategories'] = [
            '$elemMatch' => [
                "iId" => $productCategoryId
            ]
        ];
    }

    $aaProducts = $cProducts->find(
        $mdbQueryOptions,
        $options
    );

    // $query = 'SELECT products.iId, products.sName, products.rPrice, product_images.sImgPath
    // FROM products
    // LEFT JOIN product_images ON products.iId = product_images.iProductId
    // WHERE isActive = 1';

    // $stmt = prepareBindValuesExecute($query);
    // $aaProducts = $stmt->fetchAll();

    // Max price, min price, categories, search

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
} else {
    $aaProductsInWishlist = [];
}

// Get product categories
try{
    $ajProductCategories = [];

    $cProductCategories = $mdb->product_categories;

    // Return categories
    $ajProductCategories = $cProductCategories->find();

} catch( PDOException $ex ) {
    echo $ex;
    exit();
}

include_once 'components/_header.php'; ?>


<div class="container mt-5">
    <!-- Search bar -->
    <div class="row">
        <div class="col-sm-12 mb-4">
            <form class="d-flex" method="GET" action="index.php">
                <?php foreach ($aUrlQuery as $key => $value) {
                    if( $key != 'sSearch' ){
                        echo "<input type='hidden' name='$key' value='$value'>";
                    }
                } ?>

              <input class="form-control mr-sm-2" type="search" name="sSearch" placeholder="Search by name" value="<?php echo $sSearch; ?>">
              <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
        <div class="col-sm-12 mb-4 d-flex justify-content-end">
            <div>
                <span>
                    Sort by:
                </span>
                <?php
                    // Temp query, as to not interfere with primray HTTP Query
                    $aTempUrlQuery = $aUrlQuery;
                ?>

                <a href="?<?php $aTempUrlQuery['orderBy'] = 'lowestPrice'; echo http_build_query($aTempUrlQuery); ?>" class="mx-1<?php if( !empty( $_GET['orderBy'] )){ if( $_GET['orderBy'] == 'lowestPrice' ){echo ' disabled';} }  ?>">Lowest Price</a>
                <a href="?<?php $aTempUrlQuery['orderBy'] = 'highestPrice'; echo http_build_query($aTempUrlQuery); ?>" class="<?php if( !empty( $_GET['orderBy'] )){ if( $_GET['orderBy'] == 'highestPrice' ){echo 'disabled';} }  ?>">Highest Price</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <div id="productCategorySelection" class="card bg-light">
                <div class="card-header">Categories</div>
                <ul class="card-body mb-0">
                <?php
                foreach ($ajProductCategories as $jCategory) { 
                    $aTempUrlQuery = $aUrlQuery;    
                ?>
                    
                    <li>
                        <a href="?<?php $aTempUrlQuery['productCategoryId'] = $jCategory['iId']; echo urlencode(http_build_query($aTempUrlQuery)); ?>" class="<?php if( !empty( $_GET['productCategoryId'] )){ if( $_GET['productCategoryId'] == $jCategory['iId'] ){echo 'disabled';} }  ?>">
                            <?php echo $jCategory['sName']; ?>
                        </a>
                    </li>

                <?php } ?>
                </ul>
            </div>
            <a href="index.php" class="btn btn-block mt-4 btn-outline-success">Reset filters</a>
        </div>
        <div class="col-md-10">
            <div id="productCards" class="row">
                <?php foreach ($aaProducts as $aProduct) {
                    
                    $sProductImage = $aProduct['sImgPath'] !== null ? $aProduct['sImgPath'] : 'standardProductImage.png';
                    
                    ?>
                    <div class="col-md-4 mb-5">
                        <div class="card" style="width: 16rem;">
        
                            <?php if( !empty( $_SESSION['iUserId'] ) ){
                             if( in_array( $aProduct['iId'], $aaProductsInWishlist ) ){ ?>
                                <a href="delete-product-from-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&redir=index.php?<?php echo http_build_query($aUrlQuery); ?>" class="btn btn-info btnAddToWishlist">
                                    <i class="fas fa-heart"></i>
                                </a>
                            <?php } else { ?>
                                <a href="add-product-to-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&redir=index.php?<?php echo http_build_query($aUrlQuery); ?>" class="btn btn-outline-info btnAddToWishlist">
                                    <i class="far fa-heart"></i>
                                </a>
                            <?php } 
                            } ?>
        
                            <a href="view-product.php?iProductId=<?php echo $aProduct['iId'];?>" <?php if( $aProduct['iNumberInStore'] <= 0 ){ echo 'class="outOfStock"'; }?>>
                                <div class="card-img-top" style="background-image: url('product_images/<?php echo $sProductImage; ?>')"></div>
                                <div class="card-body">
                                    <h5 class="card-title mb-0"><?php echo $aProduct['sName'] ?> <span><?php echo $aProduct['rPrice'] ?> kr</span></h5>
                                </div>
                            </a>
                        </div>
        
                        <?php if($isAdmin){ ?>
                        <div class="row no-gutters" style="width: 16rem; margin-left:auto; margin-right:auto;">
                            <a href="edit-product.php?iProductId=<?php echo $aProduct['iId']; ?>" class="btn col btn-info">Edit</a>
                            <a href="delete-product.php?iProductId=<?php echo $aProduct['iId']; ?>" class="btn col btn-danger">Delete</a>                        
                        </div>
                        <?php } ?>
        
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>


<?php include_once 'components/_footer.php'; ?>