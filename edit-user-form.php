<?php

// _config
require_once '_config.php';

if( empty($_GET['iUserId']) ){
    returnHome();
}

$iUserId = $_GET['iUserId'];

if( !empty($_POST['sFirstName']) || !empty($_POST['sLastName']) || !empty($_POST['sEmail']) || !empty($_POST['sAddress']) || !empty($_POST['sName']) || !empty($_POST['iZipCode']) ){
    
    try{

        // Structure: iId, sFirstName, sLastName, sEmail, sAddress, iCityId, isAdmin, isActive
    
        $sFirstName = $_POST['sFirstName'];
        $sLastName = $_POST['sLastName'];
        $sEmail = $_POST['sEmail'];

        $sAddress = $_POST['sAddress'];
        $sName = $_POST['sName'];
        $iZipCode = $_POST['iZipCode'];
    
        $db->beginTransaction();
        
        $stmt = prepareBindValues("INSERT INTO cities VALUES(null, :iZipCode, :sName) ON DUPLICATE KEY UPDATE iId=iId", [':iZipCode' => $iZipCode, ':sName' => $sName]);

        if($stmt->execute()){
            
            // Insert user, with the id of the city given (Retrived in subquery)
            $query = 'UPDATE users SET sFirstName = :sFirstName, sLastName = :sLastName, sEmail = :sEmail, sAddress = :sAddress, iCityId = ( SELECT iId FROM cities WHERE iZipCode = :iZipCode OR sName = :sName ) WHERE iId = :iUserId';
            
            $stmt = prepareBindValues($query, [':sFirstName' => $sFirstName, ':sLastName' => $sLastName, ':sEmail' => $sEmail, ':sAddress' => $sAddress, ':iZipCode' => $iZipCode, ':sName' => $sName, ':iUserId' => $iUserId]);
            
            if($stmt->execute()){
                $db->commit();
                returnHome();
            }else{
                $db->rollBack();
            }
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
$currentPage = 'edit-user';

try {
    // Get everything from the user and joined city
    $stmt = prepareBindValuesExecute('SELECT users.*, cities.* FROM users 
        INNER JOIN cities ON users.iCityId = cities.iId 
        WHERE users.iId = :iUserId;', [':iUserId' => $iUserId]);

    $aaUsers = $stmt->fetchAll();
} catch( PDOException $ex ) {
    exit();
}

include_once 'components/_header.php'; 

foreach ($aaUsers as $aUser) {?>

<div class="container mt-5">
  <form class="row" method="post" action="">
    <div class="col-lg-6 offset-lg-3">
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" class="form-control" name="sFirstName" id="sFirstName" placeholder="Your first name" value="<?php echo $aUser['sFirstName']; ?>">
            </div>

            <div class="form-group col-md-6">
                <input type="text" class="form-control" name="sLastName" id="sLastName" placeholder="Your last name" value="<?php echo $aUser['sLastName']; ?>">
            </div>
        </div>

        <div class="form-group">
            <input type="email" class="form-control" name="sEmail" id="sEmail" aria-describedby="emailHelp" placeholder="Your email" value="<?php echo $aUser['sEmail']; ?>">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="sAddress" id="sAddress" placeholder="Address" value="<?php echo $aUser['sAddress']; ?>">
        </div>

        <div class="form-row">
            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="sName" id="sName" placeholder="City" value="<?php echo $aUser['sName']; ?>">
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="iZipCode" id="iZipCode" placeholder="Zip code" value="<?php echo $aUser['iZipCode']; ?>">
            </div>
        </div>

        <div class="row no-gutters align-items-end">
            <button type="submit" class="btn btn-success btn-block">Save</button>
        </div>
    </div>
    
  </form>
<div class="row mt-5">
    <div class="col-lg-6 offset-lg-3">
        <h5>
            Delete user
        </h5>
        <a href="delete-user.php?iUserId=<?php echo $_SESSION['iUserId'] ?>" class="btn btn-danger btn-block">
          Delete my user
        </a>
    </div>
</div>

</div>

<?php

}

include_once 'components/_footer.php';
?>