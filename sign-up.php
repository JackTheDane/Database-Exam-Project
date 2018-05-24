<?php require_once '_config.php';

// Checks if a new information has been passed to the page
if( !empty($_POST['sFirstName']) && !empty($_POST['sLastName']) && !empty($_POST['sEmail']) && !empty($_POST['sPassword']) && !empty($_POST['sAddress']) && !empty($_POST['sCity']) && !empty($_POST['iZipCode']) ){
    
    try{

        // Structure: iId, sFirstName, sLastName, sEmail, sPassword, sAddress, iCityId, isAdmin, isActive
    
        $sFirstName = $_POST['sFirstName'];
        $sLastName = $_POST['sLastName'];
        $sEmail = $_POST['sEmail'];
        $sPassword = password_hash($_POST['sPassword'], PASSWORD_DEFAULT);;

        $sAddress = $_POST['sAddress'];
        $sCity = $_POST['sCity'];
        $iZipCode = $_POST['iZipCode'];
    
        $db->beginTransaction();
    
        
        $stmt = prepareBindValues("INSERT INTO cities VALUES(null, :iZipCode, :sCity) ON DUPLICATE KEY UPDATE iId=iId", [':iZipCode' => $iZipCode, ':sCity' => $sCity]);

        if($stmt->execute()){
            
            // Insert user, with the id of the city given (Retrived in subquery)
            $query = 'INSERT INTO users VALUES(null, :sFirstName, :sLastName, :sEmail, :sPassword, :sAddress, ( SELECT iId FROM cities WHERE iZipCode = :iZipCode OR sName = :sCity ), 0, 1)';
            
            $stmt = prepareBindValues($query, [':sFirstName' => $sFirstName, ':sLastName' => $sLastName, ':sEmail' => $sEmail, ':sPassword' => $sPassword, ':sAddress' => $sAddress, ':iZipCode' => $iZipCode, ':sCity' => $sCity]);
            
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
$currentPage = 'sign-up';

include_once 'components/_header.php'; ?>

<div class="container mt-5">
  <form class="row" method="post" action="">
    <div class="col-lg-6 offset-lg-3">
        <div class="form-row">
            <div class="form-group col-md-6">
                <input type="text" class="form-control" name="sFirstName" id="sFirstName" placeholder="Your first name">
            </div>

            <div class="form-group col-md-6">
                <input type="text" class="form-control" name="sLastName" id="sLastName" placeholder="Your last name">
            </div>
        </div>

        <div class="form-group">
            <input type="email" class="form-control" name="sEmail" id="sEmail" aria-describedby="emailHelp" placeholder="Your email">
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="sAddress" id="sAddress" placeholder="Address">
        </div>

        <div class="form-row">
            <div class="form-group col-md-8">
                <input type="text" class="form-control" name="sCity" id="sCity" placeholder="City">
            </div>
            <div class="form-group col-md-4">
                <input type="text" class="form-control" name="iZipCode" id="iZipCode" placeholder="Zip code">
            </div>
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="sPassword" id="sPassword" placeholder="Your password">
        </div>

        <div class="row no-gutters align-items-end">
            <button type="submit" class="btn btn-success btn-block">Create</button>
        </div>
    </div>
    
  </form>
</div>


<?php include_once 'components/_footer.php'; ?>