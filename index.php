<?php
    include("Pliris-admin/php/database.php");

    if(isset($_POST['login'])){
        $id_number = $_POST['id_number'];
        $password = $_POST['password'];

        $result = retrieve("*", "accounts", "id_number='$id_number'");

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if($password==$row['password']){
                // login successful, start session and redirect to dashboard
                session_start();
                $_SESSION['id_number'] = $id_number;
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
    <title>Login</title>
    <link rel="stylesheet" href="css/signup-in.css">
</head>
<body>
    <div class="wrapper">
        <h2>LOG IN</h2>
        <form action="index.php" method="post">
            <div class="input-box">
                <input type="text" name="id_number" required>
                <label for="">id number</label>
            </div>
            <div class="input-box">
                <input type="password" name="password" required>
                <label for="">Password</label>
            </div>
            <?php if(isset($error)){ echo "<p style='color:red'>$error</p>"; } ?>
            <button type="submit" name="login" class="btn">Login</button>
        </form>
        <div class="register-link">
            <p>Dont have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</body>
</html>