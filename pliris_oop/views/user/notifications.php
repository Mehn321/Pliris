<?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/SessionManager.php';
    require_once '../../src/user/notifications.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkUserAccess();

    $notifications = new UserNotificationsManager($sessionManager);
    
    // Mark notifications as seen when page is loaded
    $notifications->markAllAsSeen();
    
    text_head("Notifications");
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
        <div class="notifications">
            <ul>
                <?php
                $notifList = $notifications->getUserNotifications();
                while ($row = $notifList->fetch_assoc()) {
                    echo "<li>{$row['message']}</li>";
                }
                ?>
            </ul>
        </div>
</body>
</html>
