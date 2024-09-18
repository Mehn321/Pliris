<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <?php
        include("sidebar.php");
    ?>
    <header class="header">
        <nav class="navbar">
            <button class="menu" onclick=showsidebar()>
                <img src="menuwhite.png" alt="menu"height="40px" width="45" >
            </button>
            <img src="ustplogo.png" alt="">
            <ul>
                
                <li>Welcome :) </li>
            </ul>
        <div class="logout-container">
            <button>Log Out</button>
        </div>
        </nav>
    </header>

    <div class="container">
        <div class="box">
            <ul>
                <a href="seeAll_items.php" class="red"><li><img src="allitems.png" alt="">All Items: 0</li></a>
                <a href="#" class="blue"><li><img src="borrow.png" alt="">Borrowed items: 0</li></a>
                <a href="#" class="yellow"><li><img src="notification.png" alt="">Notifications : 0</li></a>
            </ul>
        </div>
        <!-- <div class="box">
            All Items: 0
        </div>
        <div class="box">
            Borrowed Items: 0
        </div>
        <div class="box">
            Returned Items: 0
        </div>
        <div class="box">
            notifications: 0
        </div> -->




    </div>
</body>
</html>


