<?php require_once '_config.php';

// Checks if a new information has been passed to the page
if( !empty($_POST['sName']) && !empty($_POST['rPrice']) && !empty($_POST['iNumberInStore']) ){
    
    try{

        // iId, sName, iNumberInStore, rPrice, 
        $sName = $_POST['sName'];
        $rPrice = $_POST['rPrice'];
        $iNumberInStore = $_POST['iNumberInStore'];
    
        $db->beginTransaction();

        $query = "INSERT INTO products (iId, sName, rPrice, iNumberInStore, isActive) VALUES(null,  :sName, :rPrice, :iNumberInStore, 1)";
        
        $stmt = prepareBindValues($query, [':sName' => $sName, ':rPrice' => $rPrice, ':iNumberInStore' => $iNumberInStore]);

        if($stmt->execute()){

            // Get last inserted id
            $iProductId = $db->lastInsertId();

            if( !empty($_POST['sDescription']) ){
                $sDescription = $_POST['sDescription'];

                $query = "INSERT INTO product_descriptions (iId, iProductId, sDescription) VALUES(null, :iProductId, :sDescription)";

                $stmt = prepareBindValues($query, [':iProductId' => $iProductId, ':sDescription' => $sDescription]);

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
                $query = "INSERT INTO product_images (iId, iProductId, sImgPath) VALUES(null, :iProductId, :sImgPath)";

                // Bind the path of the new image, relative to the product_images folder
                $stmt = prepareBindValues($query, [':iProductId' => $iProductId, ':sImgPath' => $strImageNewName]);

                if( !($stmt->execute()) ){
                    $db->rollBack();
                }
            }

            // Check if any categories where set
            if( !empty($_POST['aCategories']) ){
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

// Set currentPage
$currentPage = 'new-product';

// Get all categories
$stmt = prepareBindValuesExecute('SELECT * FROM product_categories WHERE isActive = 1');

$aaCategories = $stmt->fetchAll();

include_once 'components/_header.php'; ?>

<div class="container mt-5">
  <form class="row" method="post" enctype="multipart/form-data">
    <div class="col-lg-7">

        <div class="form-group">
            <input type="text" class="form-control" name="sName" id="sName" placeholder="Product name">
        </div>

        <div class="form-row">
            <div class="form-group col-md-8">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">DKK</span>
                    </div>

                    <input type="number" step="0.05" class="form-control" name="rPrice" id="rPrice" placeholder="Product price">
                </div>
            </div>

            <div class="form-group col-md-4">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">#</span>
                    </div>

                    <input type="number" class="form-control" name="iNumberInStore" id="iNumberInStore" placeholder="Number in store" value="30">
                </div>
            </div>
        </div>

        <div class="form-group">
            <textarea class="form-control" name="sDescription" id="sDescription" placeholder="Product description" cols="100" rows="4"></textarea>
        </div>

    </div>
    <div class="col-lg-4 offset-lg-1">
        <!-- <div class="form-group">
            <label for="fImage">Product image</label>
            <div class="custom-file">
                <input type="file" name="fImage" id="fImage" placeholder="Product image" class="custom-file-input" id="customFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
        </div> -->

        <div class="form-group">
            <label for="fImage">Upload image</label>
            <input type="file" class="form-control-file" id="fImage" name="fImage">
        </div>

        <div class="form-group">
            
            <?php foreach ($aaCategories as $aCategory) { ?>
                
                <div class="form-check">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="aCategories[]" value="<?php echo $aCategory['iId']; ?>" id="">
                        <?php echo $aCategory['sName']; ?>
                    </label>
                </div>

            <?php } ?>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-lg btn-success btn-block mt-5">Add product</button>
        </div>
    </div>
</form>
</div>


<?php include_once 'components/_footer.php'; ?>