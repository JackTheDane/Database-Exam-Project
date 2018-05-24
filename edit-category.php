<?php

// _config
require_once '_config.php';

if( empty($_GET['iCategoryId']) ){
    returnHome();
}

$iCategoryId = $_GET['iCategoryId'];

if( !empty($_POST['sName']) ){
    
    try{
        // Structure: iId, sName
        $sName = $_POST['sName'];

        $stmt = prepareBindValuesExecute("UPDATE product_categories SET sName = :sName", [':sName' => $sName]);

        header("Location: view-categories.php");

    } catch(PDOException $ex) {
        echo $ex;
        exit();
    }
}

// Get category
try {
    $stmt = prepareBindValuesExecute('SELECT * FROM product_categories WHERE iId = :iCategoryId', [':iCategoryId' => $iCategoryId]);

    $aCategory = $stmt->fetch();
} catch( PDOException $ex ) {
    exit();
}

include_once 'components/_header.php'; 

?>

<div class="container mt-5">
  <form class="row" method="post" action="">
    <div class="col-lg-6 offset-lg-3">

        <div class="form-group">
            <input type="text" class="form-control" name="sName" id="sName" placeholder="Category name" value="<?php echo $aCategory['sName']; ?>">
        </div>

        <div class="row no-gutters align-items-end">
            <button type="submit" class="btn btn-success btn-block">Save changes</button>
        </div>

    </div>
  </form>
</div>

<?php

include_once 'components/_footer.php';
?>