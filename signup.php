<?php

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>signup</title>
    <style>
    .wrapper {
        width: 380px;
        background: #fff;
        border-radius: 15px;
        box-shadow: 0px 10px 50px rgba(0, 0, 0, 0.15);
        padding: 30px;
        margin: auto;
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        color: #000;
    }

    .input-box {
        position: relative;
        margin-bottom: 15px;
    }

    input {
        width: 100%;
        padding: 15px 0;
        border: 1px solid #000;
        outline: none;
        background: none;
        color: #000;
        font-size: 16px;
        letter-spacing: 1px;
        transition: 0.5s;
        border-radius: 5px;
    }

    label {
        position: absolute;
        top: 10px;
        left: 0;
        color: #000;
        pointer-events: none;
        transition: 0.5s;
        margin-left: 5px;
        margin-top: 5px;
    }

    input:focus ~ label,
    input:valid ~ label {
        top: -15px;
        font-size: 12px;
        color: #28a745;
    }

    input:focus {
        border-color: #28a745; 
    }

    .btn {
        width: 100%;
        padding: 15px 0;
        background: #28a745;
        color: #fff;
        border: none;
        outline: none;
        cursor: pointer;
        font-size: 16px;
        letter-spacing: 1px;
        border-radius: 5px;
    }

    .btn:hover {
        background: #218838;
    }

    p {
        text-align: center;
        margin-top: 20px;
        color: #000;
    }

    a {
        color: #28a745;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <h2>SIGN UP</h2>
    <form action="signup.php" method="post">
        <div class="input-box">
        <input type="text" name="first_name" placeholder="first name" required>
        </div>
        <div class="input-box">
            <input type="text" name="last_name" placeholder="last name " required>
        </div>
        <div class="input-box">
            <input type="text" name="id_number" placeholder="id number" required>
        </div>
        <div class="input-box">
            <input type="email" name="email" placeholder="email" required>
        </div>
        <div class="input-box">
            <input type="text" name="username" placeholder="username" required>
        </div>
        <div class="input-box">
            <input type="password" name="password" placeholder="create password" required>
        </div>
        <br>  
        <button type="submit" name="submit"
        class="btn">Submit</button>

    </form>
    <p>Already have an account? <a href="index.php">Login</a></p>

</body>

</html>

<?php
    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
        }
    if(isset($_POST['submit'])){
        $conn = connect();
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $id_number = $_POST['id_number'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $insert="INSERT INTO `users`(`first_name`, `last_name`, `id_number`, `email`, `username`, `password`) VALUES ('$first_name','$last_name','$id_number','$email','$username','$password')";
        if ($conn->query($insert) === TRUE) {
            header("Location: index.php");
        } else {
            echo "Error: " . $insert . "<br>" . $conn->error;
        }
        $conn->close();          
    }
?>