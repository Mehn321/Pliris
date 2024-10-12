<?php   
    session_start();
    $id_number=$_SESSION['id_admin'];
    if (!isset($_SESSION['id_admin'])) {
        header("Location: ../index.php");
        exit;
    }
    if(isset($_POST['logout'])) {
        unset($_SESSION['id_admin']);
        header("Location: ../index.php");
        exit;
    }

    function connect(){
        $server="localhost";
        $username = "root";
        $password="";
        $db_name="mb_reserve";
        $conn = mysqli_connect($server,$username,$password,$db_name);
        return $conn;
    }

    function retrieve($column, $table){
        $conn=connect();
        $sql="SELECT $column FROM $table";
        $result=$conn->query($sql);
        return $result;
    }
    $accounts=retrieve("*","users");
    

    if(isset($_POST["submit"])){
        $conn=connect();
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $id_number = $_POST['id_number'];
        
            if(!empty($_POST["first_name"])){
                $first_name=$_POST['first_name'];
                $sql="UPDATE users SET first_name='$first_name' WHERE id_number='$id_number'";
                $conn->query($sql);
            }
            if(!empty($_POST["last_name"])){
                $last_name=$_POST['last_name'];
                $sql="UPDATE users SET last_name='$last_name' WHERE id_number='$id_number'";
                $conn->query($sql);
            }
            if(!empty($_POST["email"])){
                $email=$_POST['email'];
                $sql="UPDATE users SET email='$email' WHERE id_number='$id_number'";
                $conn->query($sql);
            }
            if(!empty($_POST["username"])){
                $username=$_POST['username'];
                $sql="UPDATE users SET username='$username' WHERE id_number='$id_number'";
                $conn->query($sql);
            }
            if(!empty($_POST["password"])){
                $password=$_POST['password'];
                $sql="UPDATE users SET password='$password' WHERE id_number='$id_number'";
                $conn->query($sql);
            }
        header("Location: accounts.php");
        mysqli_close($conn);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/accounts.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>
    <?php
        include("sidebar.php");
    ?>
    <header class="header">
        <nav class="navbar">
            <button class="menu" onclick=showsidebar()>
                <img src="../images/menuwhite.png" alt="menu"height="40px" width="45" >
            </button>
            <h2>All Accounts</h2>

        <div class="logout-container">
            <form action="" method="post">
                <button name="logout" value="logout">Log Out</button>
            </form>
        </div>
        </nav>

    </header>
    <div class="container">
    <table>
            <tr class="row-border">
                <th>First Name</th>
                <th>Last Name</th>
                <th>Id Number</th>
                <th>email</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
            <?php
                while($row=$accounts->fetch_assoc()){
                    $first_name = $row['first_name'];
                    $last_name = $row['last_name'];
                    $id_number = $row['id_number'];
                    $email = $row['email'];
                    $username=$row['username'];
                    $password=$row['password'];
                    if(isset($_POST["$id_number"])){
                        echo "
                        <tr class='row-border'>
                        <form action='accounts.php' method='post'>
                        <td>
                            $first_name
                            <input type='text' name='first_name'>
                        </td>
                        <td>
                            $last_name
                            <input type='text' name='last_name'>
                        </td>
                        <td>
                            $id_number
                            <input type='number' name='id_number'>
                        </td>
                        <td>
                            $email
                            <input type='email' name='email'>
                        </td>
                        <td>
                            $username
                            <input type='text' name='username'>
                        </td>
                        <td>
                            $password
                            <input type='text' name='password'>
                            <input type='hidden' name='id_number' value=$id_number>
                            <input type='submit' name='submit' value='submit'>
                        </td>
                        </form>
                    </tr>
                    ";
                    }
                    else{
                        echo "
                        <tr class='row-border'>
                        <td>$first_name </td>
                        <td>$last_name</td>
                        <td>$id_number</td>
                        <td>$email</td>
                        <td>$username</td>
                        <td>$password</td>
                        <form action='accounts.php' method='post'>
                        <td>
                            <input type='submit' name='$id_number' value='edit'>
                        </td>
                        </form>
                    </tr>
                    
                    ";
                    }
                }
            ?>
        </table>
    </div>

</body>
</html>

<?php

?>
