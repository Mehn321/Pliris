<?php
    include("php/database.php");
    if(isset($_POST['login'])){
        $id_number = $_POST['id_number'];
        $password = $_POST['password'];
        $result = retrieve("*", "users", "id_number='999999999'");

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if($password==$row['password']){
                // login successful, start session and redirect to dashboard
                session_start();
                $_SESSION['id_admin'] = $id_number;
                header("Location: php/dashboard.php");
                exit;
            } else {
                $error = "Invalid password";
            }
        } else {
            $error = "ID number not found";
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>login form</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="wrapper">
        <h2>LOG IN</h2>
        <form action="index.php" method="post">
            <div class="input-box">
                <input type="text" name="id_number" placeholder="id number" required>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <?php if(isset($error)){ echo "<p style='color:red'>$error</p>"; } ?>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</body>
</html>