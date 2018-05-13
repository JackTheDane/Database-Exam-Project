<?php

// _config
require_once '_config.php';

if( empty($_GET['iUserId']) ){
    returnHome();
}

$iUserId = $_GET['iUserId'];

// Check if user edits have already been made
if( !empty($_POST['sFirstName']) || !empty($_POST['sLastName']) || !empty($_POST['sEmail']) ){

    $sFirstName = $_POST['sFirstName'];
    $sLastName = $_POST['sLastName'];
    $sEmail = $_POST['sEmail'];
    
    try {
        $stmt = $db->prepare('UPDATE users SET sFirstName = :sFirstName, sLastName = :sLastName, sEmail = :sEmail WHERE iId = :iUserId');
        
        $stmt->bindValue(':sFirstName', $sFirstName);
        $stmt->bindValue(':sLastName', $sLastName);
        $stmt->bindValue(':sEmail', $sEmail);
        $stmt->bindValue(':iUserId', $iUserId);
        
        $stmt->execute();
    } catch( PDOException $ex ) {
        echo 'error';
        exit();
    }

    returnHome();
}

try {
    $stmt = $db->prepare('SELECT * FROM users WHERE iId = :iUserId');
    
    $stmt->bindValue(':iUserId', $iUserId);
    
    $stmt->execute();
    $aaUsers = $stmt->fetchAll();
} catch( PDOException $ex ) {
    exit();
}

include_once 'header.php'; 

foreach ($aaUsers as $aUser) {
?>

<div class="container mt-5">
  <form class="row" method="post" action="">
    <div class="col-lg-6 offset-lg-3">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="sFirstName">First name</label>
                <input type="text" class="form-control" name="sFirstName" id="sFirstName" placeholder="Your first name" value="<?php echo $aUser['sFirstName']; ?>">
            </div>

            <div class="form-group col-md-6">
                <label for="sLastName">Last name</label>
                <input type="text" class="form-control" name="sLastName" id="sLastName" placeholder="Your last name" value="<?php echo $aUser['sLastName']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="sEmail">Email</label>
            <input type="email" class="form-control" name="sEmail" id="sEmail" aria-describedby="emailHelp" placeholder="Your email" value="<?php echo $aUser['sEmail']; ?>">
        </div>

        <div class="row no-gutters align-items-end">
            <button type="submit" class="btn btn-success btn-block">Save</button>
            <!-- <small class="form-text text-muted">This content will be shared with the rest of the class.</small> -->
        </div>
    </div>
    
  </form>
</div>

<?php

}

include_once 'footer.php';
?>