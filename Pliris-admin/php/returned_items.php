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

    include("database.php");
    
    if(isset($_POST["submit"])){
        $reserve_id = $_POST["reserve_id"];

        // $sql = "SELECT * FROM reserved WHERE reserve_id='$reserve_id'";
        // $result = $conn->query($sql);
        $result=retrieve("*","reserved","reserve_id='$reserve_id'");
        
        $row=$result->fetch_assoc();
        $id=$row['id'];
        $id_number = $row['id_number'];
        $name_borrowed=retrieve("name,borrowed","items",$id);
        $name_borrowedrow=$name_borrowed->fetch_assoc();
        $itemname=$name_borrowedrow["name"];
        $quantity_returned = retrieve("quantity", "reserved", "reserve_id = '$reserve_id'");
        $quantity_returned_row = $quantity_returned->fetch_assoc();
        $quantity_returned = $quantity_returned_row['quantity'];
        $quantity_borrowed = $row['quantity'];
        $quantity_to_deduct = min($quantity_returned, $quantity_borrowed);
        $borrowed=$name_borrowedrow["borrowed"]-$quantity_to_deduct;
        $notification_type = "item_returned_approved";
        $quantity=$_POST['quantity'];
        date_default_timezone_set('Asia/Manila');
        $currentTime = date('M-d-Y H:i:s');
        $message = "Your returned item $itemname with the quantity of $quantity has been approved at $currentTime.";
        
        if($result->num_rows > 0) {
            // $update_stat = "UPDATE reserved SET return_stat='approved' WHERE reserve_id='$reserve_id'";
            // $conn->query($update_stat);
            // $update_borrowed = "UPDATE items SET borrowed='$borrowed' WHERE id='$id'";
            // $conn->query($update_borrowed);
            // $query = "INSERT INTO notifications (id_number, notification_type, message) VALUES ('$id_number', '$notification_type', '$message')";
            // mysqli_query($conn, $query);

            update("reserved", "return_stat='approved'","reserve_id='$reserve_id'");
            update("items", "borrowed='$borrowed'","id='$id'");
            insert("notifications", "id_number, notification_type, message","'$id_number', '$notification_type', '$message'");
            header("Location: returned_items.php");
        }


    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/items.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
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

            <h2>All Items Returned</h2>
        <div class="logout-container">
            <form action="" method="post">
            <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>

    </header>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>Borrower</th>
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Returned Time</th>
                <th>Action</th>
            </tr>
            <?php
                $returned=retrieve("*","returned", true);
                while ($row = $returned->fetch_assoc()) {
                    $reserve_id = $row['reserve_id'];
                    $returned_time = new DateTime($row['returned_time']);
                    $returned_time = $returned_time->format('M-d-Y H:i:s');
                    $reserved = retrieve("*", "reserved", "reserve_id = '$reserve_id'");
                    $row_reserved = $reserved->fetch_assoc();
                    $return_stat=$row_reserved['return_stat'];
                    $id_num=$row_reserved['id_number'];
                    $quantity = $row_reserved['quantity'];
                    $id = $row_reserved['id'];
                    $users=retrieve('first_name', 'users',"id_number = '$id_num'");
                    $row_users=$users->fetch_assoc();
                    $first_name=$row_users['first_name'];
                    $items = retrieve("name", "items", "id = $id");
                    $row_items = $items->fetch_assoc();
                    $itemname = $row_items['name'];
                    
                    if($return_stat=='approved'){
                        continue;
                    }
                    
                    echo "
                    <tr class='row-border'>
                        <td>$first_name</td>
                        <td>$itemname </td>
                        <td>$quantity</td>
                        <td>$returned_time</td>
                        
                        <form action='returned_items.php' method='post'>
                        <td>
                            <input type='hidden' name='quantity' value=$quantity>
                            <input type='hidden' name='reserve_id' value=$reserve_id>
                            <input type='submit' name='submit' value='approve'>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
            ?>
        </table>
    </div>

</body>
</html>

<?php

?>