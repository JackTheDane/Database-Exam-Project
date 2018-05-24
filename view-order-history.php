<?php 
// Set currentPage
$currentPage = 'view-all-users';

// _config
require_once '_config.php';

// Get list of all users
try{

    $query = 'SELECT user_order_history.*, products.sName as sProductName, product_images.sImgPath
    FROM user_order_history
    LEFT JOIN products ON products.iId = user_order_history.iProductId
    LEFT JOIN product_images ON product_images.iProductId = user_order_history.iProductId
    WHERE user_order_history.iUserId = :iUserId';
    $stmt = prepareBindValuesExecute($query, [':iUserId' => $_SESSION['iUserId']]);

    $aaOrders = $stmt->fetchAll();

} catch( PDOException $ex ){
    echo $ex;
}

include_once 'components/_header.php'; ?>

<div class="container mt-5">
    <table id="orderHistory" class="table table-striped">
    <thead>
        <tr>
            <th class="col-md-2" scope="col">Order ID #</th>
            <th class="col-md-1" scope="col">Product</th>
            <th class="col-md-6" scope="col"></th>
            <th class="col-md-3" scope="col">Order date</th>
        </tr>
    </thead>
    <tbody>

        <?php 
        
        foreach ($aaOrders as $aOrder) { 
            
            $dOrderDate = date('d-m-Y', strtotime($aOrder['dTimeOfPurchase']));
            $sOrderImgPath = $aOrder['sImgPath'] !== null ? $aOrder['sImgPath'] : 'standardProductImage.png';
        ?>

            <tr>
                <td><?php echo $aOrder['iId']; ?></td>
                <td>
                    <img src="product_images/<?php echo $sOrderImgPath; ?>">
                </td>
                <td><?php echo $aOrder['sProductName']; ?></td>
                <td><?php echo $dOrderDate; ?></td>
            </tr>

            <?php } ?>

    </tbody>
    </table>
</div>


<?php include_once 'components/_footer.php'; ?>