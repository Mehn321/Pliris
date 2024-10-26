<?php
    // function connect(){
    //     $server="localhost";
    //     $username = "root";
    //     $password="";
    //     $db_name="pliris";
    //     $conn = mysqli_connect($server,$username,$password,$db_name);
    //     return $conn;
    //     }
    
    if(isset($_POST['submit'])){
        
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $id_number = $_POST['id_number'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        // $insert="INSERT INTO `users`(`first_name`, `last_name`, `id_number`, `email`, `username`, `password`) VALUES ('$first_name','$last_name','$id_number','$email','$username','$password')";
        // if ($conn->query($insert) === TRUE) {
        //     header("Location: index.php");
        // } else {
        //     echo "Error: " . $insert . "<br>" . $conn->error;
        // }
        // $conn->close(); 
        include("Pliris-admin/php/database.php");
        $result=retrieve("*","users","id_number='$id_number'");
        if (mysqli_num_rows($result)  > 0) {
            // ID number already exists
            $adminname = retrieve("*", "users", "id_number='999999999'");
            $row = $adminname->fetch_assoc();
            $adminfname=$row['first_name'];
            $adminlname=$row['last_name'];
            echo "<script>alert('Error: ID Number already exists. If you already have an account but you forgot your password please aproach Sir/Maam: $adminfname $adminlname.')</script>";
        }
        else{
            insert("users","first_name, last_name, id_number, email, username, password","'$first_name','$last_name','$id_number','$email','$username','$password'");
            header("Location: index.php");
        }
    }
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>signup</title>
    <link rel="stylesheet" href="css/signup-in.css">
</head>

<body>
    <div class="wrapper">
    <h1>SIGN UP</h1>
        <form action="signup.php" method="post">
        <div class="input-box">
        <input type="text" name="first_name" required>
        <label for="">First Name</label>
        </div>
        <div class="input-box">
            <input type="text" name="last_name" required>
            <label for="">Last Name</label>
        </div>
        <div class="input-box">
            <input type="number" name="id_number" step="1" required>
            <label for="">ID Number</label>
        </div>
        <div class="input-box">
            <input type="email" name="email" required >
            <label for="">Email</label>
        </div>
        <div class="input-box">
            <input type="text" name="username" required>
            <label for="">Username</label>
        </div>
        <div class="input-box">
            <input type="text" name="password" required >
            <label for="">Create Password</label>
        </div>
        <br>  
        <input type="submit" name="submit" value="submit" class="btn">
        </form>
        <p>Already have an account? <a href="index.php">Login</a></p>
    </div>

</body>

</html>
