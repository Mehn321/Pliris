<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Items</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reservation.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once 'src/shared/sessionmanager.php';
    require_once '../../src/shared/reservations.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();
    // $sessionManager->handleAdminLogout();

    $admin_id_number = $sessionManager->getAdminId();
    $reservedItems = new ReservationsManager($sessionManager);

    if (isset($_POST['return'])) {
        $reservedItems->returnItem($_POST['reserve_id']);
        header("Location: reserved_items.php");
        exit();
    }

    text_head("Reserved Items");
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
                    <?php
                        $reservedList = $reservedItems->getReservations();
                        while($item = $reservedList->fetch_assoc()){
                        $reserve_datetime = new DateTime($item['scheduled_reserve_datetime']);
                        $return_datetime = new DateTime($item['scheduled_return_datetime']);
                        echo "
                        <tr class='row-border'>
                            <td>". $item['first_name']." ". $item['last_name'] ."</td>
                            <td>". $item['item_name'] ."</td>
                            <td>". $item['quantity_reserved'] ."</td>
                            <td>". $reserve_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td>". $return_datetime->format('M-d-Y h:i:s:a') ."</td>
                            <td>
                                <form action='' method='post'>
                                    <input type='hidden' name='reserve_id' value='". $item['reserve_id'] ."'>
                                    <input type='submit' name='return' value='return'>
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
