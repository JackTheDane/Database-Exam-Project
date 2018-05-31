<?php require_once '_config.php';

$iProductId = $_GET['iProductId'];
$iUserid = $_SESSION['iUserId'];

// Checks if a new information has been passed to the page
if( isset($_POST['sName']) || isset($_POST['rPrice']) || isset($_POST['iNumberInStore']) ){
    
    try{

        // iId, sName, iNumberInStore, rPrice, 
        $sName = $_POST['sName'];
        $rPrice = $_POST['rPrice'];
        $iNumberInStore = $_POST['iNumberInStore'];
    
        $db->beginTransaction();

        $query = 'UPDATE products SET sName = :sName, rPrice = :rPrice, iNumberInStore = :iNumberInStore WHERE iId = :iProductId';
        
        $stmt = prepareBindValues($query, [':sName' => $sName, ':rPrice' => $rPrice, ':iNumberInStore' => $iNumberInStore, ':iProductId' => $iProductId]);

        if($stmt->execute()){

            if( isset($_POST['sDescription']) ){
                $sDescription = $_POST['sDescription'];

                $query = 'INSERT INTO product_descriptions VALUES(null, :iProductId, :sDescription1) ON DUPLICATE KEY UPDATE sDescription = :sDescription2';

                $stmt = prepareBindValues($query, [':iProductId' => $iProductId, ':sDescription1' => $sDescription, ':sDescription2' => $sDescription]);

                if( !($stmt->execute()) ){
                    $db->rollBack();
                }
            }

            if( file_exists($_FILES['fImage']['tmp_name']) ){
                // Upload image
                $aImage = $_FILES['fImage'];
                
                // exif_imagetype will return false if the file extension is not a valid image
                if(!exif_imagetype($aImage['tmp_name'])){
                    exit();
                }
                
                // Set variable for it's temporary path
                $strOldImagePath = $aImage['tmp_name'];
                
                // Prepare a new, unique name for the image
                $strImageNewName = 'prod'. $iProductId .'_'.uniqid();
                
                // Set variable for the image name
                $aImageOldName = $aImage['name'];
                
                // Explode file name to retrieve image extension
                $aImageOldName = explode('.', $aImageOldName);
                
                // Set variable for extension
                // Extension is always behind the last . in the string. Therefore, we have to select the last item in the array.
                $strExtension = $aImageOldName[count($aImageOldName)-1];

                // Overwrite the name to include the file extension
                $strImageNewName = $strImageNewName.'.'.$strExtension;
                
                // Create new path for the file, inside the user folder, with the new unique name and the correct file extension
                $strPathToImg = "product_images/$strImageNewName";
                
                // // Move file from old path to new path
                move_uploaded_file($strOldImagePath, $strPathToImg);
                $query = 'INSERT INTO product_images ( iProductId, sImgPath) VALUES(:iProductId, :sImgPath1) ON DUPLICATE KEY UPDATE sImgPath = :sImgPath2';

                // Bind the path of the new image, relative to the product_images folder
                $stmt = prepareBindValues($query, [':iProductId' => $iProductId, ':sImgPath1' => $strImageNewName, ':sImgPath2' => $strImageNewName]);

                if( !($stmt->execute()) ){
                    $db->rollBack();
                }
            }

            // Check if any categories where set
            if( isset($_POST['aCategories']) ){

                try{
                
                    // Delete previous category relationships
                    $query = 'DELETE FROM product_category_relationship WHERE iProductId = :iProductId';
                    $stmt = prepareBindValues($query, [':iProductId' => $iProductId]);

                    if( !($stmt->execute()) ){
                        $db->rollBack();
                    }
                    
                } catch(PDOException $ex) {
                    echo $ex;
                    $db->rollBack();
                    exit();
                }

                $aCategories = $_POST['aCategories'];

                $sSQLValues = '';
                $aSQLParameters = [];                

                for ($i=0; $i < count($aCategories); $i++) {
                    $iCategoryId = $aCategories[$i];

                    $sSQLValues .= "(:iProductId$i, :iCategoryId$i),";
                    $aSQLParameters[":iProductId$i"] = $iProductId;
                    $aSQLParameters[":iCategoryId$i"] = $iCategoryId;        
                }

                $sSQLValues = rtrim($sSQLValues, ',');


                $query = "INSERT INTO product_category_relationship (iProductId, iCategoryId) VALUES $sSQLValues";
                $stmt = prepareBindValues($query, $aSQLParameters);

                if( !($stmt->execute()) ){
                    $db->rollBack();
                }
            }

            $db->commit();
        } else{
            $db->rollBack();
        }
    } catch(PDOException $ex) {
        echo $ex;
        $db->rollBack();
        exit();
    }
}

// Get product
try {
    $query = 'SELECT products.*, product_descriptions.sDescription, product_images.sImgPath
            FROM products 
            LEFT JOIN product_descriptions ON products.iId = product_descriptions.iProductId
            LEFT JOIN product_images ON products.iId = product_images.iProductId
            WHERE products.iId = :iProductId AND isActive = 1';
    
    $stmt = prepareBindValuesExecute($query, [':iProductId' => $iProductId]);
    
    $aProduct = $stmt->fetch();
} catch( PDOException $ex ) {
    exit();
}

// Get all categories
try {
    $stmt = prepareBindValuesExecute('SELECT * FROM product_categories WHERE isActive = 1');
    $aaCategories = $stmt->fetchAll();
} catch( PDOException $ex ) {
    exit();
}

// Get categories of the product
try {
    $stmt = prepareBindValuesExecute('SELECT iCategoryId FROM product_category_relationship WHERE iProductId = :iProductId', [':iProductId' => $iProductId]);
    // Get flat arrays
    $aProductCategories = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
} catch( PDOException $ex ) {
    exit();
}

include_once 'components/_header.php'; ?>

<div class="container mt-5">
  <h1 class="mb-4">
    Editing: 
    <?php echo $aProduct['sName']; ?>    
  </h1>
  <form class="row" method="post" enctype="multipart/form-data">
    <div class="col-lg-7">

        <div class="form-group">
            <input type="text" class="form-control" name="sName" id="sName" placeholder="Product name" value="<?php echo $aProduct['sName']; ?>">
        </div>

        <div class="form-row">
            <div class="form-group col-md-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">DKK</span>
                    </div>

                    <input type="number" step="0.05" class="form-control" name="rPrice" id="rPrice" placeholder="Product price" value="<?php echo $aProduct['rPrice']; ?>">
                </div>
            </div>

            <div class="form-group col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">#</span>
                    </div>

                    <input type="number" class="form-control" name="iNumberInStore" id="iNumberInStore" placeholder="Number in store" value="<?php echo $aProduct['iNumberInStore']; ?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <textarea class="form-control" name="sDescription" id="sDescription" placeholder="Product description" cols="100" rows="4"><?php echo $aProduct['sDescription']; ?></textarea>
        </div>

    </div>
    <div class="col-lg-4 offset-lg-1">

        <div class="form-group">
            <img src="product_images/<?php echo $aProduct['sImgPath']; ?>" alt="">
        </div>

        <div class="form-group">
            <h4 class="mb-3">
                <?php
                    if( $aProduct['sImgPath'] === null ){
                        echo 'Add image to product';
                    } else {
                        echo 'Change to new image';
                    }
                ?>
            </h4>
        
            <!-- <label for="fImage">Upload image</label> -->
            <input type="file" class="form-control-file" id="fImage" name="fImage">
        </div>

        <div class="form-group">
            <h4>
                Categories
            </h4>
            
            <?php foreach ($aaCategories as $aCategory) { ?>
                
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="aCategories[]" value="<?php echo $aCategory['iId']; ?>"<?php if( in_array( $aCategory['iId'], $aProductCategories ) ){ echo ' checked'; } // Check if the category is already active for the product ?>>
                        <?php echo $aCategory['sName']; ?>
                    </label>
                </div>

            <?php } ?>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-success btn-block mt-5">Save changes</button>
        </div>
    </div>
</form>
</div>


<?php include_once 'components/_footer.php'; ?>