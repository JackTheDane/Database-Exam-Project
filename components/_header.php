<?php 
  // Check for current page, set empty if none
  if(!isset($currentPage)){
    $currentPage = false;
  }

  if( !empty( $_SESSION['isAdmin'] ) ){
    $isAdmin = true;
  } else {
    $isAdmin = false;    
  }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="main.css">

    <title>Webshop</title>
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
    <div class="container">
      <a class="navbar-brand disabled" href="index.php">Webshop</a>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          
          <?php if($isAdmin){ ?>

            <li class="nav-item">
              <a href="update-mongodb.php" class="btn btn-link">Update MongoDB</a>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                Admin
              </a>
              <div class="dropdown-menu">
                <a class="dropdown-item" href="add-product.php">Add product</a>
                <a class="dropdown-item" href="view-categories.php">Categories</a>                
                <div class="dropdown-divider"></div>
                <a class="dropdown-item<?php if($currentPage == 'view-all-users'){ echo ' active'; } ?>" href="view-all-users.php">View all users</a>
              </div>
            </li>

          <?php } ?>


          <?php if( !empty( $_SESSION['iUserId'] ) ){ ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
              My account
            </a>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="view-wishlist.php">My wishlist</a>
              <a class="dropdown-item" href="view-order-history.php">Order history</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="edit-user-form.php?iUserId=<?php echo $_SESSION['iUserId'] ?>">Edit user info</a>                
            </div>
          </li>
          <?php } ?>

          <?php if( !empty( $_SESSION['iUserId'] ) ){ ?>
            <li class="nav-item">
              <a class="btn btn-success" href="log-out.php">Log out</a>
            </li>
          <?php } else { ?>
            <li class="nav-item">
              <a class="btn btn-success" href="sign-up.php">New user</a>
            </li>
            <li class="nav-item">
              <a class="btn btn-outline-success" href="log-in.php">Log in</a>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </nav>

  <?php 
    // If debugMode is enabled, get the website log
    if($debugMode){

      include_once 'database/log.php'; ?>

      <div id="logWindow">
        <button id="buttonMinLog" type="button" class="btn btn-info"></button>
        <ul class="card bg-primary">
  
        <?php
          foreach ($aLog as $log ) {
            if ($log['argument'] != 'START TRANSACTION' && $log['argument'] != 'COMMIT') {
              echo '<li class="list-group-item">'.$log['argument'].'</li>';
            }
          }
        ?>
  
        </ul>
      </div>

    <?php }?>

    <script>
      if( localStorage.logWindowOpen !== null && !JSON.parse(localStorage.logWindowOpen) ){
        logWindow.classList.add('closed');
      }
    </script>