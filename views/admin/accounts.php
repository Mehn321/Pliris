<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/items_records_reserved_returned.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/SessionManager.php';
    require_once '../../src/admin/accounts.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();
    $sessionManager->handleLogout();


    $accounts = new AccountManager();
    $accountsList = $accounts->getAccounts();

    text_head("Accounts", $sessionManager->getAdminId());

    $accounts->handleFormSubmission();
    ?>

    <div class="container">
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr class="row-border">
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Initial</th>
                        <th>ID Number</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($account = $accountsList->fetch_assoc()){
                        echo "
                        <tr class='row-border'>
                            <td>". $account['last_name'] ."</td>
                            <td>". $account['first_name'] ."</td>
                            <td>". $account['middle_initial'] ."</td>
                            <td>". $account['id_number'] ."</td>
                            <td>". $account['email'] ."</td>
                            
                            <td>
                                <form action='' method='post'>
                                    <input type='submit' name='edit' value='edit'>
                                    <input type='hidden' name='id_number' value='". $account['id_number'] ."'>
                                    <input type='submit' name='delete' value='delete'>
                                </form>
                            </td>
                        </tr>";
                    }?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
</html>
