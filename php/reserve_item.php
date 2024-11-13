<?php
    session_start();
    $id_number = $_SESSION['id_number'];
    if (!isset($_SESSION['id_number'])) {
        header("Location: ../index.php");
        exit;
    }
    if (isset($_POST['logout'])) {
        unset($_SESSION['id_number']);
        header("Location: ../index.php");
        exit;
    }
    include("header.php");
    if (isset($_POST["submit"])) {
        $_SESSION['scheduled_reserve_datetime'] = $_POST["scheduled_reserve_datetime"];
        $_SESSION['scheduled_return_datetime'] = $_POST["scheduled_return_datetime"];
        header("Location: reserve_item.php");
    }

    if (isset($_POST["reserve"])) {
        $item_id = $_POST["item_id"];
        $scheduled_reserve_datetime = $_POST["scheduled_reserve_datetime"];
        $scheduled_return_datetime = $_POST["scheduled_return_datetime"];
        $quantity_toreserve = $_POST["quantity"];
        $availableAtTime = $_POST['availableAtTime'];

        if ($availableAtTime < $quantity_toreserve) {
            echo "<script>alert('Not enough items available at the desired time. Only $availableAtTime items are available. Please choose a different time or reduce the quantity.');</script>";
        } else {
            $borrowed_query = "SELECT item_quantity_reserved FROM items WHERE item_id = $item_id";
            $borrowed_result = $conn->query($borrowed_query);
            $row = $borrowed_result->fetch_assoc();
            $quantity_reserved = $row['item_quantity_reserved'] + $quantity_toreserve;

            $update_items_query = "UPDATE items SET item_quantity_reserved = $quantity_reserved WHERE item_id = $item_id";
            if (!$conn->query($update_items_query)) {
                echo "<script>alert('Failed to update items table.');</script>";
            }

            $reserve_query = "INSERT INTO reservations(id_number, item_id, reservation_status_ID, quantity_reserved, scheduled_reserve_datetime, scheduled_return_datetime) 
                            VALUES ('$id_number', '$item_id','1', '$quantity_toreserve', '$scheduled_reserve_datetime', '$scheduled_return_datetime')";
            if (!$conn->query($reserve_query)) {
                echo "<script>alert('Failed to insert into reservations table.');</script>";
            } else {
                header("Location: reserve_item.php");
            }
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
<?php
    text_head("Reserve Items", $id_number);
?>
<body>
    <div class="container">
        <form action="reserve_item.php" method="post">
            <p>Please submit first the date and time you want to borrow and return the item to show the list of items available at that time</p>
            <label>Reserve Time:</label>
            <input type="datetime-local" name="scheduled_reserve_datetime" value="<?php echo $_SESSION['scheduled_reserve_datetime']; ?>" required>
            <label>Return Time:</label>
            <input type="datetime-local" name="scheduled_return_datetime" value="<?php echo $_SESSION['scheduled_return_datetime']; ?>" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <table>
            <tr class="row-border">
                <th>Item Name</th>
                <th>Quantity</th>
                <th>Reserved</th>
                <th>Available</th>
                <th>Action</th>
            </tr>
            
        <?php

            if (isset($_SESSION["scheduled_reserve_datetime"]) && isset($_SESSION["scheduled_return_datetime"])) {
                $scheduled_reserve_datetime = $_SESSION["scheduled_reserve_datetime"];
                $scheduled_return_datetime = $_SESSION["scheduled_return_datetime"];
                if (strtotime($scheduled_reserve_datetime) >= strtotime($scheduled_return_datetime)) {
                    echo "<script>
                    alert('The scheduled reserve datetime must be earlier than the scheduled return datetime.');
                    window.location.href = 'reserve_item.php';
                    </script>";
                    exit;
                } else {
                    $query = "SELECT items.item_name, items.item_quantity, items.item_id, 
                            IFNULL(SUM(reservations.quantity_reserved), 0) AS borrowed_Quantity
                            FROM items
                            LEFT JOIN reservations ON items.item_id = reservations.item_id AND reservations.reservation_status_ID = 1 
                            AND (
                                (reservations.scheduled_reserve_datetime <= '$scheduled_reserve_datetime' AND reservations.scheduled_return_datetime >= '$scheduled_reserve_datetime') OR 
                                (reservations.scheduled_reserve_datetime <= '$scheduled_return_datetime' AND reservations.scheduled_return_datetime >= '$scheduled_return_datetime') OR
                                (reservations.scheduled_reserve_datetime <= '$scheduled_reserve_datetime' AND reservations.scheduled_return_datetime >= '$scheduled_return_datetime')
                            )
                            JOIN active_status ON items.active_status_ID = active_status.active_status_ID
                            WHERE active_status.active_stat = 'active' 
                            GROUP BY items.item_id";
                    $items_result = $conn->query($query);
                    while ($row = $items_result->fetch_assoc()) {
                        $itemname = $row['item_name'];
                        $quantity = $row['item_quantity'];
                        $item_id = $row['item_id'];
                        $borrowed_Quantity = $row['borrowed_Quantity'];
                        $availableAtTime = $quantity - $borrowed_Quantity;
                        echo "
                        <tr class='row-border'>
                            <td class='itemname'>$itemname </td>
                            <td>$quantity</td>
                            <td>$borrowed_Quantity</td>
                            <td>$availableAtTime</td>
                            <td>
                                <form action='reserve_item.php' method='post'>
                                    <input type='hidden' name='item_id' value='$item_id'>
                                    <input type='hidden' name='scheduled_reserve_datetime' value='$scheduled_reserve_datetime'>
                                    <input type='hidden' name='scheduled_return_datetime' value='$scheduled_return_datetime'>
                                    <input type='hidden' name='availableAtTime' value='$availableAtTime'>
                                    <input type='number' name='quantity' min='1' required>
                                    <input type='submit' name='reserve' value='Reserve'>
                                </form>
                            </td>
                        </tr>
                        ";
                    }
                }
            }

        ?>
        </table>
    </div>
</body>
</html>

