<?php
require_once '../../src/shared/database.php';
require_once '../../src/shared/sessionmanager.php';
require_once '../../src/shared/authentication.php';

$sessionManager = new SessionManager();
$auth = new Authentication($sessionManager);

$message;
if(isset($_POST['login'])){
    $result = $auth->handleAdminLogin($_POST["id_number"],$_POST["password"]);
    if($result['success']){
        header("Location: dashboard.php");
        exit;
    }else{
        $message= $result['message'];
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
        <h2>Welcome ADMIN</h2>
        <h3>Physics Laboratory Item Reservation and Inventory System</h3>
        <?php if (isset($message)): ?>
            <div class="error-message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="input-container">
                <input type="text" name="id_number" required>
                <label>Admin ID</label>
            </div>
            <div class="input-container">
                <input type="password" name="password" id="passwordField" required>
                <label>Password</label>
                <span id="togglePassword">👁</span>
            </div>
            <input type="submit" name="login" value="Login" class="btn">
        </form>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#passwordField');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.textContent = type === 'password' ? '👁' : '👁‍🗨';
        });
    </script>
</body>
</html>
