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
    <style>
        body {
    background: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    font-family: sans-serif;

}
body{
    background:url('images/physicslab.jpg') no-repeat;
    background:linear-gradient(29,38,113,0.😎,rgba(183,55,0.003));
    background-size: cover;
}

.wrapper {
  background: slategray;
  width: 320px;
  padding: 40px;
  border-radius: 10px;
  border:3px solid  rgba(255, 255, 255,  .2);
}

.wrapper h2 {
  text-align: center;
  margin-bottom: 30px;
  text-transform: uppercase;
}


 .input-box {
  position: relative;
  margin: 20px 0;
}

.input-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #333;
  border: none;
  border-radius: 40px;
  border-bottom: 1px solid #ddd;
  background: transparent;
  outline: none;
   }
  
.input-box input:focus {
  border-bottom: 1px solid #007bff;
}

.input-box input:placeholder {
  color: black;
}

.input-box label {
  position: absolute;
  top: 40px;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #333;
  pointer-events: none;
  transition: 0.5s;
}


.input-box input:focus{
  border-bottom-color: black;
}

.input-box input:valid ~ label {
  top: -15px;
  font-size: 12px;
  color: #007bff;
}

.remember-forgot {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

.remember-forgot label {
  font-size: 12px;
  color: #333;
}

.remember-forgot label input {
  accent-color: #007bff;
}

.btn {
  width: 100%;
  padding: 10px 0;
  font-size: 18px;
  color: #fff;
  background:#f39f5a;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn:hover {
  background: #f39f5a;
  
}

.register-link {
  text-align: center;
  margin-top: 20px;
}

.register-link p {
font-size: 14px;
color: #333;
}

.sign-in{
background-color:white;
border-color: rgb(41, 118, 211);
border-style: solid;
border-width: 1px;
color: rgb(41, 118, 211);
border-radius: 2px;
cursor: pointer;
margin-right:10px;
margin-left:5px;

}
.sign-in a{
font-style: none;
}

    </style>
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
            <p>Dont have an account? <a href="signup.php">Sign up</a></p>
        </div>
    </div>
</body>
</html>