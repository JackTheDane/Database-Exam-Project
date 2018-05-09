<?php 
  require_once '_config.php';

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
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
    <div class="container">
      <a class="navbar-brand disabled" href="index.php">Student List</a>
      <a class="btn btn-success<?php if($currentPage == 'sign-up'){ echo ' disabled'; } ?>" href="sign-up.php">New student</a>
    </div>


      <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form> -->

    </div>
  </nav>

  <?php if( !empty($sqlQuery) && $debugMode){ ?>
  
  <div class="alert alert-success text-center" role="alert">
    <?php echo $sqlQuery; ?>
  </div>
  
  <?php } ?>