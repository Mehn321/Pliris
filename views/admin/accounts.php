<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accounts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/alert.css">
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
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/admin/accounts.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();

    $accounts = new AccountManager();
    $accountsList = $accounts->getAccounts();

    if (isset($_POST['submit'])) {
        $update_acc = $accounts->updateAccount(
            $_POST['oldID_number'],
            $_POST['newID_number'],
            $_POST['last_name'],
            $_POST['first_name'],
            $_POST['middle_initial'],
            $_POST['email'],
            $_POST['password']
        );
        if($update_acc){
            $_SESSION['update_success'] = true;
            header('Location: accounts.php');
            exit;
        }
    }

    include 'header.php';
    text_head("Accounts");

    if(isset($_SESSION['update_success'])){
        echo "<div class='alert-notif green' id='alert_notif'>
            <p class='circle-exclamation-check green-check'>✓</p>
            Account Updated Successfully! 🎉
        </div>
        <script>
            setTimeout(() => {
                document.getElementById('alert_notif').remove();
            }, 5000);
        </script>";
        unset($_SESSION['update_success']);
    }

    if (isset($_POST['delete'])) {
        $accounts->deleteAccount($_POST['id_number']);
        echo "<div class='alert-notif green' id='alert_notif'>
            <p class='circle-exclamation-check green-check'>✓</p>
            Account Deleted Successfully! 🎉
        </div>";
    }
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
                            <input type="text" id="searchInput" class="form-control border-0 bg-light" placeholder="Search accounts...">
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="px-4">Last Name</th>
                                        <th>First Name</th>
                                        <th>Middle Initial</th>
                                        <th>ID Number</th>
                                        <th>Email</th>
                                        <th>Password</th>
                                        <th class="text-end px-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while($account = $accountsList->fetch_assoc()){ ?>
                                        <tr>
                                            <td class="px-4"><?php echo $account['last_name']; ?></td>
                                            <td><?php echo $account['first_name']; ?></td>
                                            <td><?php echo $account['middle_initial']; ?></td>
                                            <td><?php echo $account['id_number']; ?></td>
                                            <td><?php echo $account['email']; ?></td>
                                            <td>*******</td>
                                            <td class="text-end px-4">
                                                <button class="btn btn-sm btn-primary me-2" onclick="showEditBox('<?php echo $account['last_name']; ?>', '<?php echo $account['first_name']; ?>', '<?php echo $account['middle_initial']; ?>', '<?php echo $account['id_number']; ?>', '<?php echo $account['email']; ?>')">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                                <form method="post" class="d-inline">
                                                    <input type="hidden" name="id_number" value="<?php echo $account['id_number']; ?>">
                                                    <button type="submit" name="delete" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete the account of <?php echo $account['first_name'] . ' ' . $account['last_name']; ?>?');">
                                                        <i class="bi bi-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function showEditBox(lastName, firstName, middleInitial, idNumber, email) {
        const container = document.createElement('div');
        container.className = 'edit-box-container';
        const editBox = document.createElement('div');
        editBox.className = 'edit-box card';
        editBox.innerHTML = `
            <form action="" method="post">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Account</h5>
                    <button type="button" class="btn-close btn-close-white" onclick="this.closest('.edit-box-container').remove()"></button>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="last_name" value="${lastName}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">First Name</label>
                        <input type="text" class="form-control" name="first_name" value="${firstName}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Middle Initial</label>
                        <input type="text" class="form-control" name="middle_initial" value="${middleInitial}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID Number</label>
                        <input type="number" class="form-control" name="newID_number" value="${idNumber}" max="99999999999" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="${email}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter new password">
                    </div>
                    <input type="hidden" name="oldID_number" value="${idNumber}">
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" onclick="this.closest('.edit-box-container').remove()">Cancel</button>
                    </div>
                </div>
            </form>
        `;
        container.appendChild(editBox);
        document.body.appendChild(container);
    }
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