<?php
    session_start();
    $id_number=$_SESSION['id_number'];
    if (!isset($_SESSION['id_number'])) {
        header("Location: ../index.php");
        exit;
    }
    if(isset($_POST['logout'])) {
        unset($_SESSION['id_number']);
        header("Location: ../index.php");
        exit;
    }
    include("../Pliris-admin/php/database.php");
    
    $all_items=retrieve('name','items', true);
    $quantity_of_allitems=$all_items->num_rows;
    $borrowed=retrieve('reserve_id','reserved',"id_number='$id_number'  AND return_stat='borrowing'");
    $borrowed_itemsquantity=$borrowed->num_rows;
    $notifications=retrieve('notif_id','notifications',"id_number='$id_number'");
    $notifications_quantity=$notifications->num_rows;
    
    $accounts=retrieve('username','users',"id_number='$id_number'");
    $row_accounts=$accounts->fetch_assoc();
    $username=$row_accounts['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
    <?php
        include("sidebar.php");
    ?>
    <header class="header">
        <nav class="navbar">
            <button class="menu" onclick=showsidebar()>
                <img src="../images/menuwhite.png" alt="menu"height="40px" width="45" >
            </button>
            <img src="../images/ustplogo.png" alt="">
            <ul>
                <?php
                echo"<li>Welcome $username :)</li>";
                ?>
            </ul>
        <div class="logout-container">
            <form action="" method="post">
            <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>
    </header>


    <div class="box">
        <ul>
            <?php

            echo"
            <a href='reserve_item.php' class='red'><li><img src='../images/allitems.png' alt=''>Reserve item</li></a>
            <a href='borrowed_items.php' class='blue'><li><img src='../images/borrow.png' alt=''>Borrowed items: $borrowed_itemsquantity </li></a>
            <a href='notification.php' class='yellow'><li><img src='../images/notification.png' alt=''>Notifications : $notifications_quantity</li></a>
            ";
            ?>
        </ul>
    </div>

</body>
</html>


