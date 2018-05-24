<?php require_once '_config.php';

// Checks if a new information has been passed to the page
if( !empty($_POST['sEmail']) && !empty($_POST['sPassword']) ){
    
    try{

        // Structure: iId, sFirstName, sLastName, sEmail, sPassword, sAddress, iCityId, isAdmin, isActive
        $sEmail = $_POST['sEmail'];
        $sPassword = $_POST['sPassword'];
        
        $stmt = prepareBindValues("SELECT sPassword, iId, isAdmin FROM users WHERE sEmail = :sEmail AND isActive = 1", [':sEmail' => $sEmail]);

        
        
        if( $stmt->execute() ){
            $aUserInfo = $stmt->fetch();
            $sRetrievedPassword = $aUserInfo['sPassword'];
            $iUserId = $aUserInfo['iId'];
            $isAdmin = $aUserInfo['isAdmin'];
            
            if( password_verify($sPassword, $sRetrievedPassword) ){
                $_SESSION['iUserId'] = $iUserId;

                if( $isAdmin ){
                    $_SESSION['isAdmin'] = true;
                }
                returnHome();
            } else {
                echo 'Log in failed';    
            }
        } else{
            echo 'Log in failed';
        }
    } catch(PDOException $ex) {
        echo $ex;
        $db->rollBack();
        exit();
    }
}

include_once 'components/_header.php'; ?>

<div class="container mt-5">
  <form class="row" method="post" action="">
    <div class="col-lg-6 offset-lg-3">

        <div class="form-group">
            <input type="email" class="form-control" name="sEmail" id="sEmail" aria-describedby="emailHelp" placeholder="Your email">
        </div>

        <div class="form-group">
            <input type="password" class="form-control" name="sPassword" id="sPassword" placeholder="Your password">
        </div>

        <div class="row no-gutters align-items-end">
            <button type="submit" class="btn btn-success btn-block">Log in</button>
        </div>
    </div>
    
  </form>
</div>


<?php include_once 'components/_footer.php'; ?>