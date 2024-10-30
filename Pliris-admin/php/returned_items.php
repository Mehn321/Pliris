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
    
    if(isset($_POST["approve"])){
        $reserve_id = $_POST["reserve_id"];

        // $sql = "SELECT * FROM reserved WHERE reserve_id='$reserve_id'";
        // $result = $conn->query($sql);
        $result=retrieve("*","reserved","reserve_id='$reserve_id'");
        $row=$result->fetch_assoc();
        $item_id=$row['item_id'];
        $id_number = $row['id_number'];
        $scheduled_reserve_datetime = $row['scheduled_reserve_datetime'];
        $return_time = $row['return_time'];

        $name_borrowed=retrieve("item_name,borrowed","items","item_id='$item_id'");
        $name_borrowedrow=$name_borrowed->fetch_assoc();
        $itemname=$name_borrowedrow["item_name"];

        $quantity_returned = retrieve("quantity_reserved", "reserved", "reserve_id = '$reserve_id'");
        $quantity_returned_row = $quantity_returned->fetch_assoc();
        $quantity_returned = $quantity_returned_row['quantity_reserved'];
        $quantity_borrowed = $row['quantity_reserved'];
        $quantity_to_deduct = min($quantity_returned, $quantity_borrowed);
        $borrowed=$name_borrowedrow["borrowed"]-$quantity_to_deduct;
        $notification_type = "item_returned_approved";
        $quantity_reserved=$_POST['quantity_reserved'];
        date_default_timezone_set('Asia/Manila');
        $currentTime = date('M-d-Y H:i:s');

        $accounts=retrieve('first_name, last_name', 'accounts',"id_number='$id_number'");
        $fullname_row=$accounts->fetch_assoc();
        $borrower_firstname=$fullname_row["first_name"];
        $borrower_lastname=$fullname_row["last_name"];


        $message = "Your returned item $itemname with the quantity_reserved of $quantity_reserved has been approved at $currentTime.";
        
        if($result->num_rows > 0) {
            // $update_stat = "UPDATE reserved SET return_status='approved' WHERE reserve_id='$reserve_id'";
            // $conn->query($update_stat);
            // $update_borrowed = "UPDATE items SET borrowed='$borrowed' WHERE item_id='$item_id'";
            // $conn->query($update_borrowed);
            // $query = "INSERT INTO notifications (id_number, notification_type, message) VALUES ('$id_number', '$notification_type', '$message')";
            // mysqli_query($conn, $query);

            insert("records", "`borrower_firstname`,`borrower_lastname`,`item`, `quantity`,`reserved_dateandtime`,`returned_dateandtime`","'$borrower_firstname','$borrower_lastname', '$itemname','$quantity_reserved','$scheduled_reserve_datetime','$return_time'");
            update("items", "borrowed='$borrowed'","item_id='$item_id'");
            insert("notifications", "id_number, notification_type, message","'$id_number', '$notification_type', '$message'");
            delete("reserved", "reserve_id='$reserve_id'");
            delete("returned", "reserve_id='$reserve_id'");
            header("Location: returned_items.php");
        }

    }
    if(isset($_POST["disaprove"])){
        $reserve_id = $_POST["reserve_id"];

        // $sql = "SELECT * FROM reserved WHERE reserve_id='$reserve_id'";
        // $result = $conn->query($sql);
        $result=retrieve("*","reserved","reserve_id='$reserve_id'");
        
        $row=$result->fetch_assoc();
        $item_id=$row['item_id'];
        $id_number = $row['id_number'];
        $name_borrowed=retrieve("item_name,borrowed","items",$item_id);
        $name_borrowedrow=$name_borrowed->fetch_assoc();
        $itemname=$name_borrowedrow["item_name"];
        $notification_type = "item_returned_approved";
        $quantity_reserved=$_POST['quantity_reserved'];
        date_default_timezone_set('Asia/Manila');
        $currentTime = date('M-d-Y H:i:s');
        
        $message = "Your returned item $itemname with the quantity of $quantity_reserved is disaproved at $currentTime. Please return the item/items or you can aproach the moderator Mr/Maam: $borrower_firstname $borrower_lastname.";
        update("reserved", "return_status='disaproved'","reserve_id='$reserve_id'");
        insert("notifications", "id_number, notification_type, message","'$id_number', '$notification_type', '$message'");
        header("Location: returned_items.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returned Items</title>
    <link rel="stylesheet" href="../css/items_records_reserved_returned.css">
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
                    $return_status=$row_reserved['return_status'];
                    $borrower_firstname=$row_reserved['id_number'];
                    $quantity_reserved = $row_reserved['quantity_reserved'];
                    $item_id = $row_reserved['item_id'];
                    $accounts=retrieve('first_name', 'accounts',"id_number = '$borrower_firstname'");
                    $row_users=$accounts->fetch_assoc();
                    $borrower_firstname=$row_users['first_name'];
                    $items = retrieve("item_name", "items", "item_id = $item_id");
                    $row_items = $items->fetch_assoc();
                    $itemname = $row_items['item_name'];
                    
                    if($return_status=='approved'||$return_status=='disaproved'){
                        continue;
                    }
                    
                    
                    
                    echo "
                    <tr class='row-border'>
                        <td>$borrower_firstname</td>
                        <td>$itemname </td>
                        <td>$quantity_reserved</td>
                        <td>$returned_time</td>
                        
                        <form action='returned_items.php' method='post'>
                        <td>
                            <input type='hidden' name='quantity_reserved' value=$quantity_reserved>
                            <input type='hidden' name='reserve_id' value=$reserve_id>
                            <input type='hidden' name='returned_time' value=$returned_time>

                            <input type='submit' name='approve' value='approve'>
                            <input type='submit' name='disaprove' value='disaprove'>
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