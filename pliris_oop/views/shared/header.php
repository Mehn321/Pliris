<?php
function text_head($title, $id_number) {
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>'.$title.'</title>
        <link rel="stylesheet" href="../../assets/css/dashboard.css">
        <script src="../../assets/js/sidebar.js"></script>
    </head>
    <body>
        <header>
            <div class="logo">
                <img src="../../assets/images/ustplogo.png" alt="USTP Logo">
                <h2>PLIRIS</h2>
            </div>
            <div class="notification">
                <a href="notifications.php">
                    <img src="../../assets/images/bell.png" alt="Notification">
                </a>
            </div>
            <div class="menu">
                <img src="../../assets/images/menu.png" alt="Menu" onclick="toggleMenu()">
            </div>
            <div class="dropdown-menu">
                <h3>'.$id_number.'</h3>
                <ul>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li>
                        <form method="post">
                            <button type="submit" name="logout">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </header>';
}