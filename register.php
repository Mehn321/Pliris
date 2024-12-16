<?php
require_once 'src/shared/database.php';
require_once 'src/shared/sessionmanager.php';
require_once 'src/shared/authentication.php';

$sessionManager = new SessionManager();
$auth = new Authentication($sessionManager);

if(isset($_POST['submit'])){
    $result = $auth->handleRegistration($_POST);
    if($result['success']){
        header("Location: views/user/dashboard.php");
        exit;
    }else{
        $message = $result['message'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Physics Laboratory Item Reservation and Inventory System</title>
    <link rel="stylesheet" href="assets/css/signup-in.css">
</head>
<body>
    <div class="wrapper">
        <img src="assets/images/ustplogo.png" alt="USTP Logo">
        <h2>Physics Laboratory Item Reservation and Inventory System</h2>
        <h3>PLIRIS</h3>
        <?php if (isset($message)): ?>
            <div class="error-message">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="input-container">
                <input type="text" name="first_name" required>
                <label>First Name</label>
            </div>
            <div class="input-container">
                <input type="text" name="last_name" required>
                <label>Last Name</label>
            </div>
            <div class="input-container">
                <input type="text" name="middle_initial" maxlength="1">
                <label>Middle Initial</label>
            </div>
            <div class="input-container">
                <input type="number" name="id_number" required>
                <label>ID Number</label>
            </div>
            <div class="input-container">
                <input type="email" name="email" required>
                <label>Email</label>
            </div>
            <div class="input-container">
                <input type="password" name="password" id="passwordField1" required>
                <label>Create Password</label>
                <span class="togglePassword" id="togglePassword1">👁</span>
            </div>
            <div class="input-container">
                <input type="password" name="confirm_password" id="passwordField2" required>
                <label>Confirm Password</label>
                <span class="togglePassword" id="togglePassword2">👁</span>
            </div>

            <input type="submit" name="submit" value="Sign Up" class="btn">
        </form>
        <p>Already have an account? <a href="index.php">Login</a></p>
    </div>
</body>
</html>
<script>
    const togglePassword1 = document.querySelector('#togglePassword1');
    const togglePassword2 = document.querySelector('#togglePassword2');
    const password1 = document.querySelector('#passwordField1');
    const password2 = document.querySelector('#passwordField2');

    togglePassword1.addEventListener('click', function () {
        const type = password1.getAttribute('type') === 'password' ? 'text' : 'password';
        password1.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁' : '👁‍🗨';
    });

    togglePassword2.addEventListener('click', function () {
        const type = password2.getAttribute('type') === 'password' ? 'text' : 'password';
        password2.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁' : '👁‍🗨';
    });
</script>
