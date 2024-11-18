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
    require_once '../../src/admin/notification.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();
    $sessionManager->handleLogout();

    $notification = new NotificationManager();
    $notificationList = $notification->getNotifications();

    text_head("Notifications", $sessionManager->getAdminId());
    ?>

    <div class="container">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr class="row-border">
                        <th>Name</th>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>Return Schedule</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($notification = $notificationList->fetch_assoc()){
                        $return_datetime = new DateTime($notification['scheduled_return_datetime']);
                    echo "
                    <tr class='row-border'>
                        <td>". $notification['first_name'] ."</td>
                        <td>". $notification['item_name'] ."</td>
                        <td>". $notification['quantity_reserved'] ."</td>
                        <td>". $return_datetime->format('M-d-Y h:i:s:a') ."</td>
                        <td>". $notification['reservation_stat'] ."</td>
                    </tr>"; 
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
