<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>
<body>
    <?php
    include 'header.php';
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/user/dashboard.php';
    require_once '../../src/shared/authentication.php';

    $sessionManager = new SessionManager();
    $sessionManager->setRedirectPath("../../index.php");
    $sessionManager->checkUserAccess();

    $dashboard = new UserDashboard();
    $stats = $dashboard->getDashboardStats($sessionManager->getUserId_number());
    
    $userid_number=$sessionManager->getUserId_number();
    $auth = new Authentication($sessionManager);
    $user_info = $auth->getUserInfo($userid_number);
    $first_name = $user_info['first_name'];
    $last_name = $user_info['last_name'];
    text_head("Welcome $first_name $last_name");
    ?>

    <div class="box">
        <ul>
            <a href='reserve_item.php' class='red'>
                <li><img src='../../assets/images/allitems.png' alt=''><br>Reserve Items</li>
            </a>
            <a href='reservations.php' class='green'>
                <li><img src='../../assets/images/return.png' alt=''><br>Reservations: <?= $stats['reserved'] ?></li>
            </a>
            <a href='notifications.php' class='blue'>
                <li><img src='../../assets/images/bell.png' alt=''><br>Notifications</li>
            </a>
        </ul>
    </div>
</body>
</html>