<?php
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/admin/records.php';
include 'header.php';

$sessionManager = new SessionManager();
$sessionManager->checkAdminAccess();
// $sessionManager->handleAdminLogout();

$records = new RecordsManager();
$recordsList = $records->getAllRecords();

text_head("Records");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reserved_returned.css">
</head>
<body>
    <div class="container">
        <table>
            <tr class="row-border">
                <th>Name</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved Schedule</th>
                <th>Returned At</th>
            </tr>
            <?php foreach($recordsList as $record): 
                $reserve_datetime = new DateTime($record['scheduled_reserve_datetime']);
                $return_datetime = new DateTime($record['returned_datetime']);
            ?>
            <tr class="row-border">
                <td><?= $record['first_name'] ?> <?= $record['last_name'] ?></td>
                <td><?= $record['item_name'] ?></td>
                <td><?= $record['quantity_reserved'] ?></td>
                <td><?= $reserve_datetime->format('M-d-Y h:i:s:a') ?></td>
                <td><?= $return_datetime->format('M-d-Y h:i:s:a') ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>