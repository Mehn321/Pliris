<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/alert.css">

</head>
<style>
    .edit-box-container {
    position: fixed;
    top: 60px;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1050;
    pointer-events: none;
    }

    .edit-box {
        position: relative;
        width: 400px;
        background: white;
        pointer-events: auto;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
    }

        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.075);
        }   
    </style>
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
    <div class="container-fluid px-4 py-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-0 bg-light" placeholder="Search reservations...">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4">Item Name</th>
                                        <th>Quantity</th>
                                        <th>Reserved Schedule</th>
                                        <th>Return Schedule</th>
                                        <th class="text-end px-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $reservations = $myReservations->getUserReservations();
                                    while ($row = $reservations->fetch_assoc()) {
                                        $reserve_datetime = new DateTime($row['scheduled_reserve_datetime']);
                                        $return_datetime = new DateTime($row['scheduled_return_datetime']);
                                        echo "<tr>
                                            <td class='px-4'>{$row['item_name']}</td>
                                            <td>{$row['quantity_reserved']}</td>
                                            <td>{$reserve_datetime->format('M-d-Y h:i:s A')}</td>
                                            <td>{$return_datetime->format('M-d-Y h:i:s A')}</td>
                                            <td class='text-end px-4'>
                                                <form action='' method='post' class='d-inline'>
                                                    <input type='hidden' name='reserve_id' value='{$row['reserve_id']}'>
                                                    <input type='hidden' name='quantity_reserved' value='{$row['quantity_reserved']}'>
                                                    <input type='hidden' name='reserve_datetime' value='{$row['scheduled_reserve_datetime']}'>
                                                    <input type='hidden' name='item_id' value='{$row['item_id']}'>
                                                    <button type='submit' name='return' class='btn btn-sm btn-success me-2'>
                                                        <i class='bi bi-arrow-return-left'></i> Return
                                                    </button>
                                                    <button type='submit' name='cancel' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to cancel this reservation?');\">
                                                        <i class='bi bi-x-circle'></i> Cancel
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.075);
        }   
    </style>

    <script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
