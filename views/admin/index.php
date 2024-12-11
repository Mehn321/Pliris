<?php
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/shared/authentication.php';

$sessionManager = new SessionManager();
$auth = new Authentication($sessionManager);

if(isset($_POST['login'])){
    $result = $auth->handleAdminLogin($_POST["id_number"],$_POST["password"]);
    if($result['success']){
        header("Location: dashboard.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Physics Laboratory Item Reservation and Inventory System</title>
    <link rel="stylesheet" href="../../assets/css/signup-in.css">
</head>
<body>
    <div class="wrapper">
        <img src="../../assets/images/ustplogo.png" alt="USTP Logo">
        <h2>Physics Laboratory Item Reservation and Inventory System</h2>
        <h3>ADMIN</h3>
        <form action="" method="post">
            <div class="input-container">
                <input type="text" name="id_number" required>
                <label>Admin ID</label>
            </div>
            <div class="input-container">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>
            <input type="submit" name="login" value="Login" class="btn">
        </form>
    </div>
</body>
</html>
