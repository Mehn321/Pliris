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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
                    $accounts=retrieve('username','accounts',"id_number='$id_number'");
                    $row_accounts=$accounts->fetch_assoc();
                    $username=$row_accounts['username'];
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
                // $all_items=retrieve('item_name','items', true);
                // $quantity_of_allitems=$all_items->num_rows;
                
                // not use if e join or dli kay walay connection or relationship
                $reserved=retrieve('reserve_id','reserved',"id_number='$id_number'  AND reservation_status='borrowing'");
                $borrowed_itemsquantity=$reserved->num_rows;
                // $notifications=retrieve('notif_id','notifications',"id_number='$id_number'");
                // $notifications_quantity=$notifications->num_rows;
                
            echo"
            <a href='reserve_item.php' class='red'><li><img src='../images/allitems.png' alt=''>Reserve item</li></a>
            <a href='reserved_items.php' class='blue'><li><img src='../images/borrow.png' alt=''>Reserved items: $borrowed_itemsquantity </li></a>
            <a href='notification.php' class='yellow'><li><img src='../images/notification.png' alt=''>Notifications</li></a>
            ";
            ?>
        </ul>
    </div>

</body>
</html>


