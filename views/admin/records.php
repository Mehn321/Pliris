<?php
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/admin/records.php';
include 'header.php';

$sessionManager = new SessionManager();
$sessionManager->checkAdminAccess();

$records = new RecordsManager();
$recordsList = $records->getAllRecords();

// Group records by year and month
$groupedRecords = [];
foreach($recordsList as $record) {
    $return_date = new DateTime($record['returned_datetime']);
    $yearMonth = $return_date->format('Y-m');
    $groupedRecords[$yearMonth][] = $record;
}

text_head("Records");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/alert.css">
</head>
<body>
    <div class="container-fluid px-4 py-5">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-center mb-4">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-0 bg-light" placeholder="Search records...">
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="generate_pdf.php" class="btn btn-primary">
                            <i class="bi bi-file-pdf"></i> Export to PDF
                        </a>
                    </div>
                </div>
                <?php foreach($groupedRecords as $yearMonth => $monthRecords): 
                    $date = DateTime::createFromFormat('Y-m', $yearMonth);
                ?>
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><?= $date->format('F Y') ?></h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th class="px-4">Name</th>
                                            <th>Item Name</th>
                                            <th>Quantity</th>
                                            <th>Reserved Schedule</th>
                                            <th>Returned At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($monthRecords as $record): 
                                            $reserve_datetime = new DateTime($record['scheduled_reserve_datetime']);
                                            $return_datetime = new DateTime($record['returned_datetime']);
                                        ?>
                                            <tr>
                                                <td class="px-4"><?= $record['first_name'] ?> <?= $record['last_name'] ?></td>
                                                <td><?= $record['item_name'] ?></td>
                                                <td><?= $record['quantity_reserved'] ?></td>
                                                <td><?= $reserve_datetime->format('M-d-Y h:i:s:a') ?></td>
                                                <td><?= $return_datetime->format('M-d-Y h:i:s:a') ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

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