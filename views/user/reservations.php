<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reservation_accounts.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/shared/reservations.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->setRedirectPath("../../index.php");
    $sessionManager->checkUserAccess();
    $myReservations = new ReservationsManager($sessionManager);

    if(isset($_SESSION['cancellation_success'])){
        echo "<div class='alert-notif green' id='alert_notif'>
                    <p class='circle-exclamation-check green-check'>✓</p>
                    Reservation is Cancelled Successfully! 🎉
                </div>
                <script>
                    setTimeout(() => {
                        document.getElementById('alert_notif').remove();
                    }, 5000);
                </script>";
        unset($_SESSION['cancellation_success']);
    }
    if(isset($_SESSION["return_success"])){
        echo "<div class='alert-notif green' id='alert_notif'>
                    <p class='circle-exclamation-check green-check'>✓</p>
                    Your return is now being processed we will notify you if it will be approved or disaproved
                </div>
                <script>
                    setTimeout(() => {
                        document.getElementById('alert_notif').remove();
                    }, 10000);
                </script>";
        unset($_SESSION['return_success']);
    }
    if (isset($_POST['cancel'])) {
        date_default_timezone_set('Asia/Manila');
        echo strtotime($_POST['reserve_datetime']);
        echo time();
        if(strtotime($_POST['reserve_datetime'])<= time()) {
            echo "<div class='alert-notif red' id='alert_notif'>
            <p class='circle-exclamation-check red-exclamation'>!</p>
            You can't cancel an item you already borrowed.
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('alert_notif').remove();
            }, 10000);
        </script>";
        } else {
            $myReservations->cancelReservation($_POST['reserve_id'], $_POST['quantity_reserved'], $_POST['item_id']);
            $_SESSION['cancellation_success'] = true;
            header('Location: reservations.php');
            exit();
        }
    }

    if (isset($_POST['return'])) {
        $myReservations->returnItem($_POST['reserve_id']);
        $_SESSION['return_success'] = true;
        header("Location: reservations.php");
        exit();
    }
    text_head("Reservations");
    ?>

    <div class="container">
        <div class="table-wrapper">
            <table>
                <tr class="row-border">
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Reserved Schedule</th>
                    <th>Return Schedule</th>
                    <th>Action</th>
                </tr>
                <?php
                $reservations = $myReservations->getUserReservations();
                while ($row = $reservations->fetch_assoc()) {
                    $reserve_datetime = new DateTime($row['scheduled_reserve_datetime']);
                    $return_datetime = new DateTime($row['scheduled_return_datetime']);
                    echo "<tr class='row-border'>
                        <td>{$row['item_name']}</td>
                        <td>{$row['quantity_reserved']}</td>
                        <td>{$reserve_datetime->format('M-d-Y h:i:s A')}</td>
                        <td>{$return_datetime->format('M-d-Y h:i:s A')}</td>
                        <td><form action='' method='post'>
                                <input type='hidden' name='reserve_id' value='{$row['reserve_id']}'>
                                <input type='hidden' name='quantity_reserved' value='{$row['quantity_reserved']}'>
                                <input type='hidden' name='reserve_datetime' value='{$row['scheduled_reserve_datetime']}'>
                                <input type='hidden' name='item_id' value='{$row['item_id']}'>
                                <input type='submit' name='return' value='Return'>
                                <input type='submit' name='cancel' value='Cancel' onclick=\"return confirm('Are you sure you want to cancel this reservation?');\">
                            </form>
                        </td>
                        </tr>";
                    }
                    ?>
            </table>
        </div>
    </div>
</body>
</html>
