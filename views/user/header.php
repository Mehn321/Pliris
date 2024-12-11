
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/header.css">
</head>
<body>
<?php

function text_head($headertext) {
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/user/notifications.php';
    $sessionManager = new SessionManager();
    $notificationManager =new UserNotificationsManager($sessionManager);
    $notificationManager->createReturnReminderNotification();
    $not_seenNotificationcount = $notificationManager->not_seenNotificationCount();
    if($not_seenNotificationcount>9){
        $not_seenNotificationcount="9+";
    }

    if (isset($_POST['logout'])) {
        $sessionManager->handleUserLogout();
        header("Location: ../../index.php");
        exit();
    }
    echo '<header class="header">
        <nav class="navbar">
            <button class="menu" onclick="showsidebar()">
                <img src="../../assets/images/menuwhite.png" alt="menu" height="40px" width="45">
            </button>
            <img class="ustplogo" src="../../assets/images/ustplogo.png" alt="">
            <div class=headertext>' . $headertext . '</div>
            <div class="notification">
                <a href="notifications.php" class="badge1">
                    <img src="../../assets/images/bell.png" alt="">
                    <span class="badge">' . $not_seenNotificationcount . '</span>
                </a>
            </div>
            <div class="logout-box">
                <form action="" method="post">
                    <button name="logout" value="logout">Log Out</button>
                </form>
            </div>
        </nav>
        <div class="sidebar">
            <ul>
                <button class="menu" onclick="hidesidebar()">
                    <img src="../../assets/images/menublue.png" alt="menu" height="40px" width="45px">
                </button>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="reserve_item.php">Reserve Items</a></li>
                <li><a href="reservations.php">Reservations</a></li>
                <li><a href="notifications.php">Notifications</a></li>
            </ul>
        </div>
    </header>';
}
?>
</body>
</html>
<?php
?>
<script>
    function hidesidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.display = 'none';
    }

    function showsidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.display = 'block';
    }
</script>
