<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

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
            background-color: #f7f7f7; /* light gray background */
        }
        
        /* Sidebar Styles */

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

    </style>

</head>
<body>
    <div class="sidebar">
        <ul>
            
            <button class="menu" onclick=hidesidebar()>
                <img src="../images/menublue.png" alt="menu" height="40px" width="45px">
            </button>
            <a href="dashboard.php"><li>Dashboard</li></a>
            <a href="items.php"><li>Items</li></a>
            <a href="borrowed_items.php"><li>Borrowed items</li></a>
            <a href="returned_items.php"><li>Returned items</li></a>
            <a href="add.php"><li>Add Items</li></a>
            <a href="accounts.php"><li>Accounts</li></a>
            <a href="records.php"><li>Records</li></a>
            <a href="notification.php"><li>Notifications</li></a>
            
        </ul>
    </div>
</body>
</html>

<script>
    function hidesidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.display = 'none';
    }
</script>

<script>
    function showsidebar() {
        const sidebar = document.querySelector('.sidebar');
        sidebar.style.display = 'flex';
    }
</script>
