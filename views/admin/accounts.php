<!DOCTYPE html>
<ht lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../assets/css/accounts.css">
</head>
<body>
    <?php
    require_once '../../src/shared/database.php';
    require_once '../../src/shared/sessionmanager.php';
    require_once '../../src/admin/accounts.php';
    include 'header.php';

    $sessionManager = new SessionManager();
    $sessionManager->checkAdminAccess();


    $accounts = new AccountManager($sessionManager);
    $accountsList = $accounts->getAccounts();

    text_head("Accounts");
    
    if (isset($_POST['submit'])) {
        $last_name = $_POST['last_name'];
        $first_name = $_POST['first_name'];
        $middle_initial = $_POST['middle_initial'];
        $newID_number = $_POST['newID_number'];
        $oldID_number= $_POST['oldID_number'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        if($oldID_number==999999999){
            echo "<script>alert('you can not change the admin id number sorry');</script>";
        }else{
            $accounts->updateAccount($oldID_number,$newID_number, $last_name, $first_name, $middle_initial, $email, $password);
            header("Location: accounts.php");
        }
    }
    if (isset($_POST['delete'])) {
        $accounts->deleteAccount($_POST['id_number']);
    }
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
                        <th>Password</th>
                        <th>Action</th>
                    </tr>
                </thead>
                    <?php while($account = $accountsList->fetch_assoc()){
                        $last_name = $account['last_name'];
                        $first_name = $account['first_name'];
                        $middle_initial = $account['middle_initial'];
                        $id_number = $account['id_number'];
                        $email = $account['email'];
                        if(isset($_POST[$id_number])){
                            echo" 
                                <tr class='row-border'>
                                    <form action='' method='post'>
                                        <td><input type='text' name='last_name' value='$last_name'></td>
                                        <td><input type='text' name='first_name' value='$first_name'></td>
                                        <td><input type='text' name='middle_initial' value='$middle_initial'></td>
                                        <td><input type='number' name='newID_number' value='$id_number' max='99999999999'></td>
                                        <td><input type='email' name='email' value='$email'></td>
                                        <td><input type='password' name='password' placeholder='enter new password' value=''></td>
                                        <td><input type='submit' name='submit' value='submit'></td>
                                        <input type='hidden' name='oldID_number' value='$id_number'>
                                    </form>
                                </tr>
                                ";
                        }
                        else{echo "
                            <tr class='row-border'>
                                <td>". $account['last_name'] ."</td>
                                <td>". $account['first_name'] ."</td>
                                <td>". $account['middle_initial'] ."</td>
                                <td>". $account['id_number'] ."</td>
                                <td>". $account['email'] ."</td>
                                <td>*******</td>
                                
                                <td>
                                    <form action='' method='post'>
                                        <input type='submit' name='$account[id_number]' value='edit'>
                                        <input type='hidden' name='id_number' value='". $account['id_number'] ."'>
                                        <input type='submit' name='delete' value='delete'>
                                    </form>
                                </td>
                            </tr>";
                        }
                    }?>
            </table>
        </div>
    </div>
</body>
</html>
