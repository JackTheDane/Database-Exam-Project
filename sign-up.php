<?php require_once '_config.php';

// Checks if a new information has been passed to the page
if( !empty($_POST['sFirstName']) && !empty($_POST['sLastName']) && !empty($_POST['sEmail']) && !empty($_POST['sPassword']) ){
    
    try{
    
        $sFirstName = $_POST['sFirstName'];
        $sLastName = $_POST['sLastName'];
        $sEmail = $_POST['sEmail'];
        $sPassword = $_POST['sPassword'];
    
        $query = 'INSERT INTO users VALUES(null, :sFirstName, :sLastName, :sEmail, :sPassword)';
    
        $stmt = prepareAndBindSQL($query, [':sFirstName' => $sFirstName, ':sLastName' => $sLastName, ':sEmail' => $sEmail, ':sPassword' => $sPassword]);
        
        // $stmt->bindValue(':sFirstName', $sFirstName);
        // $stmt->bindValue(':sLastName', $sLastName);
        // $stmt->bindValue(':sEmail', $sEmail);
        // $stmt->bindValue(':sPassword', $sPassword);

        $stmt->execute();
    
        // $sqlQuery = strtr($stmt->queryString, [':sFirstName' => $sFirstName, ':sLastName' => $sLastName, ':sEmail' => $sEmail, ':sPassword' => $sPassword,] );
    
        // returnHome();
    } catch(PDOException $ex) {
        exit();
    }
}

// Set currentPage
$currentPage = 'sign-up';

include_once 'header.php'; ?>

<div class="container mt-5">
  <form class="row" method="post" action="">
    <div class="col-lg-6 offset-lg-3">
        <div class="form-row">
            <div class="form-group col-md-6">
                <!-- <label for="sFirstName">First name</label> -->
                <input type="text" class="form-control" name="sFirstName" id="sFirstName" placeholder="Your first name">
            </div>

            <div class="form-group col-md-6">
                <!-- <label for="sLastName">Last name</label> -->
                <input type="text" class="form-control" name="sLastName" id="sLastName" placeholder="Your last name">
            </div>
        </div>

        <div class="form-group">
            <!-- <label for="sEmail">Email address</label> -->
            <input type="email" class="form-control" name="sEmail" id="sEmail" aria-describedby="emailHelp" placeholder="Your email">
        </div>

        <div class="form-group">
            <!-- <label for="sPassword">Password</label> -->
            <input type="password" class="form-control" name="sPassword" id="sPassword" placeholder="Your password">
        </div>

        <div class="row no-gutters align-items-end">
            <button type="submit" class="btn btn-success btn-block">Create</button>
            <!-- <small class="form-text text-muted">This content will be shared with the rest of the class.</small> -->
        </div>
    </div>
    
  </form>
</div>


<?php include_once 'footer.php'; ?>