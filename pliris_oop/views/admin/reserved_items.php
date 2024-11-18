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
    require_once '../../src/shared/reservations.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();
    $sessionManager->handleLogout();

    $admin_id_number = $sessionManager->getAdminId();
    $reservedItems = new ReservationManager();
    $reservedList = $reservedItems->getReservations($admin_id_number);

    text_head("Reserved Items", $sessionManager->getAdminId());
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
                    <?php while($item = $reservedList->fetch_assoc()){
                        $reserve_datetime = new DateTime($item['scheduled_reserve_datetime']);
                        $return_datetime = new DateTime($item['scheduled_return_datetime']);
                        echo "
                        <tr class='row-border'>
                            <td>". $item['first_name'] ."</td>
                            <td>". $item['item_name'] ."</td>
                            <td>". $item['quantity_reserved'] ."</td>
                            <td>". $reserve_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td>". $return_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td>
                                <form action='' method='post'>
                                    <input type='hidden' name='reserve_id' value='". $item['reserve_id'] ."'>
                                    <input type='submit' name='submit' value='return'>
                                </form>
                            </td>
                        </tr>";
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
