<?php
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/user/reserve_item.php';
include 'header.php';

$sessionManager = new SessionManager();
$sessionManager->setRedirectPath("../../index.php");
$sessionManager->checkUserAccess();

$reserveItem = new ReserveItemManager();
text_head("Reserve Items");

if (isset($_POST['reserve'])) {
    $result = $reserveItem->processMultipleReservations(
        $_POST['item_ids'],
        $_POST['quantity_toreserve'],
        $_POST['availableAtTime'],
        $sessionManager->getUserId_number()
    );
    if($result['success']) {
        $_SESSION['reserve_success'] = true;
        header('Location: reserve_item.php');
        exit;
    } else{
        echo "<div class='alert-notif red' id='alert_notif'>
                    <p class='circle-exclamation-check red-exclamation'>!</p>
                    Reservation Unsuccessful: {$result['message']} 
                </div>
                <script>
                    setTimeout(() => {
                        document.getElementById('alert_notif').remove();
                    }, 5000);
                </script>";
    }
}

    if(isset($_SESSION['reserve_success'])) {
        echo "<div class='alert-notif green' id='alert_notif'>
                    <p class='circle-exclamation-check green-check'>✓</p>
                    Items Reserved Successfully! 🎉
                </div>
                <script>
                    setTimeout(() => {
                        document.getElementById('alert_notif').remove();
                    }, 5000);
                </script>";
        unset($_SESSION['reserve_success']);
    }
    
    if(isset($_SESSION['scheduled_reserve_datetime'])){
        $scheduled_reserve_datetime = $_SESSION['scheduled_reserve_datetime'];
    } else {
        $scheduled_reserve_datetime = '';
    }

    if(isset($_SESSION['scheduled_return_datetime'])){
        $scheduled_return_datetime = $_SESSION['scheduled_return_datetime'];
    }else{
        $scheduled_return_datetime = '';
    }

    if(isset($_POST["show_available_items"])){
        date_default_timezone_set('Asia/Manila');
        if (strtotime($_POST["scheduled_return_datetime"]) > strtotime($_POST["scheduled_reserve_datetime"]) && strtotime($_POST["scheduled_return_datetime"]) >= time() && strtotime($_POST["scheduled_reserve_datetime"]) >= time()) {
            $_SESSION['scheduled_reserve_datetime'] = $_POST["scheduled_reserve_datetime"];
            $_SESSION['scheduled_return_datetime'] = $_POST["scheduled_return_datetime"];
            $scheduled_reserve_datetime = $_POST["scheduled_reserve_datetime"];
            $scheduled_return_datetime = $_POST["scheduled_return_datetime"];
        }elseif(strtotime($_POST["scheduled_return_datetime"]) < time() || strtotime($_POST["scheduled_reserve_datetime"]) < time()){
            echo "<div class='alert-notif red' id='alert_notif'>
                    <p class='circle-exclamation-check red-exclamation'>!</p>
                    Invalid Time: Your Schedule Must Be earlier than Current Time
                </div>
                <script>
                    setTimeout(() => {
                        document.getElementById('alert_notif').remove();
                    }, 10000);
                </script>";
        }else{
            echo "<div class='alert-notif red' id='alert_notif'>
                    <p class='circle-exclamation-check' red-exclamation>!</p>
                    Invalid Time: Return time must be after reserve time
            </div>
                <script>
                    setTimeout(() => {
                        document.getElementById('alert_notif').remove();
                    }, 10000);
                </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Items</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reservation_accounts.css">
</head>
<body>
    <div class="container">
        <?php if ($scheduled_reserve_datetime && $scheduled_return_datetime): ?>
            <div class='form-section'>
                <form action='reserve_item.php' method='post'>
                    <p>Select your preferred reservation and return times to view available items</p>
                    <div class='form-group'>
                        <label>Reserve Time:</label>
                        <input class="datetime-container" type='datetime-local' name='scheduled_reserve_datetime' value='<?= $scheduled_reserve_datetime ?>' required>
                    </div>
                    <div class='form-group'>
                        <label>Return Time:</label>
                        <input class="datetime-container" type='datetime-local' name='scheduled_return_datetime' value='<?= $scheduled_return_datetime ?>' required>
                    </div>
                    <input class='showed' type='submit' name='show_available_items' value='Show Available Items'>
                </form>
                <div class='reservation-datetime'>Available Items from <?= date('F j, Y g:i A', strtotime($scheduled_reserve_datetime)) ?> to <?= date('F j, Y g:i A', strtotime($scheduled_return_datetime)) ?></div>
            </div>
            <form action='reserve_item.php' method='post' id='reserveForm'>
                <div class='table-wrapper'>
                    <table>
                        <thead>
                            <tr class='row-border'>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Available</th>
                                <th>Quantity to Reserve</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $items = $reserveItem->getAvailableItems();
                        while ($row = $items->fetch_assoc()) {
                            $itemname = $row['item_name'];
                            $quantity = $row['item_quantity'];
                            $item_id = $row['item_id'];
                            $availableAtTime = $reserveItem->calculateAvailableQuantity($item_id, $quantity);
                            $item_quantity_reserved = $reserveItem->getReservedQuantityAtTime($item_id);
                            echo "
                            <tr class='row-border'>
                                <td class='itemname'>$itemname</td>
                                <td>$quantity</td>
                                <td>$availableAtTime</td>
                                <td>
                                    <input type='hidden' name='item_ids[]' value='$item_id'>
                                    <input type='hidden' name='availableAtTime[]' value='$availableAtTime'>
                                    <input type='number' name='quantity_toreserve[]' min='0'>
                                </td>
                            </tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <input type='hidden' name='scheduled_reserve_datetime' value='<?= $scheduled_reserve_datetime ?>'>
                <input type='hidden' name='scheduled_return_datetime' value='<?= $scheduled_return_datetime ?>'>
                <input type='submit' name='reserve' value='Reserve Selected Items' class='reserve-button'>
            </form>
        <?php else: ?>
            <div class="form-section">
                <form action="reserve_item.php" method="post">
                    <p>Select your preferred reservation and return times to view available items</p>
                    <div class="form-group">
                        <label>Reserve Time:</label>
                        <input class="datetime-container" type="datetime-local" name="scheduled_reserve_datetime" value="<?= $scheduled_reserve_datetime ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Return Time:</label>
                        <input class="datetime-container" type="datetime-local" name="scheduled_return_datetime" value="<?= $scheduled_return_datetime ?>" required>
                    </div>
                    <input class="show" type="submit" name="show_available_items" value="Show Available Items" class="btn-submit">
                </form>
            </div>
        <?php endif;?>
    </div>
</body>
</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
