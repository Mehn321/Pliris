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

    if(isset($_POST["reserve"])){
        $item_id = $_POST["item_id"];
        $scheduled_reserve_datetime=$_POST["scheduled_reserve_datetime"];
        $scheduled_return_datetime=$_POST["scheduled_return_datetime"];
        $quantity_toreserve = $_POST["quantity"];

        $conn=connect();
        // $sql = "SELECT * FROM reserved WHERE item_id = $item_id AND ((scheduled_reserve_datetime <= '$scheduled_reserve_datetime' AND scheduled_return_datetime >= '$scheduled_reserve_datetime') OR (scheduled_reserve_datetime <= '$scheduled_return_datetime' AND scheduled_return_datetime >= '$scheduled_return_datetime'))";
        // $result = $conn->query($sql);
        // $result=retrieve("*","reserved","item_id = $item_id AND ((scheduled_reserve_datetime <= '$scheduled_reserve_datetime' AND scheduled_return_datetime >= '$scheduled_reserve_datetime') OR (scheduled_reserve_datetime <= '$scheduled_return_datetime' AND scheduled_return_datetime >= '$scheduled_return_datetime'))");


        $availableAtTime= $_POST['availableAtTime'];
        if ($availableAtTime < $quantity_toreserve) {
            echo "<script>alert('Not enough items available at the desired time. Only $availableAtTime items are available. Please choose a different time or reduce the quantity.');</script>";
        }
        else{
            $borrowed += $quantity_toreserve;
            // $sql="UPDATE items SET borrowed=$borrowed WHERE item_id=$item_id";
            // if (!$conn->query($sql)) {
            //     echo "<script>alert('Failed to update items table.');</script>";
            // }
            update("items","borrowed=$borrowed","item_id=$item_id");

            // $reserve ="INSERT INTO reserved(`id_number`,`item_id`,`quantity`,`scheduled_reserve_datetime`,`scheduled_return_datetime`,`reservation_status`) values('$id_number','$item_id','$quantity_toreserve','$scheduled_reserve_datetime','$scheduled_return_datetime','borrowing' )";
            // if (!$conn->query($reserve)) {
            //     echo "<script>alert('Failed to insert into reserved table.');</script>";
            // }
            insert("reserved","`id_number`,`item_id`,`quantity_reserved`,`scheduled_reserve_datetime`,`scheduled_return_datetime`,`reservation_status`","'$id_number','$item_id','$quantity_toreserve','$scheduled_reserve_datetime','$scheduled_return_datetime','borrowing'");
            header("Location:reserve_item.php");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Item</title>
    <link rel="stylesheet" href="../css/reserve_reserved_item.css">
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
            <h2>All Items</h2>
        <div class="logout-container">
            <form action="" method="post">
            <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>

    </header>
    <div class="container">
        <form action="reserve_item.php" method="post">
            <p>Please submit first the date and time you want to borrow and return the item to show the list of items available at that time</p>
            <label>Borrow Time:</label>
            <input type="datetime-local" name="scheduled_reserve_datetime" required>
            <label>Return Time:</label>
            <input type="datetime-local" name="scheduled_return_datetime" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <table>
                <tr class="row-border">
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Reserved</th>
                    <th>Remaining</th>
                    <th>Action</th>
                </tr>
            
        <?php 
            if(isset($_POST["submit"])){ 
                $scheduled_reserve_datetime=$_POST["scheduled_reserve_datetime"];
                $scheduled_return_datetime=$_POST["scheduled_return_datetime"];
                $items=retrieve("*","items","item_status='active'");
                while($row=$items->fetch_assoc()){
                    $itemname = $row['item_name'];
                    $quantity = $row['item_quantity'];
                    $item_id = $row['item_id'];

                    $reserved=retrieve("*","reserved","item_id = '$item_id' AND reservation_status='borrowing' AND (((scheduled_reserve_datetime <= '$scheduled_reserve_datetime' AND scheduled_return_datetime >= '$scheduled_reserve_datetime') OR (scheduled_reserve_datetime >= '$scheduled_return_datetime' AND scheduled_return_datetime <= '$scheduled_return_datetime')) OR ((scheduled_reserve_datetime >= '$scheduled_reserve_datetime' AND scheduled_return_datetime <= '$scheduled_reserve_datetime') OR (scheduled_reserve_datetime >= '$scheduled_return_datetime' AND scheduled_return_datetime <= '$scheduled_return_datetime')))");
                    $borrowed_Quantity = 0;
                    while ($row2 = $reserved->fetch_assoc()) {
                        $borrowed_Quantity += $row2['quantity_reserved'];
                    }
                    $availableAtTime=$quantity - $borrowed_Quantity;
                    $borrowedAtTime = $borrowed_Quantity;
                
                // $items_reserved= joinTables("SUM(reserved.quantity_reserved) AS borrowed_Quantity, items.*", "reserved RIGHT JOIN items", "reserved.item_id = items.item_id AND reservation_status='borrowing' AND (((reserved.scheduled_reserve_datetime <= '$scheduled_reserve_datetime' AND reserved.scheduled_return_datetime >= '$scheduled_reserve_datetime') OR (reserved.scheduled_reserve_datetime >= '$scheduled_return_datetime' AND reserved.scheduled_return_datetime <= '$scheduled_return_datetime')) OR ((reserved.scheduled_reserve_datetime >= '$scheduled_reserve_datetime' AND reserved.scheduled_return_datetime <= '$scheduled_reserve_datetime') OR (reserved.scheduled_reserve_datetime >= '$scheduled_return_datetime' AND reserved.scheduled_return_datetime <= '$scheduled_return_datetime')))");
                // while ($row = $items_reserved->fetch_assoc()) {
                //     $borrowed_Quantity=$row['borrowed_Quantity'];
                //     $itemname = $row['item_name'];
                //     $quantity = $row['item_quantity'];
                //     $item_id = $row['item_id'];
                //     $availableAtTime=$quantity - $borrowed_Quantity;
                //     $borrowedAtTime = $borrowed_Quantity;
                    echo "
                    <tr class='row-border'>
                        <td class='itemname'>$itemname </td>
                        <td>$quantity</td>
                        <td>$borrowedAtTime</td>
                        <td>$availableAtTime</td>
                        <td>
                            <form action='reserve_item.php' method='post'>
                                <input type='hidden' name='item_id' value='$item_id'>
                                <input type='hidden' name='scheduled_reserve_datetime' value='$scheduled_reserve_datetime'>
                                <input type='hidden' name='scheduled_return_datetime' value='$scheduled_return_datetime'>
                                <input type='hidden' name='availableAtTime' value='$availableAtTime'>
                                <input type='number' name='quantity'  min='0' required>
                                <input type='submit' name='reserve' value='Reserve'>
                                
                            </form>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
        </table>
        
    </div>

</body>
</html>
