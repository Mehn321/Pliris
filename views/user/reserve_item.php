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
    <div class="px-2">
        <div class="container-fluid py-5 border rounded-3 mt-4 bg-light shadow-sm">
            <?php if ($scheduled_reserve_datetime && $scheduled_return_datetime): ?>
                <div class="row justify-content-center">
                    <div class="col-md-12 col-lg-12">
                        <form action="reserve_item.php" method="post" class="bg-white p-4 rounded-3 shadow-sm mb-4">
                            <h4 class="text-primary mb-4">Select Reservation Schedule</h4>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Reserve Time</label>
                                    <input class="form-control" type="datetime-local" name="scheduled_reserve_datetime" value="<?= $scheduled_reserve_datetime ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Return Time</label>
                                    <input class="form-control" type="datetime-local" name="scheduled_return_datetime" value="<?= $scheduled_return_datetime ?>" required>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" name="show_available_items" class="btn btn-primary">Update Available Items</button>
                            </div>
                        </form>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            Available Items from <?= date('F j, Y g:i A', strtotime($scheduled_reserve_datetime)) ?> to <?= date('F j, Y g:i A', strtotime($scheduled_return_datetime)) ?>
                        </div>

                        <form action="reserve_item.php" method="post" id="reserveForm">
                            <div class="card shadow-sm">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Total Quantity</th>
                                                <th>Available</th>
                                                <th>Reserve Quantity</th>
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
                                            echo "
                                            <tr>
                                                <td class='text-start'>$itemname</td>
                                                <td class='align-middle'>$quantity</td>
                                                <td class='align-middle'><span class='badge bg-success'>$availableAtTime</span></td>
                                                <td style=''>
                                                    <input type='hidden' name='item_ids[]' value='$item_id'>
                                                    <input type='hidden' name='availableAtTime[]' value='$availableAtTime'>
                                                    <input type='number' class='form-control mx-auto' style='text-decoration: none;' name='quantity_toreserve[]' min='0' max='$availableAtTime'>
                                                </td>
                                            </tr>";
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <input type="hidden" name="scheduled_reserve_datetime" value="<?= $scheduled_reserve_datetime ?>">
                            <input type="hidden" name="scheduled_return_datetime" value="<?= $scheduled_return_datetime ?>">
                            
                            <div class="mt-2" style="z-index: 1000; width: 50vw;">
                                <button type="submit" name="reserve" class="btn btn-primary btn-lg position-fixed" style="font-size: 1.5vw; bottom: 40px; right: 25px" >
                                    <i class="bi bi-calendar-check me-2"></i>Reserve Selected Items
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            <?php else: ?>
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card shadow-sm">
                            <div class="card-body p-4">
                                <h4 class="card-title text-primary mb-4">Schedule Your Reservation</h4>
                                <form action="reserve_item.php" method="post">
                                    <div class="mb-3">
                                        <label class="form-label">Reserve Time</label>
                                        <input class="form-control" type="datetime-local" name="scheduled_reserve_datetime" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Return Time</label>
                                        <input class="form-control" type="datetime-local" name="scheduled_return_datetime" required>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" name="show_available_items" class="btn btn-primary">
                                            Show Available Items
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
