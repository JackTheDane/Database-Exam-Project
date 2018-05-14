<?php 
  // Check for current page, set empty if none
  if(!isset($currentPage)){
    $currentPage = false;
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
    <link rel="stylesheet" href="main.css">

    <title>Webshop</title>
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
    <div class="container">
      <a class="navbar-brand disabled" href="index.php">Webshop</a>
      <a class="btn btn-success<?php if($currentPage == 'sign-up'){ echo ' disabled'; } ?>" href="sign-up.php">New user</a>
    </div>


      <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form> -->

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
              echo '<li class="list-group-item">'.$log['argument'].'</li>';
          }
        ?>
  
        </ul>
      </div>

    <?php }?>

    <script>
      if( !JSON.parse(localStorage.logWindowOpen) ){
        logWindow.classList.add('closed');
      }
    </script>