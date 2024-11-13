    <style scoped>
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
            position: fixed;
            top: 0;
            left: 0;
            width: 15vw;
            height: 100vh;
            background-color: #333;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 999;
            display: none;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            padding: 20px;
            overflow-y: auto;
        }

        .sidebar ul a {
            color: #fff;
            text-decoration: none;
            font-size: 1.5vw;
            display: block;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            color: #001572;
        }

        .sidebar ul button{
            margin-bottom: 15px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li:hover {
            background-color: #555;
        }

        .navbar {
            background-color: #3498db;
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
        }

        .menu:hover {
            background-color: rgba(129, 211, 211, 0.542);
        }

        .navbar img {
            width: 50px;
            border-radius: 7px;
        }

        .navbar ul {
            list-style-type: none;
            display: flex;
        }

        .navbar ul li {
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
            color: #3498db;
        }

        .logout-container button:hover {
            background-color: #ccc;
        }

        .badge1 img {
            width: 5vw !important;
        }

        .badge1 {
            display: flex !important;
            padding: 0 !important;
            position: absolute !important;
            top: 25px !important;
        }

        .badge {
            background-color: red;
            border-radius: 100px !important;
            position: absolute !important;
            font-size: 1.2vw !important;
            top: 0.5px !important;
            right: 0.4vw !important;
            padding: 0.1px 0.6vw !important;
            color: white !important;
        }
    </style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>
<?php
function text_head($welcomeMessage) {
    global $unseenNotifications, $conn, $id_number;
    
    $sql = "SELECT accounts.middle_initial, COUNT(CASE WHEN notifications.notification_status_id = '2' THEN 1 END) as unseenNotifications
            FROM accounts LEFT JOIN notifications ON accounts.id_number = notifications.id_number
            WHERE accounts.id_number = '$id_number'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $unseenNotifications = $row['unseenNotifications'];

    $result = retrieve("item_quantity", "items", true);
    while ($row = mysqli_fetch_assoc($result)) {
        $item_quantity = $row['item_quantity'];
        if ($item_quantity <= 10) {
            $unseenNotifications++;
        }
    }
    if($unseenNotifications > 9){
        $unseenNotifications = "9+";
    }
    
    echo '<header class="header">
        <nav class="navbar">
            <button class="menu" onclick="showsidebar()">
                <img src="../images/menuwhite.png" alt="menu" height="40px" width="45">
            </button>
            <img src="../images/ustplogo.png" alt="">
            <ul><li>' . $welcomeMessage . '</li></ul>
            <div class="notification">
                <a href="notification.php" class="badge1">
                    <img src="../images/bell.png" alt="">
                    <span class="badge">' . $unseenNotifications . '</span>
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
                    <img src="../images/menublue.png" alt="menu" height="40px" width="45px">
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
