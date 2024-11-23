<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PLIRIS Login</title>
    <link rel="stylesheet" href="assets/css/signup-in.css">
</head>
<body>
    <?php
    require_once 'src/shared/database.php';
    require_once 'src/shared/SessionManager.php';
    require_once 'src/shared/authentication.php';

    $sessionManager = new SessionManager();
    $auth = new Authentication($sessionManager);

    if (isset($_POST['login'])) {
        $id_number = $_POST['id_number'];
        $password = $_POST['password'];
        $result = $auth->handleUserLogin($id_number, $password);
        if ($result['success']) {
            header("Location: views/user/dashboard.php");
            exit;
        }else{
            $_SESSION['error'] = $result['message'];
        }
    }
    ?>

    <div class="wrapper">
        <img src="assets/images/ustplogo.png" alt="ustp Logo">
        <h2>Welcome to PLIRIS</h2>
        <h3>Physics Laboratory Item Reservation and Inventory System</h3>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error-message">
                <?php 
                echo $_SESSION['error'];
                unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>
        
        <form action="index.php" method="post">
            <div class="input-box">
                <input type="text" name="id_number" pattern="[0-9]{}" required>
                <label>ID Number</label>
            </div>
            
            <div class="input-box">
                <input type="password" name="password" required>
                <label>Password</label>
            </div>

            <input type="submit" name="login" value="Login" class="btn">
            
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>