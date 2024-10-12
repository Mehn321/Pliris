<?php
    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = new mysqli($server,$username,$password,$db_name);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }

    function retrieve($column, $table, $condition){
        $conn=connect();
        $sql="SELECT $column FROM $table WHERE $condition";
        $result=$conn->query($sql);
        return $result;
    }

    if(isset($_POST['login'])){
        $id_number = $_POST['id_number'];
        $password = $_POST['password'];

        $result = retrieve("*", "users", "id_number='$id_number'");

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