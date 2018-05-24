<?php 
// Set currentPage
$currentPage = 'home';

// _config
require_once '_config.php';

// Get list of all users
try {

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
    if( !empty($_GET['sSearch']) ){
        $sSearch = $_GET['sSearch'];

        $aaProducts = $cProducts->find(
            [
                "sName" => [ '$regex' => '/*'.$sSearch.'/*', '$options' => 'i' ] 
            ]
        );
    } else {
        $sSearch = '';
        $aaProducts = $cProducts->find();
    }

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
        $query = 'SELECT iProductId FROM user_wishlist WHERE iUserId = :iUserId AND isActive = 1';
    
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


include_once 'components/_header.php'; ?>


<div class="container mt-5">
    <!-- Search bar -->
    <div class="row">
        <div class="col-sm-12 mb-4">
            <form class="d-flex" method="GET" action="index.php">
              <input class="form-control mr-sm-2" type="search" name="sSearch" placeholder="Search by name" value="<?php echo $sSearch; ?>">
              <button class="btn btn-info my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </div>

    <div id="productCards" class="row">
        <?php foreach ($aaProducts as $aProduct) {
            
            $sProductImage = $aProduct['sImgPath'] !== null ? $aProduct['sImgPath'] : 'standardProductImage.png';
            
            ?>
            <div class="col-md-4 mb-5">
                <div class="card" style="width: 18rem;">

                    <?php if( !empty( $_SESSION['iUserId'] ) ){
                     if( in_array( $aProduct['iId'], $aaProductsInWishlist ) ){ ?>
                        <a href="delete-product-from-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&sReturnPage=index" class="btn btn-info btnAddToWishlist">
                            <i class="fas fa-heart"></i>
                        </a>
                    <?php } else { ?>
                        <a href="add-product-to-wishlist.php?iProductId=<?php echo $aProduct['iId']; ?>&sReturnPage=index" class="btn btn-outline-info btnAddToWishlist">
                            <i class="far fa-heart"></i>
                        </a>
                    <?php } 
                    } ?>

                    <a href="view-product.php?iProductId=<?php echo $aProduct['iId'] ?>">
                        <div class="card-img-top" style="background-image: url('product_images/<?php echo $sProductImage; ?>')"></div>
                        <div class="card-body">
                            <h5 class="card-title mb-0"><?php echo $aProduct['sName'] ?> <span><?php echo $aProduct['rPrice'] ?> kr</span></h5>
                        </div>
                    </a>
                </div>

                <?php if($isAdmin){ ?>
                <div class="row no-gutters" style="width: 18rem; margin-left:auto; margin-right:auto;">
                    <a href="edit-product.php?iProductId=<?php echo $aProduct['iId']; ?>" class="btn col btn-info">Edit</a>
                    <a href="delete-product.php?iProductId=<?php echo $aProduct['iId']; ?>" class="btn col btn-danger">Delete</a>                        
                </div>
                <?php } ?>

            </div>
        <?php } ?>
    </div>
</div>


<?php include_once 'components/_footer.php'; ?>