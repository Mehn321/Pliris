<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        /* Navbar Styles */
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

        .navbar {
            background-color: #3498db; /* blue background */
            padding: 1em;
            width: 100%;
            display: flex;
            justify-content: flex-end;
            position: relative;
            align-items: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1;
            justify-content: space-between;
        }

        .logout-container {
            margin-right: 20px;
        }

        .logout-container button {
            background-color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            color: #3498db; /* blue text */
        }

        .logout-container button:hover {
            background-color: #ccc;
        }

        .welcome {
            padding-left: 300px;
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
            z-index: 2;
            overflow-y: auto; /* or overflow-y: scroll; */
            max-height: 100vh;
            scrollbar-width: thin;
            scrollbar-color: #ccc;
        }

        .sidebar img {
            padding-left: 0px;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar li {
            margin-bottom: 10px;
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
    <header class="headerni">
        <nav class="navbar">
            <div class="welcome">
                <h3>Welcome, Admin :)</h3>
                
            </div>
            <div class="logout-container">
                
                <button>Log Out</button>
            </div>
            
        </nav>
    </header>
    <div class="sidebar">
        <ul>
            
            <img src="ustplogo.png" alt="ustp logo">
            <li><a href="#">Dashboard</a></li>
            <li><a href="seeAll_items.php">See All Items</a></li>
            <li><a href="#">Borrowed items</a></li>
            <li><a href="#">Returned items</a></li>
            <li><a href="add.php">Add Item</a></li>
            <li><a href="#">Remove Item</a></li>
            <li><a href="#">Users and Passwords</a></li>
            <li><a href="#">Notifications</a></li>
            
        </ul>
    </div>
</body>
</html>