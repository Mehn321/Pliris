<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f7f7f7;
        }

        .sidebar {
            padding: 20px;
            padding-top: 0.5%;
            background-color: #333;
            width:15vw;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
            overflow-y: auto;
            max-height: 100vh;
            scrollbar-width: thin;
            scrollbar-color: #ccc;
            display: none;
        }

        .sidebar button {
            margin-top: 15px;
            margin-left: 0px ;
            background-color: #333;
        }

        .sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
            margin-left: 1px;
        }

        .sidebar a {
            color: #fff;
            text-decoration: none;
            font-size: 1.5vw;
        }

        .sidebar a:hover {
            color: #001572;
        }

        .sidebar ul li:hover {
            background-color: #555;
        }

    .navbar {
        background-color: #3498db; /* blue background */
        padding: 1em;
        width: 100%;
        display: flex;
        justify-content: space-between;
        position: relative;
        align-items: center;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        z-index: 1;
    }

    .menu {
        background-color: transparent;
        border: none;
        padding: 0px;
        width: 4vw;
    }


    .menu:hover {
        background-color: rgba(129, 211, 211, 0.542);
    }

    .navimg {
        display: flex;
        width: 5vw;
        padding: 0;
        border-radius: 7px;
        position: relative;
    }

    .navbar ul {
        list-style-type: none;
        display: flex;
    }

    .navbar ul li {
        margin-top: 0px;
        text-decoration: none;
        color: white;
        font-size: 3.5vw;
    }

    .logout-container {
        margin-right: 1vw;
    }

    .logout-container button {
        background-color: #fff;
        border: none;
        padding: 10px 2vw;
        font-size: 2vw;
        cursor: pointer;
        border-radius: 5px;
        color: #3498db; /* blue text */
    }

    .logout-container button:hover {
        background-color: #ccc;
    }

            
    .badge1 img{
        width: 4vw;
    }

    .badge1{
        display: flex;
        padding: 0;
        position: absolute;
        top: 25px;
    }

    .badge {
        background-color: red;
        border-radius: 100%;
        position: absolute;
        font-size: 1.2vw;
        top: 0.5px;
        right: 0.3vw;
        padding: 0.1px 0.6vw;
        color: white;
    }

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