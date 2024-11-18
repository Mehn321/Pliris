<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>

    </style>

</head>
    
    <?php
        include '../pliris-admin/php/database.php';
        $conn = connect();
        function text_head($header_text, $id_number) {
            global $conn;
            $unseenNotifications = $conn->query("SELECT COUNT(*) as total FROM notifications WHERE notification_status_id='2' AND id_number='$id_number'");
            $reserved = $conn->query("SELECT COUNT(*) as total FROM reservations 
            INNER JOIN reservation_status ON reservations.reservation_status_ID = reservation_status.reservation_status_ID 
            WHERE reservation_status.reservation_stat='reserving' AND reservations.id_number='$id_number' AND scheduled_return_datetime <= NOW()");
            $unseenNotifications_row = $unseenNotifications->fetch_assoc();
            $reserved_row = $reserved->fetch_assoc();
            $total = $reserved_row['total'];
            $unseenNotifications = $unseenNotifications_row['total'];
            $total_Notifications = $unseenNotifications + $total;
            if ($total_Notifications > 9) {
                $total_Notifications = "9+";
            }

            echo '
            <header class="header">
                <nav class="navbar">
                    <button class="menu" onclick="showsidebar()">
                        <img src="../images/menuwhite.png" alt="menu" class="menu">
                    </button>
                    <img src="../images/ustplogo.png" alt="" class="navimg">
                    <ul>
                        <li>' .$header_text.'</li>
                    </ul>
                    <ul>
                        <li><a href="notification.php" class="badge1"><img src="../images/bell.png" alt=""><span class="badge">' . $total_Notifications . '</span></a></li>
                    </ul>
                    <div class="logout-container">
                        <form action="" method="post">
                            <button name="logout" value="logout">Log Out</button>
                        </form>
                    </div>
                </nav>

                <div class="sidebar">
                    <ul>
                        <button class="menu" onclick=hidesidebar()>
                            <img src="../images/menublue.png" alt="menu" class="menu">
                        </button>
                        <a href="dashboard.php"><li>Dashboard</li></a>
                        <a href="reserve_item.php"><li>Reserve Item</li></a>
                        <a href="reserved_items.php"><li>Reserved Items</li></a>
                        <a href="notification.php"><li>Notifications</li></a>
                        
                    </ul>
                </div>
            </header>
            ';
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
        sidebar.style.display = 'flex';
    }
</script>
<?php ob_end_flush(); ?>