<?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/user/reserve_item.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->setRedirectPath("../../index.php");
    $sessionManager->checkUserAccess();

    $reserveItem = new ReserveItemManager($sessionManager);
    text_head("Reserve Items");
    if (isset($_POST['reserve'])) {
        $quantity_toreserve = $_POST['quantity_toreserve'];
        $availableAtTime = $_POST['availableAtTime'];
        if($reserveItem->isquantityValid($quantity_toreserve, $availableAtTime)){
            $item_id = $_POST['item_id'];
            $user_id = $sessionManager->getUserId_number();
            $reserveItem-> createReservation($item_id, $quantity_toreserve, $user_id);
            echo "<script>
                    alert('Reservation successful!');
                    window.location.href = 'reserve_item.php';
                </script>";
            exit;
        }else{
            echo "<script>alert('Not enough items available at the desired time. Only $availableAtTime items are available. Please choose a different time or reduce the quantity.');</script>";
        }
    }

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Items</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reserved_returned.css">
</head>
<body>


    <div class="container">
        <?php
        $scheduled_reserve_datetime = (isset($_SESSION['scheduled_reserve_datetime'])) ? $_SESSION['scheduled_reserve_datetime'] : '';
        $scheduled_return_datetime = (isset($_SESSION['scheduled_return_datetime'])) ? $_SESSION['scheduled_return_datetime'] : '';
        if (isset($_POST["show_available_items"])) {
            $_SESSION['scheduled_reserve_datetime'] = $_POST["scheduled_reserve_datetime"];
            $_SESSION['scheduled_return_datetime'] = $_POST["scheduled_return_datetime"];
            $scheduled_reserve_datetime = $_POST["scheduled_reserve_datetime"];
            $scheduled_return_datetime = $_POST["scheduled_return_datetime"];
        }
        if (isset($_SESSION['scheduled_reserve_datetime'])) { 
            
            echo"
            <div class='form-section'>
            <form action='reserve_item.php' method='post'>
                <p>Select your preferred reservation and return times to view available items</p>
                <div class='form-group'>
                    <label>Reserve Time:</label>
                    <input type='datetime-local' name='scheduled_reserve_datetime'
                        value='$scheduled_reserve_datetime' required>
                </div>
                <div class='form-group'>
                    <label>Return Time:</label>
                    <input type='datetime-local' name='scheduled_return_datetime'
                        value='$scheduled_return_datetime' required>
                </div>
                <input class='showed' type='submit' name='show_available_items' value='Show Available Items' class='btn-submit'>
            </form>
        </div>
                    <div class='table-wrapper'>
                    <table>
                        <thead>
                            <tr class='row-border'>
                                <th>Item Name</th>
                                <th>Total Quantity</th>
                                <th>Reserved</th>
                                <th>Available</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                    ";
                    $items = $reserveItem->getAvailableItems();
                    while ($row = $items->fetch_assoc()) {
                        $itemname = $row['item_name'];
                        $quantity = $row['item_quantity'];
                        $item_id = $row['item_id'];
                        $availableAtTime = $reserveItem->calculateAvailableQuantity($item_id, $quantity);
                        $item_quantity_reserved = $reserveItem->getReservedQuantityAtTime($item_id);
                        echo "
                        <tr class='row-border'>
                            <td class='itemname'>$itemname </td>
                            <td>$quantity</td>
                            <td>$item_quantity_reserved</td>
                            <td>$availableAtTime</td>
                            <td>
                                <form action='reserve_item.php' method='post'>
                                    <input type='hidden' name='item_id' value='$item_id'>
                                    <input type='hidden' name='scheduled_reserve_datetime' value='$scheduled_reserve_datetime'>
                                    <input type='hidden' name='scheduled_return_datetime' value='$scheduled_return_datetime'>
                                    <input type='hidden' name='availableAtTime' value='$availableAtTime'>
                                    <input type='hidden' name='item_quantity_reserved' value='$item_quantity_reserved'>
                                    <input type='number' name='quantity_toreserve' min='0' required>
                                    <input type='submit' name='reserve' value='Reserve'>
                                </form>
                            </td>
                        </tr>";}
            echo "
                </tbody>
            </table>
        </div>";
        } else{
            echo'
            <div class="form-section">
            <form action="reserve_item.php" method="post">
                <p>Select your preferred reservation and return times to view available items</p>
                <div class="form-group">
                    <label>Reserve Time:</label>
                    <input type="datetime-local" name="scheduled_reserve_datetime" 
                        value="$scheduled_reserve_datetime" required>
                </div>
                <div class="form-group">
                    <label>Return Time:</label>
                    <input type="datetime-local" name="scheduled_return_datetime" value="$scheduled_return_datetime" required>
                </div>
                <input class="show" type="submit" name="show_available_items" value="Show Available Items" class="btn-submit">
            </form>
        </div>';
        }
        ?>
    </div>
</body>
</html>


