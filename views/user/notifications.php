<?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/SessionManager.php';
    require_once '../../src/user/notifications.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkUserAccess();
    $notifications = new UserNotificationsManager($sessionManager);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="../../assets/css/notification.css">
</head>
<body>
<?php text_head("Notifications"); ?>
    <div class="container">
        <div class="notifications">
        <div class='not-seen-notifications'>
                <ul>
                    <?php
                    $unseenList = $notifications->getUnseenNotifications();
                    while ($row = $unseenList->fetch_assoc()) {
                        $created_at = new DateTime($row['created_at']);
                        echo "<li>
                            {$row['message']}
                            <span class='notification-time'>{$created_at->format('M-d-Y h:i:s A')}</span>
                        </li>";
                    }
                    ?>
                </ul>
            </div>
            <div class='seen-notifications'>
                <ul>
                    <?php
                    $seenList = $notifications->getSeenNotifications();
                    while ($row = $seenList->fetch_assoc()) {
                        $created_at = new DateTime($row['created_at']);
                        echo "<li>
                            {$row['message']}
                            <span class='notification-time'>{$created_at->format('M-d-Y h:i:s A')}</span>
                        </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
<?php
    $notifications->markAllAsSeen();
?>
