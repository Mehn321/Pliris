<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/alert.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/shared/reservations.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();

    $admin_id_number = $sessionManager->getAdminId();
    $reservedItems = new ReservationsManager($sessionManager);

    if (isset($_POST['return'])) {
        $reservedItems->returnItem($_POST['reserve_id']);
        echo "<div class='alert-notif green' id='alert_notif'>
                <p class='circle-exclamation-check green-check'>✓</p>
                Item Returned Successfully! 🎉
            </div>
            <script>
                setTimeout(() => {
                    document.getElementById('alert_notif').remove();
                }, 5000);
            </script>";
    }

    text_head("Reserved Items");
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
                                        <th class="px-4">Borrower</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                        <th>Reserved Schedule</th>
                                        <th>Return Schedule</th>
                                        <th class="text-end px-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $reservedList = $reservedItems->getReservations();
                                    while($item = $reservedList->fetch_assoc()){
                                        $reserve_datetime = new DateTime($item['scheduled_reserve_datetime']);
                                        $return_datetime = new DateTime($item['scheduled_return_datetime']);
                                        echo "<tr>
                                            <td class='px-4'>". $item['first_name']." ". $item['last_name'] ."</td>
                                            <td>". $item['item_name'] ."</td>
                                            <td>". $item['quantity_reserved'] ."</td>
                                            <td>". $reserve_datetime->format('M-d-Y h:i:s:a') ."</td>
                                            <td>". $return_datetime->format('M-d-Y h:i:s:a') ."</td>
                                            <td class='text-end px-4'>
                                                <form method='post' class='d-inline'>
                                                    <input type='hidden' name='reserve_id' value='". $item['reserve_id'] ."'>
                                                    <button type='submit' name='return' class='btn btn-sm btn-success'>
                                                        <i class='bi bi-check-circle'></i> Return
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>";
                                    }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            let borrowerName = row.querySelector('td').textContent.toLowerCase();
            let itemName = row.querySelectorAll('td')[1].textContent.toLowerCase();
            row.style.display = (borrowerName.includes(filter) || itemName.includes(filter)) ? '' : 'none';
        });
    });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
