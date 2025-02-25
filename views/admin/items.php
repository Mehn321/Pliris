<?php
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/admin/items.php';
include 'header.php';

$sessionManager = new SessionManager();
$sessionManager->checkAdminAccess();

$items = new ItemManager();
$itemsList = $items->getActiveItems();

text_head("Items");

if (isset($_POST['submit'])) {
    $items->updateItem($_POST['item_id'], $_POST['itemname'], $_POST['item_quantity']);
    $_SESSION['update_success'] = true;
    header('Location: items.php');
    exit;
}

if(isset($_SESSION['update_success'])) {
    echo "<div class='alert-notif green' id='alert_notif'>
            <p class='circle-exclamation-check green-check'>✓</p>
            Item Updated Successfully! 🎉
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('alert_notif').remove();
            }, 5000);
        </script>";
    unset($_SESSION['update_success']);
}

if (isset($_POST['delete'])) {
    $items->deleteItem($_POST['item_id']);
    echo "<div class='alert-notif green' id='alert_notif'>
            <p class='circle-exclamation-check green-check'>✓</p>
            Item Deleted Successfully! 🎉
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('alert_notif').remove();
            }, 5000);
        </script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Items</title>
    <link rel="stylesheet" href="../../assets/css/alert.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .edit-box {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            z-index: 1050;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,.075);
        }
    </style>
</head>
<body>
    <div class="container-fluid px-4 py-5">
        <!-- Search and Add Item Section -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchInput" class="form-control border-0 bg-light" placeholder="Search items...">
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <button class="btn btn-primary" onclick="showAddBox()">
                            <i class="bi bi-plus-lg me-2"></i>Add New Item
                        </button>
                    </div>
                </div>

                <!-- Rest of your existing table code -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4">Item Name</th>
                                        <th>Quantity</th>
                                        <th>Reservations</th>
                                        <th class="text-end px-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $items = $items->getActiveItems();
                                    while ($row = $items->fetch_assoc()) {
                                        $itemname = $row['item_name'];
                                        $item_quantity = $row['item_quantity'];
                                        $quantity_reserved = $row['total_item_reserved'];
                                        $item_id = $row['item_id'];

                                        echo "<tr>
                                            <td class='px-4'>$itemname</td>
                                            <td>$item_quantity</td>
                                            <td>$quantity_reserved</td>
                                            <td class='text-end px-4'>
                                                <button class='btn btn-sm btn-primary me-2' onclick='showEditBox(\"$itemname\", \"$item_quantity\", \"$item_id\")'>
                                                    <i class='bi bi-pencil'></i> Edit
                                                </button>
                                                <form method='post' class='d-inline'>
                                                    <input type='hidden' name='item_id' value='$item_id'>
                                                    <button type='submit' name='delete' class='btn btn-sm btn-danger' onclick=\"return confirm('Are you sure you want to delete $itemname?');\">
                                                        <i class='bi bi-trash'></i> Delete
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

            <script>
            // Add this to your existing JavaScript
            function showAddBox() {
                const addBox = document.createElement('div');
                addBox.className = 'edit-box card';
                addBox.innerHTML = `
                    <form action='items.php' method='post'>
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Add New Item</h5>
                            <button type="button" class="btn-close btn-close-white" onclick="this.parentElement.parentElement.parentElement.remove()"></button>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Item Name</label>
                                <input type="text" class="form-control" name="itemname" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="item_quantity" min="0" required>
                            </div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" name="add" class="btn btn-primary">Add Item</button>
                                <button type="button" class="btn btn-secondary" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">Cancel</button>
                            </div>
                        </div>
                    </form>
                `;
                document.body.appendChild(addBox);
            }

            document.getElementById('searchInput').addEventListener('keyup', function() {
                let filter = this.value.toLowerCase();
                let rows = document.querySelectorAll('tbody tr');
    
                rows.forEach(row => {
                    let itemName = row.querySelector('td').textContent.toLowerCase();
                    row.style.display = itemName.includes(filter) ? '' : 'none';
                });
            });
            </script>

<script>
// Add this to your existing JavaScript
function showAddBox() {
    const addBox = document.createElement('div');
    addBox.className = 'edit-box card';
    addBox.innerHTML = `
        <form action='items.php' method='post'>
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Add New Item</h5>
                <button type="button" class="btn-close btn-close-white" onclick="this.parentElement.parentElement.parentElement.remove()"></button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Item Name</label>
                    <input type="text" class="form-control" name="itemname" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control" name="item_quantity" min="0" required>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" name="add" class="btn btn-primary">Add Item</button>
                    <button type="button" class="btn btn-secondary" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">Cancel</button>
                </div>
            </div>
        </form>
    `;
    document.body.appendChild(addBox);
}

document.getElementById('searchInput').addEventListener('keyup', function() {
    let filter = this.value.toLowerCase();
    let rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        let itemName = row.querySelector('td').textContent.toLowerCase();
        row.style.display = itemName.includes(filter) ? '' : 'none';
    });
});
</script>
    <script>
    function showEditBox(itemname, quantity, itemId) {
        const editBox = document.createElement('div');
        editBox.className = 'edit-box card';
        editBox.innerHTML = `
            <form action='items.php' method='post'>
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Item</h5>
                    <button type="button" class="btn-close btn-close-white" onclick="this.parentElement.parentElement.parentElement.remove()"></button>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="itemname" value="${itemname}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="item_quantity" value="${quantity}" min="0" required>
                    </div>
                    <input type="hidden" name="item_id" value="${itemId}">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" onclick="this.parentElement.parentElement.parentElement.parentElement.remove()">Cancel</button>
                    </div>
                </div>
            </form>
        `;
        document.body.appendChild(editBox);
    }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


