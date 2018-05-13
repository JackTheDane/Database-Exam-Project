<?php 
// Set currentPage
$currentPage = 'home';

// _config
require_once '_config.php';

// Get list of all users
try {

    // $stmt = $db->prepare('SELECT * FROM users');
    $stmt = prepareAndBindSQL('SELECT * FROM users');
    $stmt->execute();
    $aaUsers = $stmt->fetchAll();

} catch( PDOException $ex ) {
    exit();
}

include_once 'header.php'; ?>

<div class="container mt-5">
    <table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">First name</th>
            <th scope="col">Last name</th>
            <th scope="col">Email</th>
            <th scope="col" class="text-right">Options</th>
        </tr>
    </thead>
    <tbody>

        <?php 
        
        foreach ($aaUsers as $aUser) { ?>

            <tr>
                <td><?php echo $aUser['sFirstName']; ?></td>
                <td><?php echo $aUser['sLastName']; ?></td>
                <td><?php echo $aUser['sEmail']; ?></td>
                <td class="text-right">
                    <a class="btn btn-outline-info" href="edit-user-form.php?iUserId=<?php echo $aUser['iId']; ?>">Edit</a>
                    <a class="btn btn-outline-danger" href="delete-user.php?iUserId=<?php echo $aUser['iId']; ?>">Delete</a>
                </td>
            </tr>

            <?php } ?>

    </tbody>
    </table>
</div>


<?php include_once 'footer.php'; ?>