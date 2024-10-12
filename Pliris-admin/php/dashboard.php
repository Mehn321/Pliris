<?php
    session_start();
    $id_number=$_SESSION['id_admin'];
    if (!isset($_SESSION['id_admin'])) {
        header("Location: ../index.php");
        exit;
    }
    if(isset($_POST['logout'])) {
        unset($_SESSION['id_admin']);
        header("Location: ../index.php");
        exit;
    }

    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }
    function retrieve($column, $table, $where){
        $conn=connect();
        $sql="SELECT $column FROM $table WHERE $where";
        $result=$conn->query($sql);
        return $result;
    }
    $all_items=retrieve('name','items', true);
    $quantity_of_allitems=$all_items->num_rows;
    $borrowed=retrieve('reserve_id','reserved',"return_stat='borrowing'");
    $borrowed_itemsquantity=$borrowed->num_rows;
    $notifications=retrieve('notif_id','notifications',"id_number='$id_number'");
    $notifications_quantity=$notifications->num_rows;
    $returned_items=retrieve('reserve_id','reserved',"return_stat='pending_return'");
    $returned_items_quantity=$returned_items->num_rows;
    $accounts=retrieve('id_number','users',true);
    $accounts_quantity=$accounts->num_rows;

    $result=retrieve("*","items",true);
    while ($row = mysqli_fetch_assoc($result)){
        $name=$row['name'];
        $quantity=$row['quantity'];
        $notifications_quantity=0;
        if($quantity<=10){
            $notifications_quantity++;
        }
    }
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
                
                <li>Welcome :) </li>
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
            <a href='seeAll_items.php' class='red'><li><img src='../images/allitems.png' alt=''>All Items: $quantity_of_allitems </li></a>
            <a href='borrowed_items.php' class='blue'><li><img src='../images/borrow.png' alt=''>Borrowed items: $borrowed_itemsquantity </li></a>
            <a href='returned_items.php' class='green'><li><img src='../images/return.png' alt=''>Returned Items:$returned_items_quantity </li></a>
            <a href='add.php' class='purple'><li><img src='../images/add.png' alt=''>Add Items </li></a>
            <a href='accounts.php' class='pink'><li><img src='../images/accounts.png' alt=''>Accounts : $accounts_quantity</li></a>
            <a href='records.php' class='brown'><li><img src='../images/records.png' alt=''>Records</li></a>
            <a href='notification.php' class='yellow'><li><img src='../images/notification.png' alt=''>Notifications : $notifications_quantity</li></a>
            ";
            ?>
        </ul>
    </div>

</body>
</html>


