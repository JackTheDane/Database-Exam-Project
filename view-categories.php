<?php require_once '_config.php';

// Checks if a new information has been passed to the page
if( !empty($_POST['sName']) ){
    
    try{

        // iId, sName
        $sName = $_POST['sName'];

        $query = "INSERT INTO product_categories (iId, sName, isActive) VALUES(null,  :sName, 1)";
        
        prepareBindValuesExecute($query, [':sName' => $sName]);

    } catch(PDOException $ex) {
        echo $ex;
        exit();
    }
}

// Set currentPage
$currentPage = 'new-product';

try{

    // iId, sName
    $query = "SELECT * FROM product_categories WHERE isActive = 1";
    
    $stmt = prepareBindValuesExecute($query);

    $aaCategories = $stmt->fetchAll();

} catch(PDOException $ex) {
    echo $ex;
    exit();
}

include_once 'components/_header.php'; ?>

<div class="container mt-5">
    <div class="mb-5">
        <form class="form-inline" method="post">
              <div class="input-group">
                  <input type="text" class="form-control" name="sName" id="sName" placeholder="Add new category">
                  <div class="input-group-append">
                      <button type="submit" class="btn float-right btn-success">Add category</button>
                  </div>
              </div>
        </form>
    </div>
  
  <div>
      <table class="table table-striped">
          <thead>
              <tr>
                  <th scope="col">Category name</th>
                  <th scope="col" class="text-right">Options</th>
              </tr>
          </thead>
          <tbody>
      
              <?php 
              
              foreach ($aaCategories as $aCategory) { ?>
      
                  <tr>
                      <td><?php echo $aCategory['sName']; ?></td>
                      <td class="text-right">
                          <a class="btn btn-outline-info" href="edit-category.php?iCategoryId=<?php echo $aCategory['iId']; ?>">Edit</a>
                          <a class="btn btn-outline-danger" href="delete-category.php?iCategoryId=<?php echo $aCategory['iId']; ?>">Delete</a>
                      </td>
                  </tr>
      
                  <?php } ?>
      
          </tbody>
      </table>
  </div>
</div>


<?php include_once 'components/_footer.php'; ?>