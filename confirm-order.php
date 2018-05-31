<?php 


// _config
require_once '_config.php';

if( empty($_GET['iProductId']) ){
    returnHome();
}

// Redirects user to New User screen, if not logged in
if( empty($_SESSION['iUserId']) ){
    header('Location: sign-up.php?redir=view-product.php?iProductId='.$_GET['iProductId']);
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

// Get user
try{
    // Get everything from the user and joined city
    $stmt = prepareBindValuesExecute('SELECT users.*, cities.* FROM users 
        INNER JOIN cities ON users.iCityId = cities.iId 
        WHERE users.iId = :iUserId;', [':iUserId' => $_SESSION['iUserId']]);

    $aUser = $stmt->fetch();

} catch(PDOException $ex) {
    echo $ex;
    exit();
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

            <h2 class="mb-4">
                Shipping information
            </h2>

            <form method="post" action="">
                <div class="form-row">
                    <div class="col-md-12">
                        <label for="">Name</label>
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="sFirstName" id="sFirstName" placeholder="Your first name" value="<?php echo $aUser['sFirstName']; ?>" disabled>
                    </div>

                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="sLastName" id="sLastName" placeholder="Your last name" value="<?php echo $aUser['sLastName']; ?>" disabled>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-12">
                        <label for="">Address</label>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" class="form-control" name="sAddress" id="sAddress" placeholder="Address" value="<?php echo $aUser['sAddress']; ?>" disabled>
                    </div>
                </div>


                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="">City</label>
                        <input type="text" class="form-control" name="sName" id="sName" placeholder="City" value="<?php echo $aUser['sName']; ?>" disabled>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Zip Code</label>
                        <input type="text" class="form-control" name="iZipCode" id="iZipCode" placeholder="Zip code" value="<?php echo $aUser['iZipCode']; ?>" disabled>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-md-5 offset-md-1 d-flex flex-column align-items-center">
            <div>
                <img src="product_images/<?php echo $sProductImage; ?>" class="mx-auto" style="max-height:200px;">
            </div>
            <h1 class="mb-3">
                <?php echo $aProduct['sName'] ?>
            </h1>
            <h3>
                <?php echo $aProduct['rPrice'] ?> kr
            </h3>
            <p class="my-4 mb-5 text-center">
                <?php echo $sDescription ?>
            </p>
            <a href="buy-product.php?iProductId=<?php echo $aProduct['iId'] ?>" class="btn btn-block btn-success btn-lg">
                Confirm purchase
            </a>
        </div>
    </div>
</div>


<?php include_once 'components/_footer.php'; ?>