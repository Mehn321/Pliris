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
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();
    $sessionManager->handleLogout();

    $returnedItems = new ReturnedItemsManager();
    $returnedList = $returnedItems->getReturnedItems();

    text_head("Returned Items", $sessionManager->getAdminId());
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
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($item = $returnedList->fetch_assoc()){
                        $reserve_datetime = new DateTime($item['scheduled_reserve_datetime']);
                        $return_datetime = new DateTime($item['scheduled_return_datetime']);
                        echo "
                        <tr class='row-border'>
                            <td>". $item['first_name'] ."</td>
                            <td>". $item['item_name'] ."</td>
                            <td>". $item['quantity_reserved'] ."</td>
                            <td>". $reserve_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td>". $return_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td>". $item['reservation_stat'] ."</td>
                        </tr>";
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
