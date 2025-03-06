<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returned Items</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/alert.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/admin/returned_items.php';
    require_once '../../src/admin/notifications.php';
    include 'header.php';
    
    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();

    $returnedItemsManager = new ReturnedItemsManager();
    $returnedList = $returnedItemsManager->getReturnedItems();
    $notificationManager= new AdminNotificationsManager();

    if (isset($_POST['approve'])) {
        $reserve_id = $_POST['reserve_id'];
        $item_id=$_POST['item_id'];
        $id_number = $_POST['id_number'];
        $quantity_reserved = $_POST['quantity_reserved'];
        $returnedItemsManager->approveReturn($reserve_id);
        $returnedItemsManager->createRecord($reserve_id);
        $notificationManager->createApprovalNotification($_POST['id_number'], $_POST['item_name'], $quantity_reserved);
        header("Location: returned_items.php");
        exit();
    }
    
    if (isset($_POST['disapprove'])) {
        $reserve_id = $_POST['reserve_id'];
        $quantity_reserved = $_POST['quantity_reserved'];
        $returnedItemsManager->disapproveReturn($reserve_id);
        $notificationManager->createDisapprovalNotification($_POST['id_number'], $_POST['item_name'], $quantity_reserved);
        header("Location: returned_items.php");
        exit();
    }

    text_head("Returned Items");
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
                            <input type="text" id="searchInput" class="form-control border-0 bg-light" placeholder="Search returned items...">
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
                                        <th>Returned at</th>
                                        <th class="text-end px-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($returned_item = $returnedList->fetch_assoc()){
                                        $reserve_datetime = new DateTime($returned_item['scheduled_reserve_datetime']);
                                        $returned_datetime = new DateTime($returned_item['returned_datetime']);
                                        echo "<tr>
                                            <td class='px-4'>". $returned_item['first_name'] ." ". $returned_item['last_name'] ."</td>
                                            <td>". $returned_item['item_name'] ."</td>
                                            <td>". $returned_item['quantity_reserved'] ."</td>
                                            <td>". $reserve_datetime->format('M-d-Y h:i:s:a') ."</td>
                                            <td>". $returned_datetime->format('M-d-Y h:i:s:a') ."</td>
                                            <td class='text-end px-4'>
                                                <form method='post' class='d-inline'>
                                                    <input type='hidden' name='id_number' value='{$returned_item['id_number']}'>
                                                    <input type='hidden' name='item_name' value='{$returned_item['item_name']}'>
                                                    <input type='hidden' name='quantity_reserved' value='{$returned_item['quantity_reserved']}'>
                                                    <input type='hidden' name='reserve_id' value='{$returned_item['reserve_id']}'>
                                                    <input type='hidden' name='item_id' value='{$returned_item['item_id']}'>
                                                    <button type='submit' name='approve' class='btn btn-sm btn-success me-2'>
                                                        <i class='bi bi-check-circle'></i> Approve
                                                    </button>
                                                    <button type='submit' name='disapprove' class='btn btn-sm btn-danger'>
                                                        <i class='bi bi-x-circle'></i> Disapprove
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
