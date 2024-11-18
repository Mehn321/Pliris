<?php
require_once '../../src/shared/session.php';
require_once '../../src/shared/header.php';
require_once '../../src/user/dashboard.php';

$sessionManager = new SessionManager();
$sessionManager->checkUserSession();

$headerManager = new HeaderManager($sessionManager);
$dashboard = new UserDashboard($connection);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <?php 
    $headerManager->displayUserHeader("Welcome " . $sessionManager->getUserName());
    $dashboard->displayDashboard();
    ?>
</body>
</html>
