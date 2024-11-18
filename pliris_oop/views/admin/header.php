

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
    require_once "../../src/admin/notification.php";
    $notificication=new NotificationManager();
    $notificication->getlowStockThreshold(10);
    $notSeenNotifications= $notificication->getNotseenNotificationsCount();
    $lowStockItems = $notificication->getlowstockNotificationCount();
    $totalrednotif = $notSeenNotifications + $lowStockItems; // total number of
    echo '<header class="header">
        <nav class="navbar">
            <button class="menu" onclick="showsidebar()">
                <img src="../../assets/images/menuwhite.png" alt="menu" height="40px" width="45">
            </button>
            <img src="../../assets/images/ustplogo.png" alt="">
            <ul><li>' . $headertext . '</li></ul>
            <div class="notification">
                <a href="notification.php" class="badge1">
                    <img src="../../assets/images/bell.png" alt="">
                    <span class="badge">' . $totalrednotif . '</span>
                </a>
            </div>
            <div class="logout-container">
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
                <a href="dashboard.php"><li>Dashboard</li></a>
                <a href="items.php"><li>Items</li></a>
                <a href="reserved_items.php"><li>Reserved items</li></a>
                <a href="returned_items.php"><li>Returned items</li></a>
                <a href="add.php"><li>Add Items</li></a>
                <a href="accounts.php"><li>Accounts</li></a>
                <a href="records.php"><li>Records</li></a>
                <a href="notification.php"><li>Notifications</li></a>
            </ul>
        </div>
    </header>';
}
?>
    
</body>
</html>

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
