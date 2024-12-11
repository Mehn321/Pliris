<?php
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/admin/records.php';
include 'header.php';

$sessionManager = new SessionManager();
$sessionManager->checkAdminAccess();

$records = new RecordsManager();
$recordsList = $records->getAllRecords();

// Group records by year and month
$groupedRecords = [];
foreach($recordsList as $record) {
    $return_date = new DateTime($record['returned_datetime']);
    $yearMonth = $return_date->format('Y-m');
    $groupedRecords[$yearMonth][] = $record;
}

text_head("Records");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reservation.css">
</head>
<body>
    <div class="container">
        <?php foreach($groupedRecords as $yearMonth => $monthRecords): 
            $date = DateTime::createFromFormat('Y-m', $yearMonth);
        ?>
            <h2 class="year-month"><?= $date->format('F Y') ?></h2>
            <table>
                <tr class="row-border">
                    <th>Name</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Reserved Schedule</th>
                    <th>Returned At</th>
                </tr>
                <?php foreach($monthRecords as $record): 
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
        <?php endforeach; ?>
    </div>
</body>
</html>