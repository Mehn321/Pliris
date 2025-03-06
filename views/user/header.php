<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.sidebar {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 250px;
    background: white;
    z-index: 1050;
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
}
</style>
</head>
<body>
<?php
function text_head($headertext) {
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/user/notifications.php';
    $sessionManager = new SessionManager();
    $notificationManager = new UserNotificationsManager($sessionManager);
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
        <nav class="navbar navbar-dark bg-primary px-2" style="min-width: 480px;">
            <div class="d-flex align-items-center justify-content-between w-100">
                <div class="d-flex align-items-center justify-content-arround">
                    <button class="btn btn-link btn-info" onclick="showsidebar()">
                        <img src="../../assets/images/menuwhite.png" alt="menu" height="40">
                    </button>
                    <img class="position-absolute top-50 translate-middle rounded-1" style="left: 17vw;" src="../../assets/images/ustplogo.png" alt="USTP Logo" height="60">
                </div>
                <div class="text-white fs-5 ms-3">' . $headertext . '</div>
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <a href="notifications.php" class="position-relative d-inline-block">
                            <span class="position-absolute mt-n3 translate-middle-x badge rounded-circle bg-danger d-flex justify-content-center align-items-center" style="width: 15px; height: 15px; top: 0px; right: -7px">' . $not_seenNotificationcount . '</span>
                            <img src="../../assets/images/bell.png" alt="notifications" height="35">
                        </a>
                    </div>
                    <form method="post" class="m-0">
                        <button name="logout" value="logout" class="btn btn-outline-light">Logout</button>
                    </form>
                </div>
            </div>
        </nav>
        <div class="sidebar bg-dark w-auto pe-4">
            <div class="py-2 ps-2 border-bottom">
                <button class="btn btn-link btn-secondary" onclick="hidesidebar()">
                    <img src="../../assets/images/menublue.png" alt="menu" height="40">
                </button>
            </div>
            <div class="list-group list-group-flush">
                <button class="btn btn-dark text-start mb-2 w-100" onclick="window.location.href=\'dashboard.php\'">Dashboard</button>
                <button class="btn btn-dark text-start mb-2 w-100" onclick="window.location.href=\'reserve_item.php\'">Reserve Items</button>
                <button class="btn btn-dark text-start mb-2 w-100" onclick="window.location.href=\'reservations.php\'">Reservations</button>
                <button class="btn btn-dark text-start w-100" onclick="window.location.href=\'notifications.php\'">Notifications</button>
            </div>
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