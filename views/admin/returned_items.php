<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reserved_returned.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/SessionManager.php';
    require_once '../../src/admin/returned_items.php';
    require_once '../../src/admin/notifications.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();
    // $sessionManager->handleAdminLogout();

    $returnedItems = new ReturnedItemsManager();
    $returnedList = $returnedItems->getReturnedItems();

    $notificationManager= new AdminNotificationsManager($sessionManager);

    if (isset($_POST['approve'])) {
        $reserve_id = $_POST['reserve_id'];
        $quantity_reserved = $_POST['quantity_reserved'];
        $returnedItems->approveReturn($_POST['reserve_id']);
        $item_id=$_POST['item_id'];
        $returnedItems->update_item_quantity_reserved($quantity_reserved, $item_id);
        $itemInfo = $returnedItems->getItemInfo($reserve_id);
        $notificationManager->createApprovalNotification($itemInfo['id_number'], $itemInfo['item_name'], $quantity_reserved);
        header("Location: returned_items.php");
        exit();
    }
    
    if (isset($_POST['disapprove'])) {
        $reserve_id = $_POST['reserve_id'];
        $quantity_reserved = $_POST['quantity_reserved'];
        $returnedItems->disapproveReturn($reserve_id);
        $itemInfo = $returnedItems->getItemInfo($reserve_id);
        $notificationManager->createDisapprovalNotification($itemInfo['id_number'], $itemInfo['item_name'], $quantity_reserved);
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
                        <th>Return Schedule</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($returned_item = $returnedList->fetch_assoc()){
                        $reserve_datetime = new DateTime($returned_item['scheduled_reserve_datetime']);
                        $return_datetime = new DateTime($returned_item['scheduled_return_datetime']);
                        echo "
                        <tr class='row-border'>
                            <td>". $returned_item['first_name'] ."</td>
                            <td>". $returned_item['item_name'] ."</td>
                            <td>". $returned_item['quantity_reserved'] ."</td>
                            <td>". $reserve_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td>". $return_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td><form action='' method='post'>
                                <input type='hidden' name='quantity_reserved' value='{$returned_item['quantity_reserved']}'>
                                <input type='hidden' name='reserve_id' value='{$returned_item['reserve_id']}'>
                                <input type='hidden' name='item_id' value='{$returned_item['item_id']}'>
                                <input type='submit' name='approve' value='Approve'>
                                <input type='submit' name='disapprove' value='Disapprove'>
                            </form></td>
                        </tr>";
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
