<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returned Items</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reservation_accounts.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/admin/returned_items.php';
    require_once '../../src/admin/notifications.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();

    $returnedItemsManager = new ReturnedItemsManager();
    $returnedList = $returnedItemsManager->getReturnedItems();

    $notificationManager= new AdminNotificationsManager();

    if (isset($_POST['approve'])) {
        $reserve_id = $_POST['reserve_id'];
        $item_id=$_POST['item_id'];
        $id_number = $_POST['id_number'];
        $quantity_reserved = $_POST['quantity_reserved'];
        $returnedItemsManager->approveReturn($reserve_id);
        $returnedItemsManager->createRecord($reserve_id);
        $returnedItemsManager->update_items_quantity_reserved($quantity_reserved, $item_id);
        $notificationManager->createApprovalNotification($_POST['id_number'], $_POST['item_name'], $quantity_reserved);
        header("Location: returned_items.php");
        exit();
    }
    
    if (isset($_POST['disapprove'])) {
        $reserve_id = $_POST['reserve_id'];
        $quantity_reserved = $_POST['quantity_reserved'];
        $returnedItemsManager->disapproveReturn($reserve_id);
        $notificationManager->createDisapprovalNotification($_POST['id_number'], $_POST['item_name'], $quantity_reserved);
        header("Location: returned_items.php");
        exit();
    }

    text_head("Returned Items");
    ?>

    <div class="container">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr class="row-border">
                        <th>Borrower</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Reserved Schedule</th>
                        <th>Returned at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($returned_item = $returnedList->fetch_assoc()){
                        $reserve_datetime = new DateTime($returned_item['scheduled_reserve_datetime']);
                        $returned_datetime = new DateTime($returned_item['returned_datetime']);
                        echo "
                        <tr class='row-border'>
                            <td>". $returned_item['first_name'] ." ". $returned_item['last_name'] ."</td>
                            <td>". $returned_item['item_name'] ."</td>
                            <td>". $returned_item['quantity_reserved'] ."</td>
                            <td>". $reserve_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td>". $returned_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td><form action='' method='post'>
                                <input type='hidden' name='id_number' value='{$returned_item['id_number']}'>
                                <input type='hidden' name='item_name' value='{$returned_item['item_name']}'>
                                <input type='hidden' name='quantity_reserved' value='{$returned_item['quantity_reserved']}'>
                                <input type='hidden' name='reserve_id' value='{$returned_item['reserve_id']}'>
                                <input type='hidden' name='item_id' value='{$returned_item['item_id']}'>
                                <input type='submit' name='approve' value='Approve'>
                                <input type='submit' name='disapprove' value='Disapprove' class='disapprove-button'>
                            </form></td>
                        </tr>";
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
